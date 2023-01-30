<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public  function stickers(){
        return $this->belongsToMany(Sticker::class, 'product_sticker', 'product_id');
    }
}