<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    public function events(){
    	return $this->belongsToMany('App\Category' , 'categories_events' , 'category_id' , 'event_id');
    }
}
