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
    <body class="font-sans text-gray-900 antialiased">

   <!-- Barra de navegacion -->  
   <nav class="navbar  navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Circle of links</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse nav justify-content-end" id="navbarTogglerDemo02">
        <ul class="navbar-nav nav-pills">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="#scrollspyHeading1">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#scrollspyHeading2">Project</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#scrollspyHeading3" >API Doc</a>
         
          </li>

         

          <li class="nav-item dropdown dropstart">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person" style="font-size: 1.1rem; color: rgb(179, 13, 179);"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark">
              <li><a class="dropdown-item" href="#">Perfil</a></li>
              <li><a class="dropdown-item" href="#">config</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </li>

  



        </ul>
  
      

      </div>

     
    </div>
  </nav>



        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            <div>
                <a href="#">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>
        

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>

       
 </body>
</html>
