<?php

namespace App\Http\Livewire;

use Livewire\Component;


class Dashboard extends Component
{
    public $searchTextInput;

    public function search()
    {
        $this->validateInput();

        return redirect()->route('search', [
            'searchvalue' => $this->searchTextInput
        ]);
    }

    /* Validates the current searchText */
    private function validateInput()
    {
        $this->searchTextInput = trim($this->searchTextInput);

        $this->validate([
            'searchTextInput' => 'required|between:3,255',
        ]);
    }
    
    public function render()
    {
        return view('livewire.dashboard');
    }
}
