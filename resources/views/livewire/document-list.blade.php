<div>
    <!-- Setting the header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Your Uploads') }}
        </h2>
    </x-slot>

    <div>
        <ul>
            @foreach ($documentsList as $document)
                <li>Title: {{ $document->title }}</li>
                <li>Description: {{ $document->description }}</li>
                <li>Type: {{ $document->mime_type }}</li>

                <a href="{{ route('document-update', ['document' => $document->id]) }}">Update</a>
                @if ($documentToDelete != $document->id)
                    <button wire:click="setDocumentToDelete( {{ $document->id }} )">Delete</button>
                @else
                    <button wire:click="confirmDocumentDelete">Confirm Delete</button>
                    <button wire:click="cancelDocumentDelete">Cancel</button>
                @endif
            @endforeach
        </ul>

        @if (session()->has('successMessage'))
            <div class="">{{ session('successMessage') }}</div>
        @endif
        @if (session()->has('failMessage'))
            <div class="">{{ session('failMessage') }}</div>
        @endif
    </div>
</div>
