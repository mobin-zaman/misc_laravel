<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function ratings() {
        return $this->hasMany(Ratings::class);
    }

    /**
     * this lets mass assignment in laravel
     * this is just a fancy name for creating an entry in one go
     */

    protected $fillable = ['user_id','title','description'];
}
