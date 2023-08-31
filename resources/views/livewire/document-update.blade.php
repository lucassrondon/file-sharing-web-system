<div>
    <!-- Setting the header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update') }}
        </h2>
    </x-slot>
    
    <div class="w-full flex flex-col justify-center items-center">
        <form wire:submit.prevent="update" enctype="multipart/form-data" class="w-full sm:max-w-lg">
            <div class="flex flex-col gap-6 p-6">

                <div>
                    <x-label for="document-title">Title:</x-label>
                    <x-input value="{{ $title }}" type="text" id="document-title" wire:model="title" class="block mt-1 w-full"/>
                    @error('title') <x-span-danger> {{ $message }} </x-span-danger> @enderror
                </div>
                
                <div>
                    <x-label for="document-description">Description:</x-label>
                    <x-input value="{{ $description }}" type="text" id="document-description" wire:model="description" class="block mt-1 w-full"/>
                    @error('description') <x-span-danger> {{ $message }} </x-span-danger> @enderror
                </div>

                <div>
                    <x-label for="document-institution">Institution:</x-label>
                    <x-input type="text" list="institutions" id="document-institution" wire:model="institution" class="block mt-1 w-full"/>
                    
                    <datalist id="institutions">
                        @foreach ($databaseInstitutions as $institution)
                            <option value="{{ $institution->institution_name }}">
                        @endforeach
                    </datalist>
                </div>

                <div class="flex flex-col">
                    <x-label for="">Tags:</x-label>
                    <!-- 
                        Div for inputting tags. Gets hidden 
                        if the max amount of tags is reached 
                    -->
                    @if (count($tagsThatExist) + count($tagsToInsert) < 5)
                        <div class="flex mt-2 gap-4">
                            <x-input type="text" id="tag" wire:model="tag" class="borderblock mt-1 w-full"/>
                            <x-button type="button" class="" wire:click="addTag">
                                Add
                            </x-button>
                        </div>
                    @endif

                    <!-- Div to show added tags -->
                    <div class="flex gap-4 mt-1 flex-wrap">
                        @foreach ($tagsThatExist as $index => $tag)
                            <x-button type="button" class="truncate mt-1" wire:click="addTagToDeleteList( {{ $tag->id }})">
                                × {{ $tag->name }}
                            </x-button>
                        @endforeach

                        @foreach ($tagsToInsert as $index => $tag)
                            <x-button type="button" class="truncate mt-1" wire:click="removeTagFromInsertList( {{ $index }})">
                                × {{ $tag }}
                            </x-button>
                        @endforeach
                    </div>
                    @error('tag') <x-span-danger> {{ $message }} </x-span-danger> @enderror
                </div>

                <!-- Update success and failure message divs -->
                <x-success-or-fail-message/>
                
                <div class="flex justify-center items-center">
                    <x-button type="submit">
                        Save
                    </x-button>
                </div>
            </div>
        </form>
    </div>
</div>
