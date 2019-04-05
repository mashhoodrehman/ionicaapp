<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventImages extends Model
{
    protected $table = 'images_posts';

    public function categories(){
    	return $this->belongsToMany(Event::class);
    }
}
