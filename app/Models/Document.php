<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;

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

    public function user()
    {
        return $this->belongsTo(User::class);
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
    public static function uploadDocument(array $documentData, array $tags)
    {
        try {
            // Begins a transaction
            DB::beginTransaction();

            // Create a Document Model and set its attributes
            $documentModel = self::create($documentData);
            
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
