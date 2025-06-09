<?php

namespace App\Repository;

use App\Models\Records;
use App\Models\RecordTypes;


/**
 * Class RecordsRepository
 */
class RecordsRepository
{

  public function getRecords() {
    return Notes::latest()->paginate(10);
  }

  public function createRecord($value) {
    return  Records::create($value);
  }

    public function createRecordType($value) {
    return  RecordTypes::create($value);
  }
}
