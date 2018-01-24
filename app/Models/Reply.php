<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;


class Reply extends EloquentModel
{
    protected  $fillable = ['content'];

    public function topic()
    {

    	return $this->belongsTo(Topic::class);
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
