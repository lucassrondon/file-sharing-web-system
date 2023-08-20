<?php

namespace App\Http\Livewire;

use Exception;
use Livewire\Component;
use App\Models\Document;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Rules\DocumentValidationRule;

class DocumentUpload extends Component
{
    use WithFileUploads;

    public $title;
    public $description;
    public $document;
    public $tag;
    public $tags = [];

    /* Method to upload a new document */
    public function upload()
    {
        try {
            // Validation rules for the document and its metadata
            $this->validate([
                'title' => 'required|between:1,255',
                'description' => 'max:255',
                'document' => ['required', new DocumentValidationRule()],
            ]);
            
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

            Document::uploadDocument($documentData, $this->tags);

            // Clear input fields after file upload
            $this->title = '';
            $this->description = '';
            $this->document = '';
            $this->tags = [];
        
            session()->flash('successMessage', 'File uploaded successfully!');
            
        } catch (Exception $ex) {
            abort(500, 'Something went wrong.');
        }
    }

    /* Method to add a new tag to tags array */
    public function addTag()
    {
        // Validation rules for tag
        $this->validate([
            'tag' => 'between:1,255',
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
