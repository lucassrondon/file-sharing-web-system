<div>
    <!-- Setting the header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>
    
    <div class="bg-gray-100 h-full w-full flex flex-col items-center">

        <img src="{{ asset('images/logo.png') }}" alt="" class="w-60">

        <form action="/search" mehtod="get" class="w-4/5 sm:w-2/4 md:w-1/4 flex gap-2">
            <input type="hidden" name="page" value="1">
            <x-input name="searchtext" placeholder="Search a file" autofocus class="w-full" />
            <button class="hover:scale-125 active:scale-100">
                <img src="{{ asset('icons/search_icon.png') }}" alt="search">
            </button>
        </form>

    </div>


    <div>
        <!-- MAKE APPLY FILTERS HERE -->
    </div>


</div>
