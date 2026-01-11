<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fuente y Bootstrap Icons -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CSS + JS compilados por Vite -->
    @vite(['resources/js/main.ts'])
  </head>

  <body class="bg-light">
    <div class="min-vh-100 d-flex flex-column">
      <main class="flex-grow-1">
        {{ $slot }}
      </main>

      <footer class="bg-dark text-center text-light py-3 mt-auto">
        © 2024 <a class="text-light text-decoration-none" href="https://circleoflinks.cloud/">
          circleoflinks.cloud
        </a>
      </footer>
    </div>
  </body>
</html>
