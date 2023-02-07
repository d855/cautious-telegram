<?php
    
    use App\Models\Brand;
    use App\Models\Color;
    use App\Models\Group;
    use App\Models\Image;
    use App\Models\Media;
    use App\Models\Pmodel;
    use App\Models\Product;
    use App\Models\ProductArrival;
    use App\Models\ProductStatus;
    use App\Models\ProductSticker;
    use App\Models\ProductStock;
    use App\Models\Shade;
    use App\Models\SiteSetting;
    use App\Models\Size;
    use App\Models\Status;
    use App\Models\Sticker;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Http;
    
    function getData($lang, $model)
    {
        $url = "http://apiv1.promosolution.services/$lang/api/$model";
        $token = getDBToken() ?? getToken();
        $response = Http::withToken($token['value'])->acceptJson()->get($url);
        if ($response->failed()) {
            $token = getToken();
            $response = Http::withToken($token['value'])->acceptJson()->get($url);
        }
        
        return json_decode($response, true);
    }
    
    function getDBToken()
    {
        return SiteSetting::where('name', 'token')->first();
    }
    
    function getToken()
    {
        $url = "http://apiv1.promosolution.services/token";
        $response = Http::asForm()->post($url, [
            'grant_type' => 'password',
            'username' => env("PROMOBOX_USERNAME"),
            'password' => env("PROMOBOX_PASSWORD")
        ]);
        $response = json_decode($response, true);
        
        if (! getDBToken()) {
            return SiteSetting::create([
                'name' => 'token',
                'value' => $response['access_token']
            ]);
        }
        
        $token = SiteSetting::where('name', 'token')->first();
        $token->update(['value' => $response['access_token']]);
        
        return $token;
    }
    
    function dg2_upisulog($sta)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.digital2.rs/integrations-log/api/create.php',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
    "sta":"'.$sta.'",
    "domen":"Laravel promobox",
    "username":"jejalog",
    "password":"SuperCica#pas"
  }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: text/plain'
            ),
        ));
        
        $response = curl_exec($curl);
        curl_close($curl);
    }
    
    function insertColors()
    {
        $locales = ['sr', 'en', 'de', 'sq', 'hr', 'sl', 'mk'];
        Color::truncate();
        foreach ($locales as $lang) {
            $data = getData($lang, 'color');
            foreach ($data as $color) {
                Color::updateOrCreate([
                    'pid' => $color['Id'],
                    'html' => $color['HtmlColor'],
                    'image' => $color['Image'],
                ], ['name' => [$lang => $color['Name']]]);
            }
        }
        dg2_upisulog('colors');
    }
    
    function insertStickers()
    {
        $locales = ['sr', 'en', 'de', 'sq', 'hr', 'sl', 'mk'];
        Sticker::truncate();
        foreach ($locales as $lang) {
            $data = getData($lang, 'sticker');
            foreach ($data as $item) {
                Sticker::updateOrCreate([
                    'id' => $item['Id'],
                    'image' => $item['Image'],
                ], [
                    'name' => [$lang => $item['Name']],
                    'type' => [$lang => $item['Type']]
                ]);
            }
        }
        dg2_upisulog('stickers');
    }
    
    function insertGroups()
    {
        $locales = ['sr', 'en', 'de', 'sq', 'hr', 'sl', 'mk'];
        Group::truncate();
        foreach ($locales as $lang) {
            $data = getData($lang, 'groups');
            foreach ($data as $item) {
                Group::updateOrCreate([
                    'pid' => $item['Code'],
                    'sort' => $item['Sort'],
                    'multitree' => $item['MultiTree'],
                    'parent' => $item['Parent'],
                ], ['name' => [$lang => $item['Name']]]);
            }
        }
        dg2_upisulog('groups');
    }
    
    function insertBrands()
    {
        $lang = 'en';
        $data = getData($lang, 'brand');
        Brand::truncate();
        foreach ($data as $item) {
            Brand::create([
                'pid' => $item['Id'],
                'image' => $item['Image']
            ]);
        }
        dg2_upisulog('brands');
    }
    
    function insertShades()
    {
        $locales = ['sr', 'en', 'de', 'sq', 'hr', 'sl', 'mk'];
        Shade::truncate();
        foreach ($locales as $lang) {
            $data = getData($lang, 'shade');
            foreach ($data as $item) {
                Shade::updateOrCreate([
                    'id' => $item['Id'],
                    'html' => $item['HtmlColor'],
                    'image' => $item['Image'],
                ], ['name' => [$lang => $item['Name']]]);
            }
        }
        dg2_upisulog('shades');
    }
    
    function insertStatus()
    {
        $locales = ['sr', 'en', 'de', 'sq', 'hr', 'sl', 'mk'];
        
        Status::truncate();
        foreach ($locales as $lang) {
            $data = getData($lang, 'status');
            foreach ($data as $item) {
                Status::updateOrCreate([
                    'id' => $item['Id'],
                    'image' => $item['Image'],
                ], ['name' => [$lang => $item['Name']]]);
            }
        }
        
        dg2_upisulog('status');
    }
    
    function insertSize()
    {
        $lang = 'en';
        $data = getData($lang, 'size');
        
        Size::truncate();
        foreach ($data as $item) {
            Size::create([
                'pid' => $item['Id'],
                'size_oid' => $item['SizeOID'],
                'kid' => $item['KidsSize'],
                'image' => $item['Image'],
                'category' => $item['Category'],
                'sort' => $item['Sort']
            ]);
        }
        dg2_upisulog('size');
    }
    
    function insertModels()
    {
        $locales = ['sr', 'en', 'de', 'sq', 'hr', 'sl', 'mk'];
        
        Pmodel::truncate();
        foreach ($locales as $lang) {
            $data = getData($lang, 'model');
            foreach ($data as $item) {
                Pmodel::updateOrCreate([
                    'id' => $item['Id'],
                    'name' => $item['Name'],
                    'image' => $item['Image'],
                    'imageWebP' => $item['ImageWebP'],
                    'imageGif' => $item['ImageGif'],
                    'imageHover' => $item['ImageHover'],
                    'groupWeb1' => $item['GroupWeb1'],
                    'groupWeb2' => $item['GroupWeb2'],
                    'groupWeb3' => $item['GroupWeb3'],
                    'sort' => $item['Sort']
                ], ['description' => [$lang => $item['Description']],]);
            }
        }
        dg2_upisulog('models');
    }
    
    function insertProducts()
    {
        $lang = 'sr';
        $data = getData($lang, 'product');
        
        Product::truncate();
        foreach ($data as $item) {
            Product::create([
                'pid' => $item['Id'],
                'id_view' => $item['ProductIdView'],
                'model_id' => substr($item['Id'], 0, 5),
                'model_name' => $item['Model'],
                'brand_id' => $item['Brand'],
                'color_id' => $item['Color'],
                'shade_id' => $item['Shade'],
                'size_id' => $item['Size'],
                'price' => $item['Price'],
                'pricePromobox' => $item['Price2'],
                'name' => $item['Name']
            ]);
        }
        $models = Pmodel::all();
        foreach ($models as $model) {
            $model->minPrice = minPrice($model->name);
            $model->save();
        }
        dg2_upisulog('products');
    }
    
    function minPrice($modelName)
    {
        return Product::where('model_name', $modelName)->min('price');
    }
    
    function insertImages()
    {
        $lang = 'sr';
        $data = getData($lang, 'productimage');
        
        Image::truncate();
        foreach ($data as $item) {
            //            Image::create([
            //                'product_id' => $item['ProductId'],
            //                'image_number' => $item['No'],
            //             //   'pid_inb' => $item['ProductId'].'_'.$item['No'],
            //                'image' => $item['Image'],
            //                'imageWebp' => $item['ImageWebP'],
            //                'imageGif' => $item['ImageGif']
            //            ]);
            DB::insert('insert into images (product_id, image_number,image,imageWebp,imageGif) values (?, ?,?,?,?)',
                [
                    $item['ProductId'],
                    $item['No'],
                    $item['Image'],
                    $item['ImageWebP'],
                    $item['ImageGif'],
                ]);
            
        }
        dg2_upisulog('images');
    }
    
    function insertMedia()
    {
        $lang = 'sr';
        $data = getData($lang, 'productmedia');
        
        Media::truncate();
        foreach ($data as $item) {
            Media::create([
                'product_id' => $item['ProductId'],
                'media' => $item['MediaUrl'],
            ]);
        }
        dg2_upisulog('media');
    }
    
    function insertProductStock()
    {
        $lang = 'sr';
        $data = getData($lang, 'productstock');
        
        ProductStock::truncate();
        foreach ($data as $item) {
            //            $newItem = ProductStock::create([
            //                'product_id' => $item['ProductId'],
            //                'warehouse' => $item['Warehouse'],
            //                'quantity' => $item['Qty']
            //            ]);
            DB::insert('insert into product_stocks (product_id,warehouse, quantity) values (?, ?, ?)', [
                $item['ProductId'],
                $item['Warehouse'],
                $item['Qty']
            ]);
            
        }
        dg2_upisulog('productstock');
    }
    
    function insertProductArrival()
    {
        $locales = ['sr', 'en', 'de', 'sq', 'hr', 'sl', 'mk'];
        
        ProductArrival::truncate();
        foreach ($locales as $lang) {
            $data = getData($lang, 'productarrival');
            foreach ($data as $item) {
                ProductArrival::updateOrCreate([
                    'product_id' => $item['ProductId'],
                    'date' => $item['Arrival'],
                    'quantity' => $item['Qty'],
                ], ['value' => [$lang => $item['Value']]]);
            }
        }
        dg2_upisulog('productarrival');
    }
    
    function insertProductSticker()
    {
        $data = getData('en', 'productsticker');
        
        ProductSticker::truncate();
        foreach ($data as $item) {
            //            DB::table('product_stickers')->insert([
            //                'product_id' => $item['ProductId'],
            //                'sticker_id' => $item['StickerId']
            //            ]);
            DB::insert('insert into product_stickers (product_id, sticker_id) values (?, ?)',
                [$item['ProductId'], $item['StickerId']]);
            //            ProductSticker::create();
        }
        
        dg2_upisulog('productsticker');
    }
    
    function insertProductStatus()
    {
        $data = getData('en', 'productstatus');
        
        ProductStatus::truncate();
        foreach ($data as $item) {
            ProductStatus::create([
                'product_id' => $item['ProductId'],
                'status_id' => $item['StatusId']
            ]);
        }
        
        dg2_upisulog('productstatus');
    }