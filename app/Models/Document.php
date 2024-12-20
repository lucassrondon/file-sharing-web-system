<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\User;
use App\Models\Institution;
use App\Models\Subject;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'institution_id',
        'subject_id',
        'title',
        'description',
        'size',
        'mime_type',
        'text_content',
        'file_name',
        'downloads',
    ];

    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    /* Methods for livewire components */

    /* Method to get the file extension */
    public function getExtension()
    {
        $array = explode('.', $this->file_name);
        $extension = $array[count($array)-1];

        return $extension;
    }

    /* Method to update a document */
    public function updateDocument(
        string $title,
        string $description,
        string $institutionName,
        string $subjectName,
        array $newTagsNames, 
        array $tagsToDeleteIds
    )
    {
        try {
            DB::beginTransaction();

            // Getting the id of the institution, which can be null
            if ($institutionName == '' || $institutionName == null) {
                $institutionId = null;
            } else {
                $institutionId = Institution::getInstitutionId($institutionName);
            }

            // Getting the id of the subject, which can be null
            if ($subjectName == '' || $subjectName == null) {
                $subjectId = null;
            } else {
                $subjectId = Subject::getSubjectId($subjectName);
            }

            // Update document in database
            $this->update([
                'title' => $title,
                'description' => $description,
                'institution_id' => $institutionId,
                'subject_id' => $subjectId,
            ]);

            // Delete tags
            Tag::whereIn('id', $tagsToDeleteIds)->delete();

            // Inserting new tags
            Tag::insertTags($this->id, $newTagsNames);

            DB::commit();

        } catch (\Exception $ex) {
            DB::rollBack();
            throw $ex;
        }
    }

    /* 
    Method to download document
    Link explaining download with livewire:
    https://laravel-livewire.com/docs/2.x/file-downloads
    */
    public function download()
    {
        try {
            $filePath = $this->file_name;
            $suggestedFilename = $this
                ->sanitizeFilename($this->title);

            return Storage::disk('local')
                ->download(
                    $filePath, 
                    $suggestedFilename
                );
        } catch (\Exception $ex) {
            abort(500, 'File not found');
        }
    }

    /*
    Deletes de document metadata from the database
    and deletes the file from the storage 
     */
    public function deleteDocumentFromAll()
    {
        try {
            DB::beginTransaction();

            $documentPath = $this->file_name;
            $this->delete();

            if (Storage::disk('local')->delete($documentPath)) {
                DB::commit();
            } else {
                throw new Exception('Unable to delete file'); 
            }
        } catch (\Exception $ex) {
            DB::rollBack();
            throw $ex;
        }
    }

    /* Converts filesize to human readable format */
    public function formatFilesize()
    {
        $decimals = 2;

        $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
        $factor = floor((strlen($this->size) - 1) / 3);

        return sprintf("%.{$decimals}f", $this->size / pow(1024, $factor)) . @$size[$factor];
    }

    /* Converts the create_at to a more friendly format */
    public function formatCreatedAt()
    {
        $date = date_create($this->created_at);
        return date_format($date,"d/m/Y");
    }

    /* Sanitizing a string to be a valid filename */
    public function sanitizeFilename($filename) 
    {   
        /* 
        Goes through a string and if the character is numeric
        or is alpha, adds to the valid filename. If the character
        is not valid, replaces it by '_' if the last character is not
        '_' already
        */
        $suggestedFilename = '';
        foreach (str_split($filename) as $char) {
            if (ctype_alpha($char) || is_numeric($char)) {
                $suggestedFilename = $suggestedFilename . $char;
            } elseif (strlen($suggestedFilename) > 0) {
                if ($suggestedFilename[strlen($suggestedFilename)-1] != '_') {
                    $suggestedFilename = $suggestedFilename . '_';
                }
            }

            if (strlen($suggestedFilename) >= 50) {
                break;
            }
        }

        if ($suggestedFilename == '' || strlen($suggestedFilename) < 3) {
            $suggestedFilename = 'document';
        }
        return $suggestedFilename;
    }

    public function getTags()
    {
        return Tag::where('document_id', $this->id)->get();
    }

    public static function search($filters)
    {
        $query = self::query();

        // If the "any" field is not empty, search across all fields
        if (!empty($filters['any'])) {
            $any = $filters['any'];
            $query->where(function ($q) use ($any) {
                $q->where('title', 'LIKE', "%{$any}%")
                ->orWhere('description', 'LIKE', "%{$any}%")
                ->orWhereHas('subject', function ($subQuery) use ($any) {
                    $subQuery->where('subject_name', 'LIKE', "%{$any}%");
                })
                ->orWhere('mime_type', 'LIKE', "%{$any}%")
                ->orWhere('text_content', 'LIKE', "%{$any}%")
                ->orWhereHas('institution', function ($subQuery) use ($any) {
                    $subQuery->where('institution_name', 'LIKE', "%{$any}%");
                })
                ->orWhereHas('tags', function ($subQuery) use ($any) {
                    $subQuery->where('name', 'LIKE', "%{$any}%");
                });
            });
        } else {
            // Apply specific filters if "any" is empty
            if (!empty($filters['title'])) {
                $query->where('title', 'LIKE', "%{$filters['title']}%");
            }

            if (!empty($filters['description'])) {
                $query->where('description', 'LIKE', "%{$filters['description']}%");
            }

            if (!empty($filters['institution'])) {
                $query->whereHas('institution', function ($subQuery) use ($filters) {
                    $subQuery->where('institution_name', 'LIKE', "%{$filters['institution']}%");
                });
            }

            if (!empty($filters['subject'])) {
                $query->whereHas('subject', function ($subQuery) use ($filters) {
                    $subQuery->where('subject_name', 'LIKE', "%{$filters['subject']}%");
                });
            }

            if (!empty($filters['mimeType'])) {
                $query->where('mime_type', $filters['mimeType']);
            }

            if (!empty($filters['startDate'])) {
                $query->whereDate('created_at', '>=', $filters['startDate']);
            }

            if (!empty($filters['tag'])) {
                $query->whereHas('tags', function ($subQuery) use ($filters) {
                    $subQuery->where('name', 'LIKE', "%{$filters['tag']}%");
                });
            }

            if (!empty($filters['searchInText'])) {
                $query->where('text_content', 'LIKE', "%{$filters['searchInText']}%");
            }
        }

        // Paginate and return results
        $paginator = $query->paginate(12);
        $paginator->useTailwind();

        return $paginator;
    }


