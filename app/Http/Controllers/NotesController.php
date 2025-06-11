<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\NotesResource;
use App\Http\Resources\TagsResource;
use App\Services\NotesService;
use App\Repository\NotesRepository;

class NotesController extends Controller
{
    private NotesService $notesService;
    private NotesRepository $notesRepository;

    public function __construct(
        NotesService $notesService,
        NotesRepository $notesRepository,
    ) {
        $this->notesService = $notesService;
        $this->notesRepository = $notesRepository;
    }

    public function getLastPage(Request $request) {
        if ($request->byTagId) {
            $tag = $this->notesRepository->getTag('id', $request->byTagId);
            return $tag ? $tag->notes()->latest()->paginate(10)->lastPage() : 1;
        }
        return $this->notesRepository->getNotesLastPage();
    }

    public function getNotes() {
        return NotesResource::collection($this->notesRepository->getNotes());
    }

    public function getNotesByTag(Request $request) {
        if ($request->id) {
            $notes = $this->notesService->getNotesByTag($request->id);
            if ($notes) {
                return NotesResource::collection($notes);
            }
            return response()->json(['data' => []], 200);
        }
        return response()->json(['message' => 'Bad request'], 400);
    }

    public function createNote(Request $request) {
        if (isset($request->text)) {
            $result = $this->notesService->createNote($request->text);
            if (isset($result)) {
                return response()->json(['message' => 'Saved successfully'], 200);
            }
        }
        return response()->json(['message' => 'Empty text'], 400);
    }

    public function checkNote(Request $request) {
        $id = $this->notesService->checkNote($request->id);
        if (isset($id)) {
            return response()->json(['id' => $id], 200);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    public function getPreloadTags(Request $request) {
        if (isset($request->text)) {
            dd($this->notesRepository->getPreloadTags($request->text));
            return TagsResource::collection($this->notesRepository->getPreloadTags($request->text));
        }
        return response()->json(['data' => []], 200);
    }
}
