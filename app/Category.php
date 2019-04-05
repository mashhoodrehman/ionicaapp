<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    public function events(){
    	return $this->belongsToMany('App\Category' , 'categories_events' , 'event_id' , 'category_id');
    }
}
