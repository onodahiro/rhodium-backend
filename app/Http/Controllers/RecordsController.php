<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RecordsService;
use App\Http\Controllers\Controller;
use App\Http\Resources\RecordTypesResource;
use App\Models\RecordTypes;

class RecordsController extends Controller
{
    private RecordsService $recordsService;

    public function __construct(
        RecordsService $recordsService,
    ) {
        $this->recordsService = $recordsService;
    }

    public function createType(Request $request) {
        $request->validate([
            'name' => 'required|max:255|unique:record_types',
        ]);

        return $this->recordsService->createRecordType($request->all());
    }

    public function getTypes() {
        return RecordTypesResource::collection(RecordTypes::all());
    }

    public function createRecord(Request $request) {
        $request->validate([
            'type_id' => 'required',
            'text' => 'required|max:1000',
        ]);

        return $this->recordsService->createRecord($request->all());
    }

    public function getRecords(Request $request) {
        return $this->recordsService->getRecordsByTheme($request?->type_id);
    }
}
