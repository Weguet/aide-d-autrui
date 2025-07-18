<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de bord') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900"> 
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="bg-white p-5 rounded shadow">
                            <h3 class="text-lg font-bold text-gray-700">🎁 Total de vos dons</h3>
                            <p class="text-3xl font-semibold text-blue-600 mt-2">{{ $totalDons }}</p>
                        </div>

                        <div class="bg-white p-5 rounded shadow">
                            <h3 class="text-lg font-bold text-gray-700">📦 Dons disponibles</h3>
                            <p class="text-3xl font-semibold text-green-600 mt-2">{{ $donsDisponibles }}</p>
                        </div>

                        <div class="bg-white p-5 rounded shadow">
                            <h3 class="text-lg font-bold text-gray-700">✅ Dons attribués</h3>
                            <p class="text-3xl font-semibold text-purple-600 mt-2">{{ $donsAttribues }}</p>
                        </div>

                        <div class="bg-white p-5 rounded shadow">
                            <h3 class="text-lg font-bold text-gray-700">📨 Messages reçus</h3>
                            <p class="text-3xl font-semibold text-orange-600 mt-2">{{ $totalMessagesRecus }}</p>
                        </div>

                        @if($dernierDon)
                            <div class="bg-white p-5 rounded shadow sm:col-span-2">
                                <h3 class="text-lg font-bold text-gray-700">🕒 Dernier don posté</h3>
                                <p class="text-md mt-1 text-gray-800">Titre : <span class="font-semibold">{{ $dernierDon->titre }}</span></p>
                                <p class="text-sm text-gray-500">Publié le {{ $dernierDon->created_at->format('d/m/Y à H:i') }}</p>
                                <a href="{{ route('dons.show', $dernierDon->id) }}" class="inline-block mt-2 text-blue-600 hover:underline">Voir le don</a>
                            </div>
                        @endif
                    </div> 
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
