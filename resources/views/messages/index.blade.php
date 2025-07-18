<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Mes messages</h2>
    </x-slot>

    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-semibold mb-4">Mes discussions</h1>

                    @forelse($threads as $key => $messages)
                        @php
                            $latest = $messages->sortByDesc('created_at')->first();
                            $don = $latest->don;
                            $otherUser = $latest->from_user_id === $userId ? $latest->toUser : $latest->fromUser;

                            // Messages non lus pour ce thread
                            $unread = $messages->where('to_user_id', $userId)->where('lu', false)->count();
                        @endphp

                        <div class="mb-4 border rounded-lg p-4 shadow-sm">
                            <h2 class="text-lg font-semibold">{{ $don->titre ?? 'Don sans titre' }}</h2>
                            <p class="text-sm text-gray-600">Avec : {{ $otherUser->name }}</p>
                            <p class="mt-1 text-sm text-gray-800 italic">
                                {{ Str::limit($latest->contenu, 80) }}
                            </p>

                            <div class="mt-2 flex justify-between items-center">
                                <a href="{{ route('messages.thread', [$don->id, $otherUser->id]) }}"
                                class="text-blue-600 hover:underline text-sm">
                                    Voir la conversation
                                </a>

                                @if($unread > 0)
                                    <span class="inline-block bg-red-600 text-white text-xs px-2 py-0.5 rounded-full">
                                        {{ $unread }} nouveau{{ $unread > 1 ? 'x' : '' }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">Aucune discussion trouvée.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
