<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hand extends Model
{
    //
    public function meeting()
    {
        return $this->belongsTo('App\Meeting');
    }
}
