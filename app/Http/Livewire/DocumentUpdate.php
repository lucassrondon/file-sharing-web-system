<?php

namespace App\Http\Livewire;

use App\Models\Tag;
use Livewire\Component;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;

class DocumentUpdate extends Component
{
    public $document;
    public $title;
    public $description;
    public $tagsToDeleteIds = [];
    public $tagsThatExist;
    public $tagsToInsert = [];
    public $tag;

    /* Tryng to get the document passed in the url */
    public function mount(Document $document)
    {
        // Gets the user class
        $user = Auth::user();
        $this->document = $document;
        $this->tagsThatExist = Tag::where('document_id', $this->document->id)->get();

        // Checks if document belongs to user
        if ($this->document->user_id != $user->id) {
            abort(404, 'Post not found');
        } else {
            $this->title = $document->title;
            $this->description = $document->description;
        }
    }

    /* Method to insert a new tag to the tag insertion array */
    public function addTag()
    {
        // Validation rules for the new tag
        $this->validate([
            'tag' => 'between:1,255',
        ]);

        if (count($this->tagsThatExist) + count($this->tagsToInsert) >= 5) {
            abort(500, 'Something went wrong.');
        } else {
            $this->tagsToInsert[] = $this->tag;
        }
        $this->tag = null;
    }

    /* Remove a tag from the insertion array */
    public function removeTagFromInsertList($index)
    {
        unset($this->tagsToInsert[$index]);
    }

    /* 
    Add the id of a tag that already exists
    in the deletion array, so they can be deleted
    if the update is saved 
    */
    public function addTagToDeleteList(int $tagToDeleteId)
    {
        foreach ($this->tagsThatExist as $key => $tag) {
            if ($tag->id == $tagToDeleteId) {
                $this->tagsToDeleteIds[] = $tagToDeleteId;
                unset($this->tagsThatExist[$key]);
                break;
            }
        }
    }

    public function update()
    {
        // Validation rules for the document and its metadata
        $this->validate([
            'title' => 'required|between:1,255',
            'description' => 'max:255',
        ]);

        try {
            // Update document in database
            $newDocumentData = [
                'title' => $this->title,
                'description' => $this->description,
            ];

            $this->document->updateDocument(
                $newDocumentData, 
                $this->tagsToInsert, 
                $this->tagsToDeleteIds
            );

            // Resetting the properties
            $this->tagsToDeleteIds = [];
            $this->tagsToInsert = [];
            $this->tagsThatExist = Tag::where('document_id', $this->document->id)->get();
            
            session()->flash('successMessage', 'Updated successfully.');

        } catch (\Exception $ex) {
            abort(500, 'Something went wrong.');
        }
    }

    public function render()
    {
        return view('livewire.document-update');
    }
}
