<?php

namespace App\Http\Livewire;

use Exception;
use App\Models\Tag;
use Livewire\Component;
use App\Models\Document;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

    public function upload()
    {
        // Validation rules for the document and its metadata
        $this->validate([
            'title' => 'required|between:1,255',
            'description' => 'max:255',
            'document' => ['required', new DocumentValidationRule()],
        ]);
        
        // Begins a transaction
        DB::beginTransaction();
        try {
            // Gets the user id
            $userId = Auth::id();
            $generatedDocumentName = $this->document->store('uploads', 'local');

            // Create a Document Model and set its attributes
            $documentModel = Document::create([
            'user_id'     => $userId,
            'title'       => $this->title,
            'description' => $this->description,
            'size'        => $this->document->getSize(),
            'mime_type'   => $this->document->getMimeType(),
            'file_name'   => $generatedDocumentName,
            'downloads'   => 0,
            ]);

            // Setting up tags array to insert
            $dbTags = [];
            foreach ($this->tags as $tag) {
                $dbTags[] = [
                    'document_id' => $documentModel->id,
                    'name' => $tag,
                ];
            }
            // Inserting tags in database
            Tag::insert($dbTags);
            
            // Clear input fields after file upload
            $this->title = '';
            $this->description = '';
            $this->document = '';
            $this->tags = [];

            // Commit changes
            DB::commit();
            session()->flash('successMessage', 'File uploaded successfully!');

        }
        catch (Exception $ex) {
            // Rollback changes
            DB::rollBack();
            abort(500, 'Something went wrong.');
        }
    }

    public function addTag()
    {
        // Validation rules for tag
        $this->validate([
            'tag' => 'between:1,255',
        ]);

        // Verify if there alredy are 5 tags or if tag already exists
        if (count($this->tags) >= 5) {
            session()->flash('failMessage', 'There cannot be more than 5 tags.');
        } elseif (!in_array($this->tag, $this->tags)) {
            $this->tags[] = $this->tag;
            $this->tag = null;
        }
        $this->tag = null;
    }

    public function removeTag($tagToRemove)
    {
        // Unset tag from tags array
        unset($this->tags[$tagToRemove]);
    }

    public function render()
    {
        return view('livewire.document-upload');
    }
}
