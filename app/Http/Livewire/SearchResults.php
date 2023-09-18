<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Document;
use Symfony\Component\HttpFoundation\Request;

class SearchResults extends Component
{
    protected $paginator;
    public string $searchText;
    public $documentsList = [];

    public function mount(Request $request)
    {
        if ($request->get('searchtext') !== null) {
            $this->searchText = $request->get('searchtext');
        } else {
            $this->searchText = ''; 
        }
        
        $this->validateInput();

        $this->searchDocuments();
    }

    /* Sets documents and pagination */
    private function searchDocuments()
    {
        $this->paginator = Document::search($this->searchText);
        $this->documentsList = $this->paginator->items();
    }

    /* Validates the current searchText */
    private function validateInput()
    {
        $this->searchText = trim($this->searchText);

        $this->validate([
            'searchText' => 'required|between:3,255',
        ]);
    }
    
    public function render()
    {
        return view('livewire.search-results');
    }
}
