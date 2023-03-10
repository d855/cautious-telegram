<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Status extends Model
{
    use HasFactory, HasTranslations;
    public $translatable = ['name'];

    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_statuses');
    }
}