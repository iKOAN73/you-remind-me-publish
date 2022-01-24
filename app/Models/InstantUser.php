<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstantUser extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public static function GetUserList() 
    {
        $users = InstantUser::all();
        $column = array_keys($users[0]->original);
        unset($column[0]);

        return [
            'users' => $users,
            'column' => $column,
        ];
    }

    public static function GetColumns()
    {
        $dum = new InstantUser;
        $column = $dum->getConnection()->getSchemaBuilder()->getColumnListing($dum->getTable());
        return $column;
    }

    public function AddUser()
    {
        $this->save();
    }

    public static function ExistsUser($iid)
    {
        return self::where('instant_id', $iid)->exists();
    }

    public function tasks() {
        return $this->hasMany('App\Task');
    }
}