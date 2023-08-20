<?php

namespace App\Models;

use App\Models\Document;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    /* Insert an array of tags for a document */
    public static function insertTags(int $documentId, array $tagsNames)
    {
        // Setting up tags array to insert
        $dbTags = [];
        foreach ($tagsNames as $tagName) {
            $dbTags[] = [
                'document_id' => $documentId,
                'name' => $tagName,
            ];
        }
        // Inserting tags in database
        Tag::insert($dbTags);
    }
}
