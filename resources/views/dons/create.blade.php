<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nouveau don') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('dons.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="titre" class="block text-gray-700 font-bold mb-2">Titre</label>
                            <input type="text" name="titre" id="titre" value="{{ old('titre') }}" required
                                class="border rounded w-full px-3 py-2 @error('titre') border-red-500 @enderror">
                            @error('titre')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 font-bold mb-2">Description</label>
                            <textarea name="description" id="description" required
                                class="border rounded w-full px-3 py-2 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="categorie" class="block text-gray-700 font-bold mb-2">Catégorie</label>
                            <select name="categorie" id="categorie" required
                                class="border rounded w-full px-3 py-2 @error('categorie') border-red-500 @enderror">
                                <option value="">-- Choisir --</option>
                                <option value="nourriture" {{ old('categorie') == 'nourriture' ? 'selected' : '' }}>Nourriture</option>
                                <option value="vêtements" {{ old('categorie') == 'vêtements' ? 'selected' : '' }}>Vêtements</option>
                                <option value="meubles" {{ old('categorie') == 'meubles' ? 'selected' : '' }}>Meubles</option>
                                <option value="électronique" {{ old('categorie') == 'électronique' ? 'selected' : '' }}>Électronique</option>
                            </select>
                            @error('categorie')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="localisation" class="block text-gray-700 font-bold mb-2">Localisation</label>
                            <input type="text" name="localisation" id="localisation" value="{{ old('localisation') }}"
                                class="border rounded w-full px-3 py-2 @error('localisation') border-red-500 @enderror">
                            @error('localisation')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="statut" class="block text-gray-700 font-bold mb-2">Statut</label>
                            <select name="statut" id="statut" required
                                class="border rounded w-full px-3 py-2 @error('statut') border-red-500 @enderror">
                                <option value="disponible" {{ old('statut') == 'disponible' ? 'selected' : '' }}>Disponible</option>
                                <option value="réservé" {{ old('statut') == 'réservé' ? 'selected' : '' }}>Réservé</option>
                                <option value="donné" {{ old('statut') == 'donné' ? 'selected' : '' }}>Donné</option>
                            </select>
                            @error('statut')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="image" class="block text-gray-700 font-bold mb-2">Image (optionnelle)</label>
                            <input type="file" name="image" id="image" accept="image/*"
                                class="border rounded w-full px-3 py-2 @error('image') border-red-500 @enderror">
                            @error('image')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Enregistrer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-lg mx-auto py-6 px-4">
      
    </div>
</x-app-layout>
