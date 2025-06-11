<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Tags extends Model
{
    /**
     * The users that belong to the role.

     *
     * @var array<int, string>
     */
    protected $fillable = [
        'text',
    ];

    public function notes()
    {
        return $this->belongsToMany(Notes::class, 'tag_note');
    }
}
