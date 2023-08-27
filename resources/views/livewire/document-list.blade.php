<div>
    <!-- Setting the header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Your Uploads') }}
        </h2>
    </x-slot>

    <!-- Upload success and failure message divs -->
    @if (session()->has('successMessage'))
        <div class="text-sm text-green-600 mt-2">{{ session('successMessage') }}</div>
    @endif
    @if (session()->has('failMessage'))
        <div class="text-sm text-red-600 mt-2">{{ session('failMessage') }}</div>
    @endif

    <!-- Div to list the documents as links -->
    <div class="grid grid-cols-1 gap-4 md:grid-cols-3 p-6">
            <!-- Listing the documents; each document is a link to open it with details -->
            @foreach ($documentsList as $document)
            <a href="" class="flex flex-col gap-4 scale-100 p-6 bg-white from-gray-700/50 via-transparent rounded-lg shadow-2xl shadow-gray-500/20 motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-indigo-500">
                <!-- Icon of the document type and the creation date of the document -->
                <div class="flex justify-between">
                    @if ($document->mime_type == 'application/pdf')
                        <i class="fa-solid fa-file-pdf fa-2x"></i>
                    @endif
                    <p class=" text-gray-500 text-sm leading-relaxed">{{ $document->created_at }}</p>
                </div>
                
                <!-- Title and description of the document -->
                <h2 class="p-2 truncate font-semibold text-x text-black uppercase tracking-widest bg-gray-500 border border-transparent rounded-md"> {{ $document->title }}</h2>
                <p class="truncate text-gray-500 text-sm leading-relaxed">{{ $document->description }}</p>
            </a>
            @endforeach
    </div>

</div>
