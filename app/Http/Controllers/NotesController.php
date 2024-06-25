<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotesResource;

use Illuminate\Http\Request;
use App\Models\Notes;
use App\Models\Tags;

class NotesController extends Controller
{
    public function getLastPage() {
        return Notes::orderBy('created_at')->paginate(10)->lastPage();
    }

    public function getNotes() {
        return NotesResource::collection(Notes::orderBy('created_at')->paginate(10));
    }

    private function removeTags($string) {
        $tags = [];
        $strings = explode(' ', $string);

        foreach ($strings as $key => $str) {
            if ($str[0] === '#') {
                $tags[] = $str;
                unset($strings[$key]); 
            }
        }

        $text = implode(' ', $strings);
        return ['text' => $text, 'tags' => $tags];
    }

    private function updateTags($string) {
        $tags = [];
        $strings = explode(' ', $string);

        foreach ($strings as $str) {
            if(strlen($str) && $str[0] === '#') {
                $str_tag = trim(preg_replace('/\#/', '', $str));
                if (strlen($str_tag)) {
                    $tag = Tags::where('text', $str_tag);
                        if ($tag === null) {
                            Tags::create(['text' => $str_tag]);
                        }
                    Tags::where('text', $str_tag);
                }
                // array_push($tags, $str_tag);
            }
        }
        dd($strings);
        return 'что это';
    }

    public function saveNote(Request $request) {
        if (isset($request->text)) {
            $todoText = $this->removeTags($request->text);
            dd($todoText);
            Notes::create(['text' => $todoText]);
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
