<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $table = "type_products";
//Quan he 1 nhieu
    public function product(){
        return $this->hasMany('App\Product','id_type','id');
    }
}
