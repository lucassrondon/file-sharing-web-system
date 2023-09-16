<div>
    <!-- Setting the header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>
    
    <!--
        Div of searches
        When be hidden when applying filters
    -->
    <div class="w-full">
        @if($searchOn)
            <div class="w-full flex items-center justify-center gap-2 mt-1 p-2 bg-white">
                <x-input class="md:w-2/5 w-4/5 bg-gray-100" wire:model="searchText"/>
                <button class="hover:scale-125 active:scale-100" wire:click="search()">
                    <img src="{{ asset('icons/search_icon.png') }}" alt="" class="">
                </button>
            </div>

            <x-list-docs :documentsList="$documentsList">
                <!-- Img for when there is no docs found -->
                <img src="{{ asset('images/no_matches_logo.png') }}" alt="">
            </x-list-docs>

        @else
            <div class="bg-gray-100 h-full w-full flex flex-col items-center">

                <img src="{{ asset('images/logo.png') }}" alt="" class="w-60">

                <div class="w-4/5 sm:w-2/4 md:w-1/4 flex gap-2">
                    <x-input autofocus class="w-full" wire:model="searchText"/>
                    <button class="hover:scale-125 active:scale-100" wire:click="search()">
                        <img src="{{ asset('icons/search_icon.png') }}" alt="" class="">
                    </button>
                </div>

            </div>
        @endif
    </div>

    <div>
        <!-- MAKE APPLY FILTERS HERE -->
    </div>


</div>
