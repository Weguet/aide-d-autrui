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
                {{-- <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-auto"> --}}
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

    <!-- MAIN CONTENT -->
    <main class="max-w-6xl mx-auto px-4 py-10">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Derniers dons disponibles</h2>

            <form method="GET" action="{{ route('welcome') }}" class="flex items-center space-x-2">
                <select name="categorie" onchange="this.form.submit()" class="border border-gray-300 p-2 rounded">
                    <option value=""> -- Toutes les catégories -- </option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat }}" @selected($cat == $categorie)>
                            {{ ucfirst($cat) }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        <!-- Liste des dons -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($dons as $don)
                <div class="bg-white shadow-md rounded-xl overflow-hidden hover:shadow-xl transition duration-300">
                    @if ($don->image)
                        <img src="{{ asset('storage/' . $don->image) }}" alt="Image du don"
                            class="w-full h-48 object-cover">
                    @endif
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-800">{{ $don->titre }}</h3>
                        <p class="text-sm text-gray-500">Catégorie : {{ ucfirst($don->categorie) }}</p>
                        <p class="mt-2 text-sm text-gray-600 line-clamp-2">{{ $don->description }}</p>
                        <p class="text-sm mt-2"><strong>Statut :</strong> {{ ucfirst($don->statut) }}</p>
                        <div class="mt-4 text-right">
                            <a href="{{ route('dons.show', $don) }}"
                                class="text-blue-600 hover:underline text-sm font-medium">Voir le don</a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="col-span-full text-center text-gray-500">Aucun don trouvé.</p>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $dons->withQueryString()->links() }}
        </div>
    </main>

</body>
</html>
