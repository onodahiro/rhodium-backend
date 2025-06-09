<?php

namespace App\Services;

use App\Repository\RecordsRepository;

/**
 * Class RecordsService
 * @package App\Services
 */
class RecordsService
{

  // Repositories
  private RecordsRepository $recordsRepository;

  public function __construct(
    RecordsRepository $recordsRepository,
  ) {
      $this->recordsRepository = $recordsRepository;
  }

  public function saveRecord($req) {
    // dd(1);
    $res = $this->recordsRepository->createRecord(['name' => $req['name'], 'points' => $req['points']]);
    if ($res) {
      return true;
    }
  }
}
