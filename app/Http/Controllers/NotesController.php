<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

//resources
use App\Http\Resources\NotesResource;
use App\Http\Resources\TagsResource;

use Illuminate\Http\Request;

// services
use App\Services\NotesService;

// models
use App\Models\Notes;
use App\Models\Tags;

class NotesController extends Controller
{

    public function getLastPage(Request $request) {
        if ($request->byTag) {  
            $tag = Tags::where('text', $request->byTag)->first();
            return $tag ? $tag->notes()->paginate(10)->lastPage() : 1;
        }
        return Notes::paginate(10)->lastPage();
    }

    public function getNotes() {
        return NotesResource::collection(NotesService::getNotes());
    }

    public function getPreloadTags(Request $request) { // to do search tags, or get last five
        if (isset($request->text)) {
            return TagsResource::collection(Tags::where('text', 'LIKE', '%'.$request->text.'%')->get());
        }
        return TagsResource::collection(Tags::orderBy('created_at', 'desc')->limit(5)->get());
    }

    public function getNotesByTag(Request $request) { // to do paginated get notes by tag
        if ($request->byTag) {  
            $tag = Tags::where('text', $request->byTag)->first();
            if ($tag) {
                $notes = $tag->notes();
                if ($notes) { // works, if post request
                    return NotesResource::collection($tag->notes()->orderBy('created_at')->paginate(10));
                } else {
                    return response()->json(['data' => []], 200);
                }
            }
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    private function removeTags($string) {
        $tags = [];
        $strings = explode(' ', $string);

        foreach ($strings as $key => $str) {
            if (strlen($str) && $str[0] === '#') {
                $tags[] = $str;
                unset($strings[$key]);
            }
        }

        $text = implode(' ', $strings);
        return ['text' => $text, 'tags' => $tags];
    }

    private function updateTags($tags, $note) {
        foreach ($tags as $tag) {  // to do move into service
            $str_tag = trim(preg_replace('/\#/', '', $tag));
            if(strlen($str_tag)) {
                $Tag = Tags::where('text', $str_tag)->first();
                if ($Tag === null) {
                    $Tag = Tags::create(['text' => $str_tag]);
                }
                $tag_id = $Tag['id'];
                $note->tags()->attach($tag_id);
            }
        }
    }

    public function saveNote(Request $request) {
        if (isset($request->text)) {
            $result = $this->removeTags($request->text);  // to do move into service
            $note = Notes::create(['text' => $result['text']]);
            $this->updateTags($result['tags'], $note);
        } else {
             return response()->json(['message' => 'Empty note text'], 400);
        }
        return response()->json(['message' => 'Saved successfully'], 200);
    }

    public function checkNote(Request $request) {
        $id = NotesService::checkNote($request->id);
        if (isset($id)) {
            return response()->json(['id' => $id], 200);
        }
        return response()->json(['message' => 'Not found'], 404);
    }
}
