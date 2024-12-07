<?php

namespace App\Http\Livewire;

use Livewire\Component;


class Dashboard extends Component
{
    public $any;
    public $title;
    public $description;
    public $institution;
    public $subject;
    public $mimeType;
    public $startDate;
    public $tag;
    public $searchInText;


    public function search()
    {
        return redirect()->route('search', [
            'any' => $this->any,
            'title' => $this->title,
            'description' => $this->description,
            'institution' => $this->institution,
            'subject' => $this->subject,
            'mimeType' => $this->mimeType,
            'startDate' => $this->startDate,
            'tag' => $this->tag,
            'searchInText' => $this->searchInText
        ]);
    }
    
    public function render()
    {
        return view('livewire.dashboard');
    }
}
