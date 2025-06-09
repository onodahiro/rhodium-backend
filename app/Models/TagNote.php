<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class TagNote extends Model
{
  protected $fillable = [
    'tags_id',
    'notes_id',
  ];
}
