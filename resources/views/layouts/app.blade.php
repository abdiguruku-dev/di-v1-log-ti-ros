<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Aplikasi Sekolah')</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="body-aurora font-sans text-gray-600 antialiased">
    
    @include('layouts.partials.sidebar')

    {{-- 
        🔥 PERBAIKAN LOKASI GARIS:
        1. 'fixed': Supaya garis tetap nempel di layar walaupun di-scroll.
        2. style="top: 70px;": Menurunkan garis ke bawah Navbar (sesuai tinggi header 70px).
        3. z-50: Supaya tampil di atas elemen lain.
    --}}
    <div class="header-gradient-border fixed left-0 w-full h-1 z-50" style="top: 70px;"></div>

    <div class="main-wrapper flex flex-col min-h-screen relative"> 
        
        {{-- NAVBAR --}}
        <div class="w-full">
            @include('layouts.partials.navbar')
        </div>

        {{-- KONTEN --}}
        <main class="content-area flex-1 w-full">
            @yield('content')
        </main>

        {{-- FOOTER --}}
        <div class="w-full mt-auto">
            @include('layouts.partials.footer')
        </div>
    </div>
</body>
</html>