<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];
    
    public function users()
    {
        return $this->belongsTo('App\Models\InstantUser');
    }    
    
    public function contents()
    {
        return $this->hasMany('App\Models\TaskContent');
    }

    public function evaluations()
    {
        return $this->hasMany('App\Models\Evaluation');
    }
}
