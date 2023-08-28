<div class="w-full flex flex-col justify-center items-center gap-4 p-6">
    <!-- Setting the header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Details') }}
        </h2>
    </x-slot>

    <div class="w-full sm:max-w-lg flex flex-col gap-4 rounded-md drop-shadow-2xl bg-white p-6">
        <img src="{{ asset('icons/'.$document->getExtension().'_icon.png') }}" alt="Logo" class="w-10">

        <label for="" class="font-medium text-sm text-gray-700">Title:</label>
        <div class="w-full bg-gray-100 p-2 rounded-md drop-shadow-2xl">
            <p class="break-all font-semibold text-black uppercase tracking-widest">{{ $document->title }}</p>
        </div>

        <label for="" class="font-medium text-sm text-gray-700">Description:</label>
        <div class="w-full bg-gray-100 p-2 rounded-md drop-shadow-2xl">
            <p class="break-all text-gray-500 text-sm leading-relaxed">{{ $document->description }}</p>
        </div>

        <label for="" class="font-medium text-sm text-gray-700">Institution:</label>
        <div class="w-full bg-gray-100 p-2 rounded-md drop-shadow-2xl">
            @if (isset($document->institution))
                <p class="break-all font-semibold text-black uppercase tracking-widest">{{ $document->institution->institution_name }}</p>
            @endif
        </div>

        <div class="flex gap-4">
            <div class="w-1/2">
                <label for="" class="font-medium text-sm text-gray-700">Type:</label>
                <div class="bg-gray-100 p-2 rounded-md drop-shadow-2xl">
                    <p class="break-all font-semibold text-black uppercase tracking-widest">{{ $document->getExtension() }}</p>
                </div>
            </div>

            <div class="w-1/2">
                <label for="" class="font-medium text-sm text-gray-700">Size:</label>
                <div class=" bg-gray-100 p-2 rounded-md drop-shadow-2xl">
                    <p class="break-all font-semibold text-black uppercase tracking-widest">{{ $document->size }}</p>
                </div>
            </div>
        </div>

        <!-- Div to show the tags of a document -->
        <label for="" class="font-medium text-sm text-gray-700">Tags:</label>
        <div class="w-full flex gap-4 flex-wrap bg-gray-100 p-2 rounded-md drop-shadow-2xl">
            @foreach ($document->tags as $tag)
                <div class="truncate mt-1 px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest">
                    {{ $tag->name }}
                </div>
            @endforeach
        </div>

        <label for="" class="font-medium text-sm text-gray-700">Creation:</label>
        <div class="bg-gray-100 p-2 rounded-md drop-shadow-2xl">
            <p class="break-all font-semibold text-sm text-black uppercase tracking-widest">{{ $document->created_at }}</p>
        </div>
        
        <!-- 
        Div to show the buttons. There will be two buttons:
        the update and delete buttons or the confirm and cancel
        deletion buttons
        -->
        <div class="w-full flex gap-4 justify-center sm:max-w-lg bg-white mt-4">
            @if ($documentDeletion != true)
                <a href="{{ route('document-update', ['document' => $document->id]) }}">
                    <button class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Update</button>
                </a>
                <button wire:click="setDocumentToDelete" class="px-4 py-2 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Delete
                </button>
            @else
                <button wire:click="confirmDocumentDelete" class="px-4 py-2 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Confirm
                </button>

                <button wire:click="cancelDocumentDelete" class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Cancel
                </button>
            @endif
        </div>
    </div>
</div>
