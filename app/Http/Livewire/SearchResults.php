<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Document;
use Symfony\Component\HttpFoundation\Request;

class SearchResults extends Component
{
    protected $links;
    public string $searchValue;
    public $documentsList = [];

    public function mount(Request $request)
    {
        if ($request->get('searchvalue') !== null) {
            $this->searchValue = $request->get('searchvalue');
        } else {
            $this->searchValue = ''; 
        }
        
        $this->validateInput();

        $this->searchDocuments();
    }

    /* Sets documents and pagination */
    private function searchDocuments()
    {
        $paginator = Document::search($this->searchValue);
        $this->documentsList = $paginator->getCollection();
        $this->links = $paginator->withPath("/search?searchvalue={$this->searchValue}")->links();
    }

    /* Validates the current searchText */
    private function validateInput()
    {
        $this->searchValue = trim($this->searchValue);

        $this->validate([
            'searchValue' => 'required|between:3,255',
        ]);
    }
    
    public function render()
    {
        return view('livewire.search-results');
    }
}
