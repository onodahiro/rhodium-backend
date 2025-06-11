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
    return RecordTypes::create($data);
  }

  public function getRecordTypes() {
    return RecordTypes::all();
  }

  public function createRecord($req) {
    $recordsCount = Records::count();

    $data = [
      'record_type_id' => $req['type_id'],
      'text' => $req['text'],
      'order' => $recordsCount + 1,
    ];

    return Records::create($data);
  }

  public function getRecordsByTheme($themeId) {
    $theme = RecordTypes::find($themeId);
    return $theme->records()->get();
  }
}
