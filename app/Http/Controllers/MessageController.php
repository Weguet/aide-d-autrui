<?php

namespace App\Http\Controllers;

use App\Models\Don;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{

    public function index()
    {
        $userId = auth()->id();

        // Tous les messages de l'utilisateur
        $messages = Message::where('from_user_id', $userId)
            ->orWhere('to_user_id', $userId)
            ->with(['don', 'fromUser', 'toUser'])
            ->latest()
            ->get();

        // Groupement par conversation unique (don + autre utilisateur)
        $threads = $messages->groupBy(function ($message) use ($userId) {
            $donId = $message->don_id;
            $otherUserId = $message->from_user_id === $userId ? $message->to_user_id : $message->from_user_id;
            return $donId . '-' . $otherUserId;
        });

        return view('messages.index', compact('threads', 'userId'));
    }

    public function create(Don $don)
    {
        // Vérifie qu'on ne peut pas s'envoyer un message à soi-même
        if ($don->user_id === Auth::id()) {
            abort(403, 'Vous ne pouvez pas vous envoyer un message à vous-même.');
        }

        return view('messages.create', compact('don'));
    }

    public function store(Request $request, Don $don)
    {
        $request->validate([
            'contenu' => 'required|string|max:1000',
        ]);

        Message::create([
            'don_id' => $don->id,
            'from_user_id' => Auth::id(),
            'to_user_id' => $don->user_id,
            'contenu' => $request->contenu,
        ]);

        return redirect()->route('dons.show', $don)->with('success', 'Message envoyé au donateur.');
    }


    public function thread(Don $don, User $user)
    {
        $authId = Auth::id();

        // Empêcher l'utilisateur de lancer un thread avec lui-même
        if ($authId === $user->id) {
            abort(403, 'Vous ne pouvez pas discuter avec vous-même.');
        }


        // N'autoriser que le donateur et l'autre participant à la conversation
        /* if ($authId !== $don->user_id && $authId !== $user->id) {
            abort(403, 'Vous n\'êtes pas autorisé à accéder à cette conversation.');
        } */

     
        // Marquer les messages reçus comme lus
        Message::where('don_id', $don->id)
            ->where('from_user_id', $user->id)
            ->where('to_user_id', $authId)
            ->update(['lu' => true]);

        $messages = Message::where('don_id', $don->id)
            ->where(function ($query) use ($authId, $user) {
                $query->where([
                    ['from_user_id', $authId],
                    ['to_user_id', $user->id],
                ])->orWhere([
                    ['from_user_id', $user->id],
                    ['to_user_id', $authId],
                ]);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return view('messages.thread', compact('messages', 'don', 'user'));
    }

    public function reply(Request $request, Don $don, User $user)
    {
        $request->validate([
            'contenu' => 'required|string|max:1000',
        ]);

        $authId = Auth::id();

        // Destinataire : l’autre utilisateur dans la conversation
        $toUserId = $user->id;

        Message::create([
            'don_id' => $don->id,
            'from_user_id' => $authId,
            'to_user_id' => $toUserId,
            'contenu' => $request->contenu,
            'lu' => false, // Marque comme non lu par défaut
        ]);

        return redirect()->route('messages.thread', [$don->id, $user->id]);
    }

    public function unreadCount()
    {
        $authId = Auth::id();

        $count = Message::where('to_user_id', $authId)
            ->where('lu', false)
            ->count();

        return response()->json(['unread' => $count]);
    }

    
    public function dashboard()
    {
       $user = Auth::user();

        $totalDons = $user->dons()->count();
        $donsDisponibles = $user->dons()->where('statut', 'disponible')->count();
        $donsAttribues = $user->dons()->where('statut', 'donné')->count();

        $totalMessagesRecus = \App\Models\Message::where('to_user_id', $user->id)->count();
        $dernierDon = $user->dons()->latest()->first();

        return view('dashboard', compact(
            'totalDons', 'donsDisponibles', 'donsAttribues', 'totalMessagesRecus', 'dernierDon'
        ));
    }

}
