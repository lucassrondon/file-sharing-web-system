<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->

        <!-- Font awesome script -->
        <!-- <script src="https://kit.fontawesome.com/0ca14f61f4.js" crossorigin="anonymous"></script> -->

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts
        <script>
            /* When the user makes a search, the component
            sends an event to the browser so it can push the 
            search into the history stack, so when the user
            navigates through the history, the pages can be 
            loaded again
             */
            window.addEventListener('hasSearch', event => {
                window.history.pushState(
                    { page: event.detail.searchtext }, 
                    'Dashboard', 
                    '/dashboard/' + event.detail.searchtext
                );
            });

            /* 
            Listenig for browser history navigation and
            handling the action for each route
            */
            window.addEventListener('popstate', event => {
                const currentPath = window.location.pathname;

                /* dashboard route shows the search results;
                so if the user navigates through the browser
                history, the search text of that route is sent 
                to the componentt so it can load the data for that page  */
                if (currentPath.startsWith('/dashboard')) {
                    let searchText = false;

                    parts = currentPath.split('/');
                    if (parts.length == 3) {
                        searchText = parts[2];
                    }
                    livewire.emit('popState', searchText);
                }
            });

        </script>
    </body>
</html>
