<?php

namespace App\Http\Livewire;

use App\Models\Tag;
use Livewire\Component;
use App\Models\Document;
use App\Models\Institution;
use Illuminate\Support\Facades\Auth;

class DocumentUpdate extends Component
{
    public $document;
    public $title;
    public $description;
    public $institution;
    public $tagsThatExist;
    public $tagsToDeleteIds = [];
    public $tagsToInsert = [];
    public $tag;
    public $databaseInstitutions;

    /* Tryng to get the document passed in the url */
    public function mount(Document $document)
    {
        // Gets the user class
        $user = Auth::user();
        $this->document = $document;

        // Checks if document belongs to user
        if ($this->document->user_id != $user->id) {
            abort(404, 'Post not found');
        } else {
            /* 
            Populating the properties so the inputs
            in the update page are filled with the 
            current data
             */
            $this->title = $document->title;
            $this->description = $document->description;
            if (isset($this->document->institution)) {
                $this->institution = $this->document->institution->institution_name;
            }
            $this->tagsThatExist = Tag::where('document_id', $this->document->id)->get();

            // Getting the trusted institutions to list as options 
            $this->databaseInstitutions = Institution::where(
                'official', 
                1
            )->get();
        }
    }

    /* Method to insert a new tag to the tag insertion array */
    public function addTag()
    {
        // Trimming values before using them
        $this->tag = trim($this->tag);
        
        // Validation rules for the new tag
        $this->validate([
            'tag' => 'required|between:3,255',
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
        // Trimming values before using them
        $this->title = trim($this->title);
        $this->description = trim($this->description);
        $this->institution = trim($this->institution);

        // Validation rules for the document and its metadata
        $this->validate([
            'title' => 'required|between:1,255',
            'description' => 'max:255',
            'institution' => 'max:255',
        ]);

        try {
            // Update document in database
            $this->document->updateDocument(
                $this->title,
                $this->description,
                $this->institution, 
                $this->tagsToInsert, 
                $this->tagsToDeleteIds
            );

            // Resetting the properties
            $this->tagsToDeleteIds = [];
            $this->tagsToInsert = [];
            $this->tagsThatExist = Tag::where(
                'document_id', 
                $this->document->id
            )->get();
            
            session()->flash('successMessage', 'Updated successfully');

        } catch (\Exception $ex) {
            abort(500, 'Something went wrong.');
        }
    }

    public function render()
    {
        return view('livewire.document-update');
    }
}
