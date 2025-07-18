<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mes Dons') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4 flex justify-between items-center">
                        <form method="GET" action="{{ route('dons.index') }}" class="flex">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un don..."
                                class="border rounded-l px-3 py-1">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 rounded-r">
                                🔍
                            </button>
                        </form>

                        <a href="{{ route('dons.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                            + Nouveau don
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-200 text-green-800 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="w-full table-auto border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2">Titre</th>
                                <th class="border border-gray-300 px-4 py-2">Catégorie</th>
                                <th class="border border-gray-300 px-4 py-2">Statut</th>
                                <th class="border border-gray-300 px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dons as $don)
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">{{ $don->titre }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ ucfirst($don->categorie) }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        @if ($don->statut === 'disponible')
                                            <span class="text-green-600 font-semibold">Disponible</span>
                                        @elseif ($don->statut === 'réservé')
                                            <span class="text-yellow-600 font-semibold">Réservé</span>
                                        @else
                                            <span class="text-red-600 font-semibold">Donné</span>
                                        @endif
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2 space-x-2">
                                        <a href="{{ route('dons.edit', $don) }}" class="text-blue-600 hover:underline">✏️ Modifier</a>
                                        <form method="POST" action="{{ route('dons.destroy', $don) }}" class="inline"
                                            onsubmit="return confirm('Supprimer ce don ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">🗑 Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center p-4">Aucun don trouvé.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $dons->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
