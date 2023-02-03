<?php

    namespace App\Http\Controllers;

    use App\Models\Pmodel;
    use App\Models\Product;
    use Illuminate\Http\Request;
    use Inertia\Inertia;

    class PagesController extends Controller
    {

        public function home()
        {
            //            $product = Product::where('pid', '=', '3777910')->first();
            return Inertia::render('Home', [
                'latest' => PModel::orderBy('sort', 'asc')
                                  ->paginate(12),
                'products' => Product::latest()->paginate(10)->append([
                    'stickers',
                    'status',
                    'image',
                    'description',
                    'stock'
                ])
            ]);
        }

    }