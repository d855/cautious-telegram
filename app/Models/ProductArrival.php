<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ProductArrival extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['value'];
    protected $guarded = [];
}