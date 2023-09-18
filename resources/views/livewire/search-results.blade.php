<div>
    <!-- Setting the header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Search') }}
        </h2>
    </x-slot>
    
    <div class="w-full">

        <form action="/search?page=1" mehtod="get" class="w-full flex items-center justify-center gap-2 mt-1 p-2 bg-white">
            <x-input value="{{ $searchText }}" name="searchtext" placeholder="Search a file" class="md:w-2/5 w-4/5 bg-gray-100"/>
            <button class="hover:scale-125 active:scale-100">
                <img src="{{ asset('icons/search_icon.png') }}" alt="search">
            </button>
        </form>
        @error('searchText') <x-span-danger> {{ $message }} </x-span-danger> @enderror

        <x-list-docs :documentsList="$documentsList">
            <!-- Img for when there is no docs found -->
            <img src="{{ asset('images/no_matches_logo.png') }}" alt="">
        </x-list-docs>

        <!-- Pagination -->
        @if($searchText && $this->paginator)
        <div>
            {{ $this->paginator->withPath('/search?searchtext='.$searchText)->links() }}
        </div>
        @endif

    </div>

    <div>
        <!-- MAKE APPLY FILTERS HERE -->
    </div>


</div>
