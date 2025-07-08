<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\RecordsService;

class RecordsController extends Controller
{
    private RecordsService $recordsService;

    public function __construct(
        RecordsService $recordsService,
    ) {
        $this->recordsService = $recordsService;
    }

    public function getRecords() {
        return NotesResource::collection($this->notesRepository->getNotes());
    }

    public function saveRecord(Request $request) {
        if (isset($request->name) && isset($request->points)) {
            $result = $this->recordsService->saveRecord($request);
            if (isset($result)) {
                return response()->json(['message' => 'Saved successfully'], 200);
            }
        }
        return response()->json(['message' => 'Bad request'], 400);
    }
}
