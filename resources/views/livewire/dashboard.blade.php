<div>
    <!-- Setting the header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>
    
    <div class="bg-gray-100 h-full w-full flex flex-col items-center">

        <img src="{{ asset('images/logo.png') }}" alt="" class="w-20">

        <form class="w-4/5 sm:w-3/4 md:w-1/2 flex flex-col gap-4">
            <!-- Any Field -->
            <div class="flex flex-col">
                <label for="anyField" class="font-medium">Any</label>
                <x-input id="anyField" wire:model="any" placeholder="Search in any field" autofocus class="w-full" />
            </div>

            <!-- Title and Description -->
            <div class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <label for="titleField" class="font-medium">Title</label>
                    <x-input id="titleField" wire:model="title" placeholder="Search by title" class="w-full" />
                </div>

                <div class="flex-1 min-w-[200px]">
                    <label for="descriptionField" class="font-medium">Description</label>
                    <x-input id="descriptionField" wire:model="description" placeholder="Search by description" class="w-full" />
                </div>
            </div>

            <!-- Institution and Subject -->
            <div class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <label for="institutionField" class="font-medium">Institution</label>
                    <x-input id="institutionField" wire:model="institution" placeholder="Search by institution" class="w-full" />
                </div>

                <div class="flex-1 min-w-[200px]">
                    <label for="subjectField" class="font-medium">Subject</label>
                    <x-input id="subjectField" wire:model="subject" placeholder="Search by subject" class="w-full" />
                </div>
            </div>

            <!-- Document Type and Start Date -->
            <div class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <label for="mimeTypeField" class="font-medium">Document Type</label>
                    <select id="mimeTypeField" wire:model="mimeType" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">Select a document type</option>
                        <option value="application/pdf">PDF</option>
                        <option value="text/plain">Txt</option>
                        <option value="application/vnd.openxmlformats-officedocument.wordprocessingml.document">Microsoft Word</option>
                        <option value="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">Excel</option>
                    </select>
                </div>

                <div class="flex-1 min-w-[200px]">
                    <label for="startDateField" class="font-medium">Start Date</label>
                    <x-input id="startDateField" type="date" wire:model="startDate" class="w-full" />
                </div>
            </div>

            <!-- Topic and Search in Text -->
            <div class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <label for="tagField" class="font-medium">Topic</label>
                    <x-input id="tagField" wire:model="tag" placeholder="Search by topic" class="w-full" />
                </div>

                <div class="flex-1 min-w-[200px]">
                    <label for="searchInTextField" class="font-medium">Search in Text</label>
                    <x-input id="searchInTextField" wire:model="searchInText" placeholder="Search inside text content" class="w-full" />
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center mt-4">
                <button wire:click="search()" type="button" class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                    Search
                </button>
            </div>
        </form>

        @error('any') <x-span-danger>{{ $message }}</x-span-danger> @enderror
    </div>
</div>
