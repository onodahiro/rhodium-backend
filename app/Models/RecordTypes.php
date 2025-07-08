<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordTypes extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass fillable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    public function records()
    {
        return $this->hasMany(Records::class, 'record_type_id');
    }
}
