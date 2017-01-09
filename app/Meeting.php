<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    //
    public function hands()
    {
        return $this->hasMany('App\Hand');
    }
}
