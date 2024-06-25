<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotesResource;

use Illuminate\Http\Request;
use App\Models\Notes;

class NotesController extends Controller
{
    public function getLastPage() {
        return Notes::orderBy('created_at')->paginate(10)->lastPage();
    }

    public function getNotes() {
        return NotesResource::collection(Notes::orderBy('created_at')->paginate(10));
    }

    private function getTags($string) {
        $tags = [];
        $strings = explode(' ', $string);
        foreach ($strings as $str) {
            if(strlen($str) && $str[0] === '#') {
                $str_tag = trim(preg_replace('/\#/', '', $str));
                if (strlen($str_tag)) array_push($tags, $str_tag);
            }
        }
        return $tags;
    }

    public function saveNote(Request $request) {
        if (isset($request->text)) {
            $this->getTags($request->text);
            Notes::create(['text' => $request->text]);
        } else {
             return response()->json(['message' => 'Empty note text'], 400);
        }
        return response()->json(['message' => 'Saved successfully'], 200);
    }

    public function checkNote(Request $request) {
        $note = Notes::where('id', $request->id)->first();
        $note->checked = !$note->checked;
        $note->save();
        return response()->json(['id' => $request->id], 200);
    }
}
