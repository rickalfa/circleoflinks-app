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

        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

        <!-- Scripts -->
        
   
        @vite(['resources/css/styleboots.css', 'resources/js/app.js'])
      


    </head>
<body class="font-sans">

   
<div class="container-fluid">
 <div class="row-fluid bg-secondary " >
     <div class="px-2 py-4  shadow-md ">
         {{ $slot }}
      </div>

 </div>
 

  <div class="row align-items-end">
      <footer class="bg-body-tertiary text-center text-lg-start">
        <!-- Copyright -->
        <div class="text-center text-light p-3 bg-dark" style="background-color: rgba(0, 0, 0, 0.05); buttom: 10px">
          © 2024 Copyright:
          <a class="text-light" href="https://circleoflinks.cloud/">{{ env('APP_NAME') }}</a>
        </div>
        <!-- Copyright -->
      </footer>

  </div>
</div>


     
    <script>
      function w3_open() {
        document.getElementById("main").style.marginLeft = "25%";
        document.getElementById("mySidebar").style.width = "25%";
        document.getElementById("mySidebar").style.display = "block";
        document.getElementById("openNav").style.display = 'none';
      }
      function w3_close() {
        document.getElementById("main").style.marginLeft = "0%";
        document.getElementById("mySidebar").style.display = "none";
        document.getElementById("openNav").style.display = "inline-block";
      }
      </script>
</body>



</html>
