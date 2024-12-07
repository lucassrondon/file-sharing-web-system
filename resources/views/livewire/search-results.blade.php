<div>
    <!-- Setting the header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Search') }}
        </h2>
    </x-slot>
    
    <div class="w-full">
        <div class="w-full flex flex-col items-center justify-center gap-4 mt-4 p-4 bg-white rounded-md shadow-md">
            <!-- Search Form -->
            <form method="GET" action="{{ route('search') }}" class="w-full flex flex-col gap-4">
                <!-- Any field -->
                <div class="flex flex-col">
                    <x-input name="any" value="{{ $any }}" placeholder="Search in any field" class="w-full bg-gray-100"/>
                </div>

                <!-- Fields arranged side by side -->
                <div class="flex flex-wrap gap-4">
                    <!-- Title -->
                    <div class="flex-1 min-w-[200px]">
                        <x-input name="title" value="{{ $title }}" placeholder="Search by title" class="w-full bg-gray-100"/>
                    </div>

                    <!-- Description -->
                    <div class="flex-1 min-w-[200px]">
                        <x-input name="description" value="{{ $description }}" placeholder="Search by description" class="w-full bg-gray-100"/>
                    </div>
                </div>

                <!-- Fields arranged side by side -->
                <div class="flex flex-wrap gap-4">
                    <!-- Institution -->
                    <div class="flex-1 min-w-[200px]">
                        <x-input name="institution" value="{{ $institution }}" placeholder="Search by institution" class="w-full bg-gray-100"/>
                    </div>

                    <!-- Subject -->
                    <div class="flex-1 min-w-[200px]">
                        <x-input name="subject" value="{{ $subject }}" placeholder="Search by subject" class="w-full bg-gray-100"/>
                    </div>
                </div>

                <!-- Doc Type and Start Date -->
                <div class="flex flex-wrap gap-4">
                    <!-- Doc Type -->
                    <div class="flex-1 min-w-[200px]">
                        <select name="mimeType" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 bg-gray-100">
                            <option value="">Select Document Type</option>
                            <option value="application/pdf" {{ $mimeType === 'application/pdf' ? 'selected' : '' }}>PDF</option>
                            <option value="text/plain" {{ $mimeType === 'text/plain' ? 'selected' : '' }}>Txt</option>
                            <option value="text/csv" {{ $mimeType === 'text/csv' ? 'selected' : '' }}>Csv</option>
                            <option value="application/vnd.openxmlformats-officedocument.wordprocessingml.document" {{ $mimeType === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ? 'selected' : '' }}>Microsoft Word</option>
                            <option value="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" {{ $mimeType === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' ? 'selected' : '' }}>Excel</option>
                        </select>
                    </div>

                    <!-- Start Date -->
                    <div class="flex-1 min-w-[200px]">
                        <x-input name="startDate" type="date" value="{{ $startDate }}" class="w-full bg-gray-100"/>
                    </div>
                </div>

                <!-- Topic and Search in Text -->
                <div class="flex flex-wrap gap-4">
                    <!-- Topic -->
                    <div class="flex-1 min-w-[200px]">
                        <x-input name="tag" value="{{ $tag }}" placeholder="Search by topic" class="w-full bg-gray-100"/>
                    </div>

                    <!-- Search in Text -->
                    <div class="flex-1 min-w-[200px]">
                        <x-input name="searchInText" value="{{ $searchInText }}" placeholder="Search in text content" class="w-full bg-gray-100"/>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-center mt-4">
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Search
                    </button>
                </div>
            </form>
            
            <!-- Error Message -->
            @error('any') <x-span-danger>{{ $message }}</x-span-danger> @enderror
        </div>

        <!-- Results -->
        <x-list-docs :documentsList="$documentsList">
            <!-- Img for when there is no docs found -->
            <img src="{{ asset('images/no_matches_logo.png') }}" alt="No matches found">
        </x-list-docs>

        <!-- Pagination -->
        @if($this->links)
            {{ $this->links }}
        @endif
    </div>
</div>
