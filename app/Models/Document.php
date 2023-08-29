<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\User;
use App\Models\Institution;
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
        'title',
        'description',
        'size',
        'mime_type',
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
        array $newDocumentData, 
        array $newTagsNames, 
        array $tagsToDeleteIds
    )
    {
        try {
            DB::beginTransaction();

            // Update document in database
            $this->update($newDocumentData);

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

            return Storage::disk('local')->download($filePath);
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

    /* Method to upload a document */
    public static function uploadDocument(
        array $documentData, 
        string|null $institution, 
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
            if ($institution != null && strlen($institution) > 0) {
                $documentModel->institution_id = Institution::getInstitutionId($institution);
                $documentModel->save();
            }
            
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
