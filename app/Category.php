<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $primary = 'category_id';

    public function events(){
    	return $this->belongsToMany('App\Category' , 'categories_events' , 'event_id' , 'category_id');
    }
}
