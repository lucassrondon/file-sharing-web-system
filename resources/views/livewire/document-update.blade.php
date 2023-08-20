<div>

    <form wire:submit.prevent="update" enctype="multipart/form-data" class="bg-white shadow-md rounded-lg p-8 w-full max-w-md">
        <div class="mb-6">
            <label for="document-title" class="block text-sm font-medium text-gray-700">Title:</label>
            <input value="{{ $title }}" type="text" id="document-title" wire:model="title" class="mt-1 p-2 w-full border rounded focus:outline-none focus:ring focus:border-blue-300">
            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        
        <div class="mb-6">
            <label for="document-description" class="block text-sm font-medium text-gray-700">Description:</label>
            <input value="{{ $description }}" type="text" id="document-description" wire:model="description" class="mt-1 p-2 w-full border rounded focus:outline-none focus:ring focus:border-blue-300">
            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <h1>Tags:</h1>

            @if (count($tagsThatExist) + count($tagsToInsert) < 5)
                <input type="text" id="tag" wire:model="tag" class="mt-1 p-2 w-full border rounded focus:outline-none focus:ring focus:border-blue-300">
                <button type="button" class="" wire:click="addTag">
                    AddTag
                </button>
            @endif

            @foreach ($tagsThatExist as $index => $tag)
                <button type="button" class="" wire:click="addTagToDeleteList( {{ $tag->id }})">
                    {{ $tag->name }}
                </button>
            @endforeach

            @foreach ($tagsToInsert as $index => $tag)
                <button type="button" class="" wire:click="removeTagFromInsertList( {{ $index }})">
                    {{ $tag }}
                </button>
            @endforeach

            @error('tag') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        
        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-black py-3 rounded-lg focus:outline-none focus:ring focus:ring-blue-300">
            Save
        </button>
    </form>


    @if (session()->has('successMessage'))
        <div class="">{{ session('successMessage') }}</div>
    @endif
    @if (session()->has('failMessage'))
        <div class="">{{ session('failMessage') }}</div>
    @endif
</div>
