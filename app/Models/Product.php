<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    use HasFactory;

    protected $guarded = [];

//    public function statuses()
//    {
//        return $this->belongsToMany(Status::class, 'product_statuses');
//    }

    public function getStickersAttribute()
    {
        return ProductSticker::where('product_id', '=', $this->pid)->get();
    }

    public function getStatusAttribute()
    {
        $status = ProductStatus::where('product_id', '=', $this->pid)->first();
        return $status ? Status::find($status['status_id']) : null;
    }

    public function getImageAttribute()
    {
        return Image::where('product_id', '=', $this->pid)->get();
    }

    public function getDescriptionAttribute()
    {
        return substr($this->name, strpos($this->name, ',') + 2);
    }

    public function getStockAttribute()
    {
        return ProductStock::where('product_id', $this->pid)->get();
    }
}