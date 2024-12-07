<div class="w-full flex flex-col justify-center items-center gap-4 p-6">
    <!-- Setting the header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Details') }}
        </h2>
    </x-slot>

    <div class="w-full sm:max-w-lg flex flex-col gap-4 rounded-md drop-shadow-2xl bg-white p-6">
        <div class="flex justify-between">
            <img src="{{ asset('icons/'.$document->getExtension().'_icon.png') }}" alt="Logo" class="w-10">
            <button wire:click="download" type="button" class="w-10 hover:scale-125 md:active:scale-100">
                <img src="{{ asset('icons/download_icon.png') }}" alt="Download">
            </button>
        </div>

        <x-label for="">Title:</x-label>
        <x-doc-details-background>
            <x-upper-title> 
                {{ $document->title }} 
            </x-upper-title>
        </x-doc-details-background>

        <x-label for="">Description:</x-label>
        <x-doc-details-background>
            <x-description-style class="break-all"> 
                {{ $document->description }} 
            </x-description-style>
        </x-doc-details-background>

        <x-label for="">Institution:</x-label>
        <x-doc-details-background>
            @if (isset($document->institution))
                <x-upper-title> 
                    {{ $document->institution->institution_name }} 
                </x-upper-title>
            @endif
        </x-doc-details-background>

        <x-label for="">Subject:</x-label>
        <x-doc-details-background>
            @if (isset($document->subject))
                <x-upper-title> 
                    {{ $document->subject->subject_name }} 
                </x-upper-title>
            @endif
        </x-doc-details-background>

        <div class="flex gap-4">
            <div class="w-1/2">
                <x-label for="">Type:</x-label>
                <x-doc-details-background>
                    <x-upper-title> 
                        {{ $document->getExtension() }} 
                    </x-upper-title>
                </x-doc-details-background>
            </div>

            <div class="w-1/2">
                <x-label for="">Size:</x-label>
                <x-doc-details-background>
                    <x-upper-title> 
                        {{ $document->formatFilesize() }} 
                    </x-upper-title>
                </x-doc-details-background>
            </div>
        </div>

        <!-- Div to show the tags of a document -->
        <x-label for="">Tags:</x-label>
        <x-doc-details-background class="flex gap-4 flex-wrap">
            @foreach ($document->tags as $tag)
                <div class="truncate px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest">
                    {{ $tag->name }}
                </div>
            @endforeach
        </x-doc-details-background>

        <div class="flex gap-4">
            <div class="w-1/2">
                <x-label for="">Creation:</x-label>
                <x-doc-details-background>
                    <x-upper-title class="text-sm"> 
                        {{ $document->formatCreatedAt() }} 
                    </x-upper-title>
                </x-doc-details-background>
            </div>

            <div class="w-1/2">
                <x-label for="">By:</x-label>
                <x-doc-details-background>
                    <x-upper-title class="text-sm"> 
                        {{ $document->user->username }} 
                    </x-upper-title>
                </x-doc-details-background>
            </div>
        </div>
        
        <!-- Show delete and update buttons only if user can change the document -->
        @can('change-document', $document)
            <!-- 
            Div to show the buttons. There will be two buttons:
            the update and delete buttons or the confirm and cancel
            deletion buttons
            -->
            <div class="w-full flex gap-4 justify-center sm:max-w-lg bg-white mt-4">
                @if ($documentDeletion != true)
                    <a href="{{ route('document-update', ['document' => $document->id]) }}">
                        <x-button class="">
                            Update
                        </x-button>
                    </a>
                    
                    <x-danger-button wire:click="setDocumentToDelete">
                        Delete
                    </x-danger-button>
                @else
                    <x-danger-button wire:click="confirmDocumentDelete">
                        Confirm
                    </x-danger-button>

                    <x-button wire:click="cancelDocumentDelete">
                        Cancel
                    </x-button>
                @endif
            </div>
        @endcan
    </div>
</div>
