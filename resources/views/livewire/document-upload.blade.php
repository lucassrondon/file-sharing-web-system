<div>
    <!-- Setting the header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upload') }}
        </h2>
    </x-slot>

    <div class="w-full flex flex-col justify-center items-center">
        <form wire:submit.prevent="upload" enctype="multipart/form-data" class="w-full sm:max-w-lg">
            <x-upload-update-square>
                <div>
                    <x-label for="document-title">*Title:</x-label>
                    <x-input placeholder="Document title" type="text" id="document-title" wire:model="title" class="w-full mt-1"/>
                    @error('title') <x-span-danger> {{ $message }} </x-span-danger> @enderror
                </div>
                
                <div>
                    <x-label for="document-description">Description:</x-label>
                    <x-input placeholder="Document description" type="text" id="document-description" wire:model="description" class="w-full mt-1"/>
                    @error('description') <x-span-danger> {{ $message }} </x-span-danger> @enderror
                </div>

                <div>
                    <x-label for="document-institution">Institution:</x-label>
                    <x-input placeholder="Document institution" type="text" list="institutions" id="document-institution" wire:model="institution" class="w-full mt-1"/>
                    
                    <datalist id="institutions">
                        @foreach ($databaseInstitutions as $institution)
                            <option value="{{ $institution->institution_name }}">
                        @endforeach
                    </datalist>
                    @error('institution') <x-span-danger> {{ $message }} </x-span-danger> @enderror
                </div>

                <div>
                    <x-label for="document-subject">Subject:</x-label>
                    <x-input placeholder="Document subject" type="text" id="document-subject" wire:model="subject" class="w-full mt-1"/>
                    @error('subject') <x-span-danger> {{ $message }} </x-span-danger> @enderror
                </div>

                <div>
                    <x-label for="document">*Document:</x-label>
                    <input type="file" name="document" wire:model="document" class="w-full mt-2">
                    @error('document') <x-span-danger> {{ $message }} </x-span-danger> @enderror
                </div>

                <div class="flex flex-col">
                    <!-- 
                        Div for inputting tags. Gets hidden 
                        if the max amount of tags is reached 
                    -->
                    <x-label for="">Tags:</x-label>
                    @if (sizeof($tags) < 5)
                        <div class="flex mt-2 gap-4">
                            <x-input placeholder="Key word" type="text" id="tag" wire:model="tag" class="borderblock mt-1 w-full"/>
                            <x-button type="button" wire:click="addTag" class="">
                                Add
                            </x-button>
                        </div>
                    @endif

                    <!-- Div to show added tags -->
                    <div class="flex gap-4 mt-1 flex-wrap">
                        @foreach ($tags as $index => $tag)
                            <x-button type="button" wire:click="removeTag({{ $index }})" class="truncate mt-1">
                                × {{ $tag }}
                            </x-button>
                        @endforeach
                    </div>

                    @error('tag') <x-span-danger> {{ $message }} </x-span-danger> @enderror
                </div>

                <!-- Upload success and failure message divs -->
                <x-success-or-fail-message/>
                
                <div class="flex justify-center items-center">
                    <x-button type="submit">
                        Upload
                    </x-button>
                </div>
            </x-upload-update-square>
        </form>
    </div>
</div>
