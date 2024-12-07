<?php

namespace App\Http\Livewire;

use App\Models\Tag;
use Livewire\Component;
use App\Models\Document;
use App\Models\Institution;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;

class DocumentUpdate extends Component
{
    public $document;
    public $title;
    public $description;
    public $institution;
    public $subject;
    public $tagsThatExist;
    public $tagsToDeleteIds = [];
    public $tagsToInsert = [];
    public $tag;
    public $databaseInstitutions;

    /* Initializing the properties */
    public function mount(Document $document)
    {
        $this->title = $this->document->title;
        $this->tagsThatExist = $document->getTags();
        $this->description = $this->document->description;
        // Getting the trusted institutions to list as options 
        $this->databaseInstitutions = Institution::where('official', 1)
            ->get();
        if (isset($this->document->institution)) {
            $this->institution = $this->document->institution->institution_name;
        }
        if (isset($this->document->subject)) {
            $this->subject = $this->document->subject->subject_name;
        }
    }

    public function update()
    {
        $this->userCanChangeOrFail();
        $this->validateDocumentInputs();

        try {
            // Update document in database
            $this->document->updateDocument(
                $this->title,
                $this->description,
                $this->institution,
                $this->subject, 
                $this->tagsToInsert, 
                $this->tagsToDeleteIds
            );

            // Resetting the properties
            $this->resetProperties();
            
            session()->flash('successMessage', 'Updated successfully');

        } catch (\Exception $ex) {
            abort(500, 'Something went wrong.');
        }
    }

    /* Insert a new tag to the tag insertion array */
    public function addTag()
    {
        $this->validateTagInput();

        if ($this->tagLimitReached()) {
            return;
        } elseif (!$this->tagExists()) {
            $this->insertTag();
        }
        $this->tag = null;
    }

    /* Remove a tag from the insertion array */
    public function removeTagFromInsertList($index)
    {
        unset($this->tagsToInsert[$index]);
    }

    /* Remove a tag that already exists */
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

    /* Aborting if user does not  have permission */
    private function userCanChangeOrFail()
    {
        if (!Auth::user()->can('change-document', $this->document)) {
            abort(403, 'Forbidden');
        }
    }

    private function insertTag()
    {
        $this->tagsToInsert[] = $this->tag;
    }

    private function tagLimitReached()
    {
        return count($this->tagsThatExist) + 
               count($this->tagsToInsert) >= 5;
    }

    private function tagExists()
    {   
        return in_array($this->tag, $this->tagsToInsert) ||
               $this->tagsThatExist->contains('name', $this->tag);
    }

    private function validateDocumentInputs()
    {
        // Trimming values before using them
        $this->title = trim($this->title);
        $this->description = trim($this->description);
        $this->institution = trim($this->institution);
        $this->subject = trim($this->subject);

        // Validation rules for the document and its metadata
        $this->validate([
            'title' => 'required|between:1,255',
            'description' => 'max:255',
            'institution' => 'max:255',
            'subject' => 'max:255',
        ]);
    }

    private function validateTagInput()
    {
        // Trimming values before using them
        $this->tag = trim($this->tag);
        
        // Validation rules for the new tag
        $this->validate([
            'tag' => 'required|between:3,255',
        ]);
    }

    /* Reset properties after updating document */
    private function resetProperties()
    {
        $this->tagsToDeleteIds = [];
        $this->tagsToInsert = [];
        $this->tagsThatExist = Tag::where(
            'document_id', 
            $this->document->id
        )->get();
    }

    public function render()
    {
        return view('livewire.document-update');
    }
}
