<?php

    namespace App\Http\Controllers;

    use App\Models\Pmodel;
    use App\Models\Product;
    use App\Models\ProductArrival;
    use Illuminate\Http\Request;
    use Inertia\Inertia;

    class ProductController extends Controller
    {

        public function show(Pmodel $model)
        {
            //
        }
    
        public function arrival($product)
        {
            return ProductArrival::where('product_id', $product);
        }

    }