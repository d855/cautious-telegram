<?php
    
    namespace App\Http\Controllers;
    
    use App\Models\Pmodel;
    use App\Models\ProductArrival;
    
    class ProductController extends Controller
    {
        
        public function show(Pmodel $model)
        {
            //
        }
        
        public function arrival($product)
        {
            return ProductArrival::select('date', 'quantity', 'product_id')->where('product_id', 'LIKE', $product.'%')->get();
        }
        
    }