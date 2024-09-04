<?php

namespace App\Repository;

use App\Models\Notes;
use App\Models\Tags;


/**
 * Class NotesRepository
 */
class NotesRepository
{
  public function getNote($param, $value) {
    return Notes::where($param, $value)->first();
  }

  public function getNotesLastPage() {
    return Notes::paginate(10)->lastPage();
  }

  public function getNotes() {
    return Notes::latest()->paginate(10);
  }

  public function createNote($value) {
    return  Notes::create($value);
  }

  public function getTag($param, $value) {
    return Tags::where($param, $value)->first();
  }

  public function createTag($value) {
    return  Tags::create($value);
  }

  public function getPreloadTags($value) {
    return  Tags::where('text', 'LIKE', '%'.$value.'%')->limit(5)->get();
  }

  public function getLastTags() {
    return Tags::orderBy('created_at', 'desc')->limit(5)->get();
  }
}
