<?php

namespace App\Http\Livewire;

use Exception;
use App\Models\Tag;
use Livewire\Component;
use App\Models\Document;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class DocumentUpdate extends Component
{
    public $document;
    public $title;
    public $description;

    public function mount(Document $document)
    {
        // Gets the user class
        $user = Auth::user();
        $this->document = $document;

        // Checks if document belongs to user
        if ($this->document->user_id != $user->id) {
            abort(404, 'Post not found');
        } else {
            $this->title = $document->title;
            $this->description = $document->description;
        }
    }

    public function update()
    {
        // Validation rules for the document and its metadata
        $this->validate([
            'title' => 'required|between:1,255',
            'description' => 'required|between:1,255',
        ]);

        try {
            DB::beginTransaction();

            // Update document in database
            $this->document->update([
                'title' => $this->title,
                'description' => $this->description,
            ]);
            
            session()->flash('successMessage', 'Updated successfully.');

            DB::commit();

        } catch (Exception $ex) {
            DB::rollBack();
            session()->flash('failMessage', 'Something went wrong. Try again.');
        }
    }

    public function render()
    {
        return view('livewire.document-update');
    }
}
