<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskContent extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];
    
    protected $dates = ['limit'];
    
    public function reactions()
    {
        return $this->belongsToMany('App\Models\Reaction')->withTimestamps();
    }

    public function Add()
    {
        $this->save();
    }
}
