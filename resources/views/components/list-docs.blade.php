
@if (count($documentsList) == 0)
    <!-- Image with message when user has no uploads -->
    <div class="flex justify-center items-center">
        {{ $slot }}
    </div>
@else
    <!-- Div to list the documents as links -->
    <div class=" grid grid-cols-1 gap-4 md:grid-cols-4 sm:grid-cols-3 p-6">
        <!-- Listing the documents; each document is a link to open it with details -->
        @foreach ($documentsList as $document)
            <a href="{{ route('document-details', $document->id) }}" class="flex flex-col gap-4 scale-100 p-6 bg-white from-gray-700/50 via-transparent rounded-lg shadow-2xl shadow-gray-500/20 motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-green-500">
                <!-- Icon of the document type and the creation date of the document -->
                <div class="flex justify-between">
                    <img src="{{ asset('icons/'.$document->getExtension().'_icon.png') }}" alt="Logo" class="w-12">
                    <x-description-style> 
                        {{ $document->formatCreatedAt() }} 
                    </x-description-style>
                </div>
                
                <!-- Title and description of the document -->
                <x-doc-details-background>
                    <x-upper-title overflowCase="truncate"> 
                        {{ $document->title }} 
                    </x-upper-title>
                </x-doc-details-background>
                
                <x-description-style class="truncate">
                    {{ $document->description }}
                </x-description-style>

                <x-description-style class="break-all flex justify-end">
                    by: {{ $document->user->username }}
                </x-description-style>
            </a>
        @endforeach
    </div>
@endif