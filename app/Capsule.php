<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Capsule extends Model
{
    //
    protected $fillable = ['capsule_serial','capsule_id','status','original_launch','original_launch_unix','landings','type','details','reuse_count'
    ];

    public function getMissions()
    {
    	return $this->hasMany('App\Mission','capsule_id');
    }
}
