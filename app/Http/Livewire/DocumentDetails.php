<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;

class DocumentDetails extends Component
{
    public $document;
    public $documentDeletion;

    /* Tryng to get the document passed in the url */
    public function mount(Document $document)
    {
        // Gets the user class
        $user = Auth::user();

        // Checks if document belongs to user
        if ($document->user_id != $user->id) {
            abort(404, 'Post not found');
        } else {
            $this->document = $document;
        }
    }

    /* Sets a flag to true to indicate the intention
       of deletion before actually deleting
    */
    public function setDocumentToDelete()
    {
        $this->documentDeletion = true;
    }

    /* If deletion is canceled, the flag returns to null */
    public function cancelDocumentDelete()
    {
        $this->documentDeletion = null;
    }

    /* Deleting the document on delete confirmation */
    public function confirmDocumentDelete()
    {
        try {
            $this->document->delete();
            session()->flash('successMessage', 'Document deleted successfully.');
            return redirect()->to('/your-uploads');
        } catch (\Exception $ex) {
            session()->flash('failMessage', 'Something went wrong.');
            return redirect()->to('/your-uploads');
        }
    }
    
    public function render()
    {
        return view('livewire.document-details');
    }
}
