<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Document;
use Symfony\Component\HttpFoundation\Request;

class Dashboard extends Component
{
    public bool $searchOn;
    public string $searchText;
    public $documentsList = [];
    protected $listeners = ['popState' => 'popStateAction'];

    public function mount(Request $request)
    {
        // Looks for a search text in the route
        // If a value is found the data for that
        // value will be loaded
        if ($request->route('searchtext')) {
            $this->searchText = $request->route('searchtext'); 
            $this->search();
            return;   
        }
        // If there is no search text in the route,
        // the value will be empty, so the default search
        // page will be loaded
        $this->searchText = '';
    }

    /* Sets the search mode to ON so the search
    interface is displayed; validates the and makes
    a search for the current searchText */
    public function search()
    {
        $this->searchOn = true;
        $this->validateInput();

        $this->dispatchBrowserEvent('hasSearch', [
            'searchtext' => $this->searchText,
        ]);

        $this->searchDocuments();
    }

    /* Loads a state when user goes through browser history */
    public function popStateAction(string|bool $searchText)
    {
        if ($searchText === false) {
            $this->searchOn = false;
            $this->searchText = '';
        } elseif ($this->searchText !== $searchText) {
            $this->searchText = $searchText;
            $this->search();
        }
    }

    /*  */
    private function searchDocuments()
    {
        $this->documentsList = Document::search($this->searchText);
    }

    /* Validates the current searchText */
    private function validateInput()
    {
        $this->searchText = trim($this->searchText);

        $this->validate([
            'searchText' => 'required|between:1,255',
        ]);
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
