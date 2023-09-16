<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Document;

class Dashboard extends Component
{
    public bool $searchOn;
    public string $searchText;
    public $documentsList = [];

    public function mount()
    {
        $this->searchText = '';
    }

    public function search()
    {
        $this->searchOn = true;
        $this->validateInput();

        $this->searchDocuments();

    }

    private function searchDocuments()
    {
        $this->documentsList = Document::search($this->searchText);
    }

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
