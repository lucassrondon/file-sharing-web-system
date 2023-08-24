<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\User;
use App\Models\Institution;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
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
