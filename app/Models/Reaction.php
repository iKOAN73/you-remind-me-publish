<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [
        'id',
    ];

    public function taskContents()
    {
        return $this->belongsToMany('App\Models\TaskContent')->withTimestamps();
    }
    
    public function evaluation()
    {
        return $this->belongsTo('App\Models\Evaluation');
    }
}
