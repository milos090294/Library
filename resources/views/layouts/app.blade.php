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
        <link rel="stylesheet" href="{{asset ('css/sidebar.css')}}">
        <link rel="stylesheet" href="{{asset ('css/style.css')}}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css  ">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

         <div>
           

        <div class="sidenav">
            <a href="{{ route('book') }}">Books</a>
            <a href="{{ route('member') }}">Members</a>
            <a href="{{ route('user') }}">Users</a>
            <a href="{{ route('issuing') }}">Issuing a book to a member</a>
            <a href="{{ route('return') }}">Returning the book</a>
        </div>
        <div class="arrows">
            <img id="img-click" src="{{asset ('images/arrows.png')}}" alt="" srcset="">
        </div>
         </div>
  
  

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

    
    <script src="{{asset ('js/sidebar.js')}}"></script>
    </body>
</html>
