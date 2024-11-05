<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>

    <link rel="stylesheet" href="/build/assets/app-DMXIxZ_f.css">
    <link rel="stylesheet" href="/build/assets/app-CW2gkweu.css">

    {{-- TAILWIND CSS 
    {{-- @vite('resources/css/app.css') --}}

    <link rel="stylesheet" href="/build/assets/app-DMXIxZ_f.css">
    <link rel="stylesheet" href="/build/assets/app-CW2gkweu.css">


    {{-- FLOWBITE CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full space-y-8 border border-gray-300">
        <div class="text-center">
            <svg class="w-16 h-16 mx-auto text-red-500 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6M12 9v6M4.293 4.293a1 1 0 011.414 0L12 8.586l6.293-6.293a1 1 0 111.414 1.414L13.414 10l6.293 6.293a1 1 0 01-1.414 1.414L12 12.414l-6.293 6.293a1 1 0 01-1.414-1.414L10.586 12 4.293 5.707a1 1 0 010-1.414z"/>
            </svg>
            <h1 class="text-3xl font-extrabold text-red-600 mb-2">Oops! Something went wrong.</h1>
            <p class="text-gray-600 text-lg">[403] We couldn't process your request.</p>
        </div>
        <div class="text-center">
            <p class="text-gray-700 text-md mb-4">{{ session('message') }}</p>
            <a onclick="window.history.back()" class="inline-flex items-center px-4 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-md shadow-md transition duration-150 ease-in-out">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12l5 5L20 7"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- TAILWIND SCRIPT  --}}
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script src="/build/assets/app-CFG0kKgu.js "></script>
</body>
</html>
