<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ env('APP_NAME') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <!-- Scripts -->
        
   
        @vite(['resources/css/styleboots.css', 'resources/js/app.js'])
      


    </head>
    <body class="font-sans text-gray-900 ">

            <div class="w-full  px-6 py-4 bg-secondary dark:bg-gray-800 shadow-md ">
                {{ $slot }}
            </div>
    
       
 </body>


 <footer class="bg-body-tertiary text-center text-lg-start">
    <!-- Copyright -->
    <div class="text-center text-light p-3 bg-dark" style="background-color: rgba(0, 0, 0, 0.05);">
      © 2024 Copyright:
      <a class="text-light" href="https://circleoflinks.cloud/">{{ env('APP_NAME') }}</a>
    </div>
    <!-- Copyright -->
  </footer>
</html>
