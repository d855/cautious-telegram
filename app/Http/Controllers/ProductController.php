<?php
    
    namespace App\Http\Controllers;
    
    use App\Models\Brand;
    use App\Models\Color;
    use App\Models\Group;
    use App\Models\Pmodel;
    use App\Models\Product;
    use App\Models\ProductArrival;
    use App\Models\Size;
    use App\Models\Status;
    use App\Models\Sticker;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    use Inertia\Inertia;
    
    class ProductController extends Controller
    {
        
        public function index()
        {
            
            $groups = Group::where('parent', '')->get();
            
            //            $mainGroups = Pmodel::select('groupWeb1')->where('pmodels.name', 'like',
            //                '%AC%')->distinct()->pluck('groupWeb1');
            
            //            $mainStickers = DB::table('products as p')
            //                              ->leftJoin('product_stickers as ps', 'p.pid', '=', 'ps.product_id')
            //                              ->where('ps.sticker_id', '=', 185)
            //                              ->select('model_id')
            //                              ->get()->pluck('model_id');
            
            //            $mStickers = DB::table('products as p')
            //                           ->leftJoin('product_stickers as ps', 'p.pid', '=', 'ps.product_id')
            //                           ->whereIn('model_id', $mainStickers)
            //                           ->select('sticker_id')
            //                           ->get()->pluck('sticker_id');
            //            print_r($mStickers);
            // $groups = Group::whereIn('pid', $mainGroups)->get();
            $categories = $groups->map(function ($category) {
                $subs = Group::where('parent', $category->pid)->get();
                
                //                dd($category);
                return [
                    'pid' => $category->pid,
                    'name' => json_encode($category->getTranslations('name')),
                    'parent' => $category->parent,
                    'count' => Pmodel::where('groupWeb1', $category->pid)->count(),
                    'subcats' => $subs->map(function ($sub) {
                        $sub2 = Group::where('parent', $sub->pid)->get();
                        
                        return [
                            'pid' => $sub->pid,
                            'name' => json_encode($sub->getTranslations('name')),
                            'count' => Pmodel::where('groupWeb2', $sub->pid)->count(),
                            'subcats' => $sub2->map(function ($sub) {
                                return [
                                    'pid' => $sub->pid,
                                    'name' => json_encode($sub->getTranslations('name')),
                                    'count' => Pmodel::where('groupWeb3', $sub->pid)->count(),
                                ];
                            })
                        ];
                    })
                ];
            });
            $types = Sticker::select('type')->distinct()->get();
            //    $types = Sticker::select('type')->whereIn('id',$mStickers)->distinct()->get();
            
            $stickers = $types->map(function ($type) {
                $sticker = Sticker::where('type', json_encode($type->getTranslations('type')))->orderBy('id')->get();
                
                //        $sticker = Sticker::where('type', json_encode($type->getTranslations('type')))->whereIn('id', $mStickers)->orderBy('id')->get();
                
                return [
                    'type' => json_encode($type->getTranslations('type')),
                    'stickers' => $sticker->map(function ($s) {
                        return [
                            'name' => json_encode($s->getTranslations('name')),
                            'count' => DB::table('products as p')
                                         ->leftJoin('product_stickers as ps', 'p.pid', '=', 'ps.product_id')
                                         ->where('ps.sticker_id', '=', $s->id)
                                         ->select(DB::raw("COUNT(DISTINCT p.model_id) as broj"))
                                         ->get()
                        ];
                    }),
                ];
            });
            
            return Inertia::render('Product/Index', [
                'products' => Pmodel::orderBy('name', 'asc')->paginate(20),
                'product1s' => Product::orderBy('name', 'asc')->paginate(20),
                'categories' => $categories,
                'stickers' => $stickers,
                'colors' => Color::all(),
                'brands' => Brand::all(),
                'sizes' => Size::all(),
                'statuses' => Status::all(),
                'types' => $types
            ]);
        }
        
        public function arrival($product)
        {
            return ProductArrival::select('date', 'quantity', 'product_id')->where('product_id', 'LIKE',
                $product.'%')->get();
        }
        
    }