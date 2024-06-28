<?php

namespace App\Services;

use App\Models\Notes;

/**
 * Class CarriageDislocationService
 * @package App\Services
 */
class NotesService
{
  public static function getNotes() {
    return Notes::orderBy('created_at')->paginate(10);
  }

  public static function checkNote($id) {
    $note = Notes::where('id', $id)->first();
    if ($note) {
      $note->checked = !$note->checked;
      $note->save();
      return $id;
    }
  }
}