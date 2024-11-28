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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.navigation')
        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    <script>
        // Função para alternar entre temas
        const themeToggleButton = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const currentTheme = localStorage.getItem('theme') || 'light';

        // Definir tema inicial
        if (currentTheme === 'dark') {
            document.documentElement.classList.add('dark');
            themeIcon.textContent = '🌙'; // Ícone da lua
        } else {
            themeIcon.textContent = '🌞'; // Ícone do sol
        }

        // Alternar entre os temas
        themeToggleButton.addEventListener('click', () => {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                themeIcon.textContent = '🌞'; // Ícone do sol
                localStorage.setItem('theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                themeIcon.textContent = '🌙'; // Ícone da lua
                localStorage.setItem('theme', 'dark');
            }
        });
    </script>
</body>

</html>
