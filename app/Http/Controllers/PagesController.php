<?php

    namespace App\Http\Controllers;

    use App\Models\Pmodel;
    use App\Models\Product;
    use Inertia\Inertia;

    class PagesController extends Controller
    {

        public function home()
        {
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