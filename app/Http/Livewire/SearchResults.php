<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Document;
use Symfony\Component\HttpFoundation\Request;

class SearchResults extends Component
{
    protected $links;
    public $any;
    public $title;
    public $description;
    public $institution;
    public $subject;
    public $mimeType;
    public $startDate;
    public $tag;
    public $searchInText;
    public $documentsList = [];

    public function mount(Request $request)
    {
        // Define the fields to handle
        $fields = ['any', 'title', 'description', 'institution', 'subject', 'mimeType', 'startDate', 'tag', 'searchInText'];

        // Loop through each field and set the value
        foreach ($fields as $field) {
            $this->{$field} = $request->get($field) !== null ? $request->get($field) : '';
        }


        $this->searchDocuments();
    }

    /* Sets documents and pagination */
    private function searchDocuments()
    {
        $paginator = Document::search([
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
        $this->documentsList = $paginator->getCollection();
        $this->links = $paginator->withPath("/search?{$this->getSearchParameters()}")->links();
    }

    private function getSearchParameters()
    {
        // Define the fields to include in the query string
        $fields = ['any', 'title', 'description', 'institution', 'subject', 'mimeType', 'startDate', 'tag', 'searchInText'];

        // Build the query string dynamically
        $queryString = implode('&', array_map(function ($field) {
            return "{$field}=" . urlencode($this->{$field});
        }, $fields));

        // Return the query string
        return $queryString;
    }
    
    public function render()
    {
        return view('livewire.search-results');
    }
}
