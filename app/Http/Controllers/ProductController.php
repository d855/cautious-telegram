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
    use Inertia\Inertia;
    
    class ProductController extends Controller
    {
        
        public function index(){
        
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
                
                return [
                    'pid' => $category->pid,
                    'name' => json_encode($category->getTranslations('name')),
                    'slug' => json_encode($category->getTranslations('slug')),
                    'parent' => $category->parent,
                    'count' => Pmodel::where('groupWeb1', $category->pid)->count(),
                    'subcats' => $subs->map(function ($sub) {
                        $sub2 = Group::where('parent', $sub->pid)->get();
                        
                        return [
                            'pid' => $sub->pid,
                            'name' => json_encode($sub->getTranslations('name')),
                            'slug' => json_encode($sub->getTranslations('slug')),
                            'count' => Pmodel::where('groupWeb2', $sub->pid)->count(),
                            'subcats' => $sub2->map(function ($sub) {
                                return [
                                    'pid' => $sub->pid,
                                    'name' => json_encode($sub->getTranslations('name')),
                                    'slug' => json_encode($sub->getTranslations('slug')),
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
            $cat3 =request()->query('category3');
           $cat=null;$product=null;
            if( request()->query('category3')!=''){
                $cat = Group::whereRaw("JSON_EXTRACT(slug, '$.sr') = '". request()->query('category3')."'")->get();
                $product = Product::where('group3',$cat[0]->pid)->select('model_id')->distinct()->get();
            }
            elseif (request()->query('category2')){
                $cat = Group::whereRaw("JSON_EXTRACT(slug, '$.sr') = '". request()->query('category2')."'")->get();
                $product = Product::where('group2',$cat[0]->pid)->select('model_id')->distinct()->get();
                
            }
            elseif (request()->query('category1')){
                $cat = Group::whereRaw("JSON_EXTRACT(slug, '$.sr') = '". request()->query('category1')."'")->get();
                $product = Product::where('group1',$cat[0]->pid)->select('model_id')->distinct()->get();
                
            }
            $models=Pmodel::orderBy('name', 'asc')->paginate(20);
           if($product){
              $models =  Pmodel::whereIn('id',$product)->paginate(20);
           }
            
            return Inertia::render('Product/Index', [
                'products' =>  $models,
                'prood'=> $models,
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