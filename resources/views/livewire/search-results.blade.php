<div>
    <!-- Setting the header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Search') }}
        </h2>
    </x-slot>
    
    <div class="w-full">
        <div class="w-full flex flex-col items-center justify-center gap-2 mt-1 p-2 bg-white">
            <form method="GET" action="{{ route('search') }}" class="w-full flex items-center justify-center gap-2">
                <x-input name="searchvalue" value="{{$searchValue}}" placeholder="Search a file" class="md:w-2/5 w-4/5 bg-gray-100"/>
                <button type="submit" class="hover:scale-125 active:scale-100">
                    <img width="40" src="{{ asset('icons/search_icon.png') }}" alt="search">
                </button>
            </form>
            @error('searchValue') <x-span-danger> {{ $message }} </x-span-danger> @enderror
        </div>

        <x-list-docs :documentsList="$documentsList">
            <!-- Img for when there is no docs found -->
            <img src="{{ asset('images/no_matches_logo.png') }}" alt="">
        </x-list-docs>

        <!-- Pagination -->
        @if($this->links)
            {{$this->links}}
        @endif

    </div>

    <div>
        <!-- MAKE APPLY FILTERS HERE -->
    </div>


</div>
