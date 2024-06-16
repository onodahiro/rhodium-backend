<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotesResource;

use Illuminate\Http\Request;
use App\Models\Notes;

class NotesController extends Controller
{
    public function getNotes() {
        return NotesResource::collection(Notes::orderBy('created_at', 'desc')->paginate(10));
    }

    public function saveNote(Request $request) {
        Notes::create(['text' => $request->text]);
        return NotesResource::collection(Notes::orderBy('created_at', 'desc')->paginate(10));
    }

    public function checkNote(Request $request) {
        $note = Notes::where('id', $request->id)->first();
        $note->checked = !$note->checked;
        $note->save();
        return NotesResource::collection(Notes::orderBy('created_at', 'desc')->paginate(10));
    }
}
