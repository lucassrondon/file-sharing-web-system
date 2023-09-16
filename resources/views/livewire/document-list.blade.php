<div>
    <!-- Setting the header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Your Uploads') }}
        </h2>
    </x-slot>

    <!-- Upload success and failure message divs -->
    <x-success-or-fail-message/>
    
    <!-- Template to list docs -->
    <x-list-docs :documentsList="$documentsList">
        <!-- Img for when there is no docs found -->
        <a href="{{ route('document-upload') }}">
            <img src="{{ asset('images/no_uploads_logo.png') }}" alt="">
        </a>
    </x-list-docs>

</div>
