<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Document;
use App\Models\Institution;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Rules\DocumentValidationRule;

class DocumentUpload extends Component
{
    public $title;
    public $description;
    public $document;
    public $tag;
    public $tags = [];
    public $databaseInstitutions;
    public $institution;
    
    use WithFileUploads;

    public function mount()
    {
        /* Getting the trusted institutions to list as options */
        $this->databaseInstitutions = Institution::where(
            'official', 
            1
        )->get();
    }

    /* Method to upload a new document */
    public function upload()
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
            'document' => ['required', new DocumentValidationRule()],
        ]);
        
        try {
            // Gets the user id
            $userId = Auth::id();

            // Store the document
            $generatedDocumentName = $this->document->store('uploads', 'local');

            // Put the document data into an array
            $documentData = [
            'user_id'     => $userId,
            'title'       => $this->title,
            'description' => $this->description,
            'size'        => $this->document->getSize(),
            'mime_type'   => $this->document->getMimeType(),
            'file_name'   => $generatedDocumentName,
            'downloads'   => 0,
            ];

            // Method that handles the upload
            // Gets all the data of the document and saves it
            Document::uploadDocument(
                $documentData, 
                $this->institution, 
                $this->tags
            );

            // Clear input fields after file upload
            $this->title = '';
            $this->description = '';
            $this->institution = '';
            $this->document = '';
            $this->tags = [];
        
            session()->flash('successMessage', 'File uploaded successfully!');
            
        } catch (\Exception $ex) {
            dd($ex->getMessage());
            abort(500, 'Something went wrong.');
        }
    }

    /* Method to add a new tag to tags array */
    public function addTag()
    {
        // Trimming values before using them
        $this->tag = trim($this->tag);

        // Validation rules for tag
        $this->validate([
            'tag' => 'required|between:1,255',
        ]);

        // Verify if there alredy are 5 tags or if tag already exists
        if (count($this->tags) >= 5) {
            abort(500, 'Something went wrong.');
        } elseif (!in_array($this->tag, $this->tags)) {
            $this->tags[] = $this->tag;
            $this->tag = null;
        }
        $this->tag = null;
    }

    /* Unset tag from tags array */
    public function removeTag($tagToRemove)
    {
        unset($this->tags[$tagToRemove]);
    }

    public function render()
    {
        return view('livewire.document-upload');
    }
}
