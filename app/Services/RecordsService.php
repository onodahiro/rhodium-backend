<?php

namespace App\Services;

use App\Models\RecordTypes;
use App\Models\Records;

/**
 * Class RecordsService
 * @package App\Services
 */
class RecordsService
{

  public function createRecordType($data) {
    $type = RecordTypes::create($data);

    if ($type) {
      return response()->json(['message' => 'Success'], 200);
    }

    return response()->json(['message' => 'Bad request'], 400);
  }

  public function createRecord($req) {
    $recordsCount = Records::count();

    $data = [
      'record_type_id' => $req['type_id'],
      'text' => $req['text'],
      'order' => $recordsCount + 1,
    ];

    $record = Records::create($data);

    if ($record) {
      return response()->json(['message' => 'Success'], 200);
    }

    return response()->json(['message' => 'Bad request'], 400);
  }

  public function getRecordsByTheme($themeId) {
    $theme = RecordTypes::find($themeId);
    return $theme->records()->get();
  }
}
