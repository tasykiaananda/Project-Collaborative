<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Events\NoteUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::latest()->get();
        return view('notes.index', compact('notes'));
    }

    public function store(Request $request)
    {
        $note = Note::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => '',
        ]);

        $html = view('notes.partials.note-card', compact('note'))->render();

        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }

    public function update(Request $request, Note $note)
    {
        $note->update(['content' => $request->content]);
        broadcast(new NoteUpdated($note))->toOthers();
        return response()->json(['status' => 'Updated']);
    }

    public function destroy(Note $note)
    {
        $note->delete();
        return response()->json(['status' => 'Deleted']);
    }
}