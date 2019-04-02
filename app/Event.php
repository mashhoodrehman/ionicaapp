<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = "event";

    public function user(){
        return $this->hasOne('App\User' , 'id' , 'user_id');
    }

    public function likes(){
        return $this->hasMany('App\Like' , 'post_id' , 'id');
    }
    public function comments(){
        return $this->hasMany('App\Comment' , 'post_id' , 'id');
    }
    public function likedata(){
        return $this->hasMany('App\Like' , 'post_id' , 'id');
    }

    public function interest(){
        return $this->hasMany('App\Interest' , 'post_id' , 'id');
    }

    public function commentsdata(){
        return $this->hasMany('App\Comment' , 'post_id' , 'id');
    }
}
