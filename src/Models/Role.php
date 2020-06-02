<?php

namespace ILOGO\Logoinc\Models;

use Illuminate\Database\Eloquent\Model;
use ILOGO\Logoinc\Facades\Logoinc;

class Role extends Model
{
    protected $guarded = [];

    public function users()
    {
        $userModel = Logoinc::modelClass('User');

        return $this->belongsToMany($userModel, 'user_roles')
                    ->select(app($userModel)->getTable().'.*')
                    ->union($this->hasMany($userModel))->getQuery();
    }

    public function permissions()
    {
        return $this->belongsToMany(Logoinc::modelClass('Permission'));
    }
}
