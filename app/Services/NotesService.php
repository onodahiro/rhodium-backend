<?php

namespace App\Services;

use App\Repository\NotesRepository;

/**
 * Class NotesService
 * @package App\Services
 */
class NotesService
{

  // Repositories
  private NotesRepository $notesRepository;

  public function __construct(
    NotesRepository $notesRepository,
  ) {
      $this->notesRepository = $notesRepository;
  }

  public function saveNote($text) {
    $result = $this->removeTagsFromText($text);
    $note = $this->notesRepository->createNote(['text' => $result['text']]);
    $this->updateTags($result['tags'], $note);
    if ($note) {
      return true;
    }
  }

  public function checkNote($id) {
    $note = $this->notesRepository->getNote('id', $id);
    if ($note) {
      $note->checked = !$note->checked;
      $note->save();
      return $id;
    }
  }

  public function getNotesByTag($val) {
    $tag = $this->notesRepository->getTag('id', $val);
    if ($tag) {
      $notes = $tag->notes();
      if ($notes) {
          return $tag->notes()->orderBy('created_at')->paginate(10);
      }
    }
  }

  private function removeTagsFromText($string) {
    $tags = [];
    $strings = explode(' ', $string);

    foreach ($strings as $key => $str) {
        if (strlen($str) && $str[0] === '#') {
            $tags[] = $str;
            unset($strings[$key]);
        }
    }

    $text = implode(' ', $strings);
    return ['text' => $text, 'tags' => $tags];
  }

  private function updateTags($tags, $note) {
    foreach ($tags as $tag) {
        $str_tag = trim(preg_replace('/\#/', '', $tag));
        if(strlen($str_tag)) {
            $Tag = $this->notesRepository->getTag('text', $str_tag);
            if ($Tag === null) {
                $Tag = $this->notesRepository->createTag(['text' => $str_tag]);
            }
            $tag_id = $Tag['id'];
            $note->tags()->attach($tag_id);
        }
    }
  }
}
