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
        if (isset($request->text)) {
            Notes::create(['text' => $request->text]);
        } else {
             return response()->json(['message' => 'empty text'], 400);
        }
        return NotesResource::collection(Notes::orderBy('created_at', 'desc')->paginate(10));
    }

    public function checkNote(Request $request) {
        $note = Notes::where('id', $request->id)->first();
        $note->checked = !$note->checked;
        $note->save();
        return response()->json(['id' => $request->id], 200);
    }
}
