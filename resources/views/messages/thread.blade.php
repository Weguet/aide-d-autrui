<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Conversation avec {{ $user->name }} pour "{{ $don->titre }}"</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @foreach ($messages as $message)
                        <div class="p-3 rounded shadow mb-2
                            @if($message->from_user_id === Auth::id())
                                bg-green-100 text-right ml-10
                            @else
                                bg-gray-100 text-left mr-10 
                            @endif">

                            {{-- Contenu du message --}}
                            <p class="text-sm text-gray-800">
                                {{ $message->contenu }}
                            </p>

                            {{-- Infos : date + badge "Lu" si besoin --}}
                            <div class="text-xs text-gray-500 mt-1 flex items-center justify-between">
                                <span>{{ $message->created_at->format('d/m/Y H:i') }}</span>

                                @if($message->from_user_id === Auth::id())
                                    {{-- Hypothèse : $message->lu existe --}}
                                    @if($message->lu ?? false)
                                        <span class="text-green-600 bg-green-200 px-2 py-0.5 rounded-full text-xs">✔️ Lu</span>
                                    @else
                                        <span class="text-gray-600 bg-gray-200 px-2 py-0.5 rounded-full text-xs">⏳ Non lu</span>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach

                    <form action="{{ route('messages.reply', [$don->id, $user->id]) }}" method="POST" class="mt-4">
                        @csrf
                        <textarea name="contenu" rows="4" class="w-full border rounded p-2" placeholder="Votre message..." required></textarea>
                        <div class="mt-2 text-right">
                            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Envoyer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-3xl mx-auto py-6 space-y-4">
        
    </div>
</x-app-layout>