/*     public static function search($searchText)
    {
        $paginator = Self::where('title', 'LIKE', "%{$searchText}%")
            ->orWhereHas('institution', function ($query) use ($searchText) {
                $query->where('institution_name', 'LIKE', "%{$searchText}%");
            })
            ->orWhereHas('tags', function ($query) use ($searchText) {
                $query->where('name', 'LIKE', "%{$searchText}%");
            })->paginate(10);
            
        $paginator->useTailwind();
        return $paginator;
    } */

    /* Method to upload a document */
    public static function uploadDocument(
        array $documentData, 
        string|null $institution,
        string|null $subject,
        array $tags
    )
    {
        try {
            // Begins a transaction
            DB::beginTransaction();

            // Create a Document Model and set its attributes
            $documentModel = self::create($documentData);

            // If any name is passed as the institution of the file,
            // this gets the id and save in the document.
            if ($institution != null && $institution != '') {
                $documentModel->institution_id = Institution::getInstitutionId($institution);
            }
            if ($subject != null && $subject != '') {
                $documentModel->subject_id = Subject::getSubjectId($subject);
            }

            $documentModel->save();
            
            // Inserting tags in database
            Tag::insertTags($documentModel->id, $tags);

            // Commit changes
            DB::commit();
        }
        catch (\Exception $ex) {
            // Rollback changes
            DB::rollBack();
            throw $ex;
        }
    }
}
