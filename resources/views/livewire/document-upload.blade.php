<div class="w-full flex flex-col justify-center items-center">
    <h1 class=" mt-6 font-bold text-xl text-gray-700">New Upload</h1>

    <form wire:submit.prevent="upload" enctype="multipart/form-data" class="w-full sm:max-w-lg">
        <div class="flex flex-col gap-6 p-6">
            <div>
                <label for="document-title" class="block font-medium text-sm text-gray-700">*Title:</label>
                <input type="text" id="document-title" wire:model="title" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                @error('title') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label for="document-description" class="block font-medium text-sm text-gray-700">Description:</label>
                <input type="text" id="document-description" wire:model="description" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                @error('description') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="document-institution" class="block font-medium text-sm text-gray-700">Institution:</label>
                <input type="text" list="institutions" id="document-institution" wire:model="institution" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                
                <datalist id="institutions">
                    @foreach ($databaseInstitutions as $institution)
                        <option value="{{ $institution->institution_name }}">
                    @endforeach
                </datalist>

            </div>

            <div>
                <label for="document" class="block font-medium text-sm text-gray-700">*Document:</label>
                <input type="file" name="document" wire:model="document" class="w-full mt-2">
                @error('document') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
            </div>

            <div class="flex flex-col">
                <label for="" class="block font-medium text-sm text-gray-700">Tags:</label>

                <!-- 
                    Div for inputting tags. Gets hidden 
                    if the max amount of tags is reached 
                -->
                @if (sizeof($tags) < 5)
                    <div class="flex mt-2 gap-4">
                        <input type="text" id="tag" wire:model="tag" class="w-3/4 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1">
                        <button type="button" wire:click="addTag" class="w-1/4 px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Add
                        </button>
                    </div>
                @endif

                <!-- Div to show added tags -->
                <div class="flex gap-4 mt-1 flex-wrap">
                    @foreach ($tags as $index => $tag)
                        <button type="button" wire:click="removeTag({{ $index }})" class="truncate mt-1 px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            × {{ $tag }}
                        </button>
                    @endforeach
                </div>
                @error('tag') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
            </div>

            <!-- Upload success and failure message divs -->
            @if (session()->has('successMessage'))
                <div class="text-sm text-green-600 mt-2">{{ session('successMessage') }}</div>
            @endif
            @if (session()->has('failMessage'))
                <div class="text-sm text-red-600 mt-2">{{ session('failMessage') }}</div>
            @endif
            
            <button type="submit" class="w-full px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Upload
            </button>
        </div>
    </form>
</div>
