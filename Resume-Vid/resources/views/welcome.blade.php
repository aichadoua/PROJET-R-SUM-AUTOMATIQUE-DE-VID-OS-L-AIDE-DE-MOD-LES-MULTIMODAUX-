<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Résumé Vidéo</title>

    <!-- Tailwind CSS et Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Animate.css pour les animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        .bg-hero {
            background-image: url('{{ asset('image/vedeo1.jpg') }}');
            background-size: cover;
            background-position: center;
        }

        .overlay {
            background: rgba(0, 0, 0, 0.65);
        }
    </style>
</head>

<body class="min-h-screen bg-hero bg-cover bg-center flex flex-col">

    <!-- Superposition sombre -->
    <div class="overlay flex flex-col min-h-screen">

        <!-- Navigation -->
        <header class="w-full p-6 flex justify-end absolute top-0 right-0 z-10">
            @if (Route::has('login'))
                <nav class="space-x-4 animate__animated animate__fadeInDown animate__delay-1s">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="inline-block px-6 py-3 bg-blue-900 hover:bg-blue-800 text-white text-lg font-semibold rounded shadow animate__animated animate__zoomIn animate__delay-2s">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="inline-block px-6 py-3 bg-blue-900 hover:bg-blue-800 text-white text-lg font-semibold rounded shadow animate__animated animate__zoomIn animate__delay-2s">
                            S’identifier
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                              class="inline-block px-6 py-3 bg-blue-900 hover:bg-blue-800 text-white text-lg font-semibold rounded shadow animate__animated animate__zoomIn animate__delay-2s">
                                S’inscrire
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <!-- Contenu principal -->
        <main class="flex-grow flex items-center justify-start px-6 md:px-16">
            <div class="max-w-2xl text-left text-white space-y-8 animate__animated animate__fadeInLeft animate__delay-1s">
                <h1 class="text-4xl md:text-5xl font-bold leading-tight">
                    Transformez vos vidéos en résumés intelligents, en un clic.
                </h1>

                <p class="text-lg md:text-xl text-gray-200">
                    Gagnez du temps. Résumez vos vidéos en quelques secondes avec un audio clair et précis.
                    Étudiez, révisez ou informez-vous sans effort.
                </p>

               <a href="#"
   class="inline-block px-6 py-3 bg-blue-900 hover:bg-blue-800 text-white text-lg font-semibold rounded shadow animate__animated animate__zoomIn animate__delay-2s">
   Essayez gratuitement 🎧
</a>
            </div>
        </main>

    </div>
</body>

</html>
