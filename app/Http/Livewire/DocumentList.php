<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;

class DocumentList extends Component
{
    public $user;
    public $documentsList;
    public $documentToDelete;

    public function mount()
    {
        // Gets the user class
        $this->user = Auth::user();
        $this->list();
    }

    public function list()
    {
        // Lists uploads for this user
        $this->documentsList = Document::where('user_id', $this->user->id)->get();
    }

    public function setDocumentToDelete($documentId)
    {
        $this->documentToDelete = $documentId;
    }

    public function cancelDocumentDelete()
    {
        $this->documentToDelete = null;
    }

    public function confirmDocumentDelete()
    {
        $document = Document::findOrFail($this->documentToDelete);

        // Checks if document belongs to user
        if ($document->user_id != $this->user->id) {
            session()->flash('failMessage', 'Invalid document ID');
        } else {
            $document->delete();
            session()->flash('success', 'Document deleted successfully.');
            $this->documentToDelete = null;
            $this->list();
        }
    }

    public function render()
    {
        return view('livewire.document-list');
    }
}
