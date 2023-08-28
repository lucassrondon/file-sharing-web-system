<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;

class DocumentList extends Component
{
    public $user;
    public $documentsList;

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

    public function render()
    {
        return view('livewire.document-list');
    }
}
