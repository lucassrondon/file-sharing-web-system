<div class="w-full flex flex-col justify-center items-center">
    <h1 class=" mt-6 font-bold text-xl text-gray-700">Update</h1>

    <form wire:submit.prevent="update" enctype="multipart/form-data" class="w-full sm:max-w-lg">
        <div class="flex flex-col gap-6 p-6">
            <div class="mb-6">
                <label for="document-title" class="block font-medium text-sm text-gray-700">Title:</label>
                <input value="{{ $title }}" type="text" id="document-title" wire:model="title" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                @error('title') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
            </div>
            
            <div class="mb-6">
                <label for="document-description" class="block font-medium text-sm text-gray-700">Description:</label>
                <input value="{{ $description }}" type="text" id="document-description" wire:model="description" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                @error('description') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
            </div>

            <div class="flex flex-col">
                <label for="" class="block font-medium text-sm text-gray-700">Tags:</label>

                <!-- 
                    Div for inputting tags. Gets hidden 
                    if the max amount of tags is reached 
                -->
                @if (count($tagsThatExist) + count($tagsToInsert) < 5)
                    <div class="flex mt-2 gap-4">
                        <input type="text" id="tag" wire:model="tag" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                        <button type="button" class="w-1/4 px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" wire:click="addTag">
                            Add
                        </button>
                    </div>
                @endif

                <!-- Div to show added tags -->
                <div class="flex gap-4 mt-1 flex-wrap">
                    @foreach ($tagsThatExist as $index => $tag)
                        <button type="button" class="truncate mt-1 px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" wire:click="addTagToDeleteList( {{ $tag->id }})">
                            {{ $tag->name }}
                        </button>
                    @endforeach

                    @foreach ($tagsToInsert as $index => $tag)
                        <button type="button" class="truncate mt-1 px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" wire:click="removeTagFromInsertList( {{ $index }})">
                            {{ $tag }}
                        </button>
                    @endforeach
                </div>
                @error('tag') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
            </div>

            <!-- Update success and failure message divs -->
            @if (session()->has('successMessage'))
                <div class="text-sm text-green-600 mt-2">{{ session('successMessage') }}</div>
            @endif
            @if (session()->has('failMessage'))
                <div class="text-sm text-red-600 mt-2">{{ session('failMessage') }}</div>
            @endif
            
            <button type="submit" class="w-full px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Save
            </button>
        </div>
    </form>
</div>
