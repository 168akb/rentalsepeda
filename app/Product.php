<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
	use SoftDeletes;

    protected $guarded = [];
    protected $dates = ['deleted_at'];
    
    public function sepeda_kategori() {
        return $this->belongsTo('App\sepeda_kategori');
    }

    public function merek(){
    	return $this->belongsTo('App\Merek');
    }
}
