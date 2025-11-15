<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name','Aktonz') }} - @yield('title')</title>
  <!-- Add Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <!-- Add Tailwind CSS via CDN (or your compiled CSS) -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.3/dist/tailwind.min.css" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; }
  </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
  <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-lg">
    <div class="text-center mb-6">
      <img src="{{ asset('images/aktonz-logo.png') }}" alt="Aktonz Logo" class="mx-auto h-12">
      <h1 class="text-2xl font-semibold mt-2">{{ config('app.name','Aktonz') }}</h1>
    </div>
    @yield('content')
  </div>
</body>
</html>
