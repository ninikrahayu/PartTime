<?php

namespace App\Http\Controllers;

use App\Models\Lamaran;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Show the chat thread for a lamaran (works for both penyedia and pelamar).
     */
    public function show($lamaran_id)
    {
        $user = Auth::user();
        $lamaran = Lamaran::with(['pelamar.profile', 'lowongan.penyedia.profile'])->findOrFail($lamaran_id);

        // Authorization: only the pelamar or the penyedia of this lamaran can view
        $isPenyedia = $lamaran->lowongan->penyedia_id === $user->id;
        $isPelamar = $lamaran->pelamar_id === $user->id;

        if (!$isPenyedia && !$isPelamar) {
            abort(403);
        }

        // Mark unread messages as read
        Message::where('lamaran_id', $lamaran_id)
            ->where('sender_id', '!=', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $messages = Message::where('lamaran_id', $lamaran_id)
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        $otherUser = $isPenyedia ? $lamaran->pelamar : $lamaran->lowongan->penyedia;
        $layout = $isPenyedia ? 'layouts.penyedia' : 'layouts.mahasiswa';
        $backUrl = $isPenyedia
            ? url('/penyedia/applications/' . $lamaran->id)
            : url('/mahasiswa/applications/' . $lamaran->id);

        return view('chat.show', compact('lamaran', 'messages', 'otherUser', 'layout', 'backUrl', 'isPenyedia'));
    }

    /**
     * Send a message.
     */
    public function store(Request $request, $lamaran_id)
    {
        $request->validate(['body' => 'required|string|max:2000']);

        $user = Auth::user();
        $lamaran = Lamaran::with('lowongan')->findOrFail($lamaran_id);

        $isPenyedia = $lamaran->lowongan->penyedia_id === $user->id;
        $isPelamar = $lamaran->pelamar_id === $user->id;

        if (!$isPenyedia && !$isPelamar) {
            abort(403);
        }

        Message::create([
            'lamaran_id' => $lamaran_id,
            'sender_id' => $user->id,
            'body' => $request->body,
        ]);

        return back()->with('success', 'Pesan terkirim.');
    }
}
