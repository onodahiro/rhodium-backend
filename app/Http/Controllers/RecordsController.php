<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\RecordsService;
use Exception;

class RecordsController extends Controller
{
    private RecordsService $recordsService;

    public function __construct(
        RecordsService $recordsService,
    ) {
        $this->recordsService = $recordsService;
    }

    public function createType(Request $request) {
        try {
            $request->validate([
                'name' => 'required|max:255',
            ]);
            $result = $this->recordsService->createRecordType($request->all());

            if (isset($result)) {
                return response()->json(['message' => 'Saved successfully'], 200);
            }
        } catch (Exception $e) {
            return response()->json(['message' => $e], 400);
        }
    }

    public function getTypes() {
        return $this->recordsService->getRecordTypes();
    }

    public function createRecord(Request $request) {
        try {
            $request->validate([
                'type_id' => 'required',
                'text' => 'required|max:1000',
            ]);
            $result = $this->recordsService->createRecord($request->all());

            if (isset($result)) {
                return response()->json(['message' => 'Saved successfully'], 200);
            }
        } catch (Exception $e) {
            return response()->json(['message' => $e], 400);
        }
    }

    public function getRecords(Request $request) {
        try {
            return $this->recordsService->getRecordsByTheme($request?->type_id);
        } catch (Exception $e) {
            return response()->json(['message' => $e], 400);
        }
    }
}
