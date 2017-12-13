<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable=['pName','oPrice','nPrice','stock','description','photo','categoryId'];
}
