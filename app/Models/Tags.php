<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Tags extends Model
{
    /**
     * The users that belong to the role.
     */
    public function notes()
    {
        return $this->belongsToMany(Notes::class, 'tag_note');
    }
}