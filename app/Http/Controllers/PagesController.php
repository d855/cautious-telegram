<?php
    
    namespace App\Http\Controllers;
    
    use App\Models\Pmodel;
    use App\Models\Product;
    use Inertia\Inertia;
    
    class PagesController extends Controller
    {
        
        public function home()
        {
//            dd(PModel::orderBy('sort', 'asc')->where('name', 'MASTER MEN 180')->get());
            return Inertia::render('Home', [
                'latest' => PModel::orderBy('sort', 'asc')->where('name', 'MASTER MEN')->get(),
            ]);
//            return Inertia::render('Home', [
//                'latest' => PModel::orderBy('sort', 'asc')->take(12)->get(),
//            ]);
        }
        
    }