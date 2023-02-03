<?php

namespace App\Http\Controllers;

use App\Models\Pmodel;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PmodelController extends Controller
{

    public function index($model)
    {
        return getData('sr', "model/$model");
    }

    public function show(Pmodel $model)
    {
//        dd($model);
        $product = getData('sr', "model/$model->id");
        return Inertia::render('Product/Show', [
            'product' => $product,
        ]);
//        dd($product);
    }
}