<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /* CSS Minimalis untuk memperbaiki error vertical-align */
                @layer theme{:root,:host{--font-sans:'Instrument Sans',ui-sans-serif,system-ui,sans-serif;--color-red-500:oklch(.637 .237 25.331);--color-black:#000;--color-white:#fff;--spacing:.25rem;--radius-sm:.25rem;--radius-lg:.5rem;--shadow-md:0 4px 6px -1px #0000001a;--leading-normal:1.5}}
                @layer base{
                    *,:after,:before{box-sizing:border-box;border:0 solid;margin:0;padding:0}
                    html{-webkit-text-size-adjust:100%;line-height:1.5;font-family:var(--font-sans)}
                    a{color:inherit;text-decoration:inherit}
                    /* PERBAIKAN DISINI: Menggunakan inline-block agar vertical-align tidak diabaikan */
                    img,svg,video,canvas,audio,iframe,embed,object{vertical-align:middle;display:inline-block;max-width:100%;height:auto}
                    button,input{font:inherit;background:transparent}
                }
                @layer utilities{
                    .flex{display:flex}.flex-col{flex-direction:column}.items-center{align-items:center}.justify-center{justify-content:center}.justify-end{justify-content:flex-end}.gap-4{gap:1rem}.min-h-screen{min-height:100vh}.w-full{width:100%}.max-w-4xl{max-width:56rem}.p-6{padding:1.5rem}.mb-6{margin-bottom:1.5rem}.rounded-sm{border-radius:0.125rem}.border{border:1px solid #19140035}.text-sm{font-size:0.875rem}.font-medium{font-weight:500}.underline{text-decoration:underline}.bg-white{background-color:#fff}.shadow-sm{box-shadow:0 1px 2px 0 rgba(0,0,0,0.05)}
                    .dark\:bg-black{background-color:#0a0a0a}.dark\:text-white{color:#ededec}
                }
            </style>
        @endif
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        <header class="w-full lg:max-w-4xl text-sm mb-6">
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-block px-5 py-1.5 border rounded-sm">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="inline-block px-5 py-1.5">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-block px-5 py-1.5 border rounded-sm">Register</a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <main class="flex max-w-4xl w-full flex-col lg:flex-row bg-white dark:bg-[#161615] shadow-md rounded-lg overflow-hidden">
            <div class="flex-1 p-8 lg:p-12">
                <h1 class="text-xl font-medium mb-2">Selamat Datang di Project Laravel</h1>
                <p class="text-[#706f6c] dark:text-[#A1A09A] mb-6">Proyek ini sedang dalam tahap pengembangan. Silakan masuk atau daftar untuk melanjutkan.</p>
                
                <div class="flex gap-3">
                    <a href="https://laravel.com/docs" class="px-5 py-2 bg-[#1b1b18] text-white rounded-sm text-sm">Pelajari Dokumen</a>
                </div>
            </div>
        </main>

        <footer class="mt-8 text-sm text-[#706f6c]">
            Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
        </footer>
    </body>
</html>