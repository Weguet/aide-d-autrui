<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Contacter le donateur pour "{{ $don->titre }}"</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('messages.store', $don->id) }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="contenu" class="block font-medium text-sm">Votre message :</label>
                            <textarea name="contenu" id="contenu" rows="5" required class="w-full border rounded p-2 mt-1">{{ old('contenu') }}</textarea>
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                                Envoyer
                            </button>
                            <a href="{{ url('/') }}" class="text-blue-600 hover:underline">Retour</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
