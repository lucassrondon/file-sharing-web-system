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
        
    }

    /* 
    Sets a flag to true to indicate the intention
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
        $this->userCanChangeOrFail();
        
        try {
            $this->document->deleteDocumentFromAll();

            session()->flash(
                'successMessage', 
                'Document deleted successfully'
            );
            
            return redirect()->to('/your-uploads');
        } catch (\Exception $ex) {
            abort(500, 'Something went wrong.');
        }
    }

    public function download()
    {
        return $this->document->download();
    }

    /* Aborting if user does not  have permission */
    private function userCanChangeOrFail()
    {
        if (!Auth::user()->can('change-document', $this->document)) {
            abort(403, 'Forbidden');
        }
    }
    
    public function render()
    {
        return view('livewire.document-details');
    }
}
