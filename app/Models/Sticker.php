<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Sticker extends Model
{
    use HasFactory, HasTranslations;
    public $translatable = ['name', 'type'];

    protected $guarded = [];

    public  function products(){
        return $this->belongsToMany(Product::class);
    }
}