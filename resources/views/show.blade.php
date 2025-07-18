<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bienvenue - Aide d’autrui</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .btn-primary {
            @apply bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition;
        }

        .btn-outline {
            @apply border border-blue-600 text-blue-600 px-4 py-2 rounded hover:bg-blue-50 transition;
        }

        .line-clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
    </style>
</head>

<body class="bg-gray-50 text-[#1b1b18]">

    <!-- HEADER -->
    <header class="w-full py-4 bg-white shadow sticky top-0 z-50">
        <div class="max-w-6xl mx-auto flex justify-between items-center px-4">
            <div class="flex items-center space-x-2">
               {{--  <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-auto"> --}}
                <a href="{{ url('/') }}"><span class="text-xl font-bold text-gray-800 tracking-wide">AIDE D'AUTRUI</span></a>
            </div>
            @if (Route::has('login'))
                <nav class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-primary">Tableau de bord</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-outline">Connexion</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-primary">S'inscrire</a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
    </header>

    <!-- Contenu principal -->
    <main class="max-w-6xl mx-auto px-4 py-10 w-full flex justify-center">
        <div class="max-w-3xl w-full bg-white rounded-xl shadow-md p-6">
            <h1 class="text-2xl font-bold mb-4">{{ $don->titre }}</h1>

            @if($don->image)
                <img src="{{ asset('storage/' . $don->image) }}" alt="Image du don" class="w-full max-w-xs mx-auto h-64 object-cover rounded-lg mb-6">
            @endif

            <div class="space-y-2 text-gray-800 text-base">
                <p><span class="font-semibold">Catégorie :</span> {{ ucfirst($don->categorie) }}</p>
                <p><span class="font-semibold">Description :</span> {{ $don->description }}</p>
                <p><span class="font-semibold">Statut :</span> {{ ucfirst($don->statut) }}</p>

                @if($don->user)
                    <p><span class="font-semibold">Donateur :</span> {{ $don->user->name ?? 'Inconnu' }}</p>
                @endif
            </div>

            <!-- Boutons -->
            <div class="mt-8 flex flex-wrap gap-4">
                @if(Auth::check())
                    @if(Auth::id() !== $don->user_id)
                        <a href="{{ route('messages.thread', [$don->id, $don->user_id]) }}"
                        class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Contacter le donateur
                        </a>
                    @endif
                @else
                    <a href="{{ route('register') }}"
                    class="inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Connectez-vous pour contacter le donateur
                    </a>
                    <a href="{{ url('/') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Retour à l'accueil
                    </a>
                @endif
              {{-- @auth
                    @if($don->statut === 'disponible' && auth()->id() !== $don->user_id)
                        <a href="{{ route('messages.create', ['don' => $don->id]) }}"
                           class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                            Contacter le donateur
                        </a>
                    @endif
                    <a href="{{ url('/') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Retour à l'accueil
                    </a>
                @else
                    <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Connectez-vous pour contacter le donateur
                    </a>
                    <a href="{{ url('/') }}" class="bg-lime-600 text-white px-4 py-2 rounded hover:bg-lime-700">
                        Retour à l'accueil
                    </a>
                @endauth --}}
            </div>
        </div>
    </main>

    @if (Route::has('login'))
        <div class="h-14 hidden lg:block"></div>
    @endif

</body>
</html>
