<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'App') — {{ config('app.name') }}</title>

    {{-- Tailwind CSS CDN (ganti dengan vite jika sudah setup) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @stack('styles')
</head>
<body class="bg-gray-50 font-sans text-gray-900 antialiased">

<div class="flex min-h-screen">

    {{-- ===================== SIDEBAR ===================== --}}
    <x-sidebar :active="$active" />

    {{-- ===================== MAIN CONTENT ===================== --}}
    <main class="ml-64 flex-1 overflow-y-auto">
        @yield('content')
    </main>

</div>

@stack('scripts')
</body>
</html>