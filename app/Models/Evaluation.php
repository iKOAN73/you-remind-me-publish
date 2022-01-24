<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];
    
    public $timestamps = false;

    public function reactions() {
        return $this->hasMany('App\Reaction');
    }

    public function taskContents() {
        return $this->hasMany('App\TaskContent');
    }
}