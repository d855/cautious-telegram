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
        Color::truncate();
        $locales = ['sr', 'en', 'de', 'sq', 'hr', 'sl', 'mk'];
        
        $translations = [];
        foreach ($locales as $lang) {
            $data = getData($lang, 'color');
            foreach ($data as $key => $color) {
                $translations[$key][$lang] = $color['Name'];
            }
        }
        
        try {
            $data = getData($locales[0], 'color');
            foreach ($data as $key => $color) {
                $color = Color::create([
                    'pid' => $color['Id'],
                    'html' => $color['HtmlColor'],
                    'image' => $color['Image'],
                    'name' => $translations[$key]
                ]);
            }
        } catch (Exception $e) {
            echo 'error colors '.$e;
            insertColors();
        }
        //  dg2_upisulog('colors');
    }
    
    function insertStickers()
    {
        Sticker::truncate();
        
        $locales = ['sr', 'en', 'de', 'sq', 'hr', 'sl', 'mk'];
        
        $data = null;
        $translations = [];
        $translations2 = [];
        
        foreach ($locales as $lang) {
            $data = getData($lang, 'sticker');
            foreach ($data as $key => $item) {
                $translations[$item['Id']][$lang] = $item['Name'];
                $translations2[$item['Id']][$lang] = $item['Type'];
            }
        }
        try {
            foreach ($data as $key => $item) {
                Sticker::create([
                    'id' => $item['Id'],
                    'image' => $item['Image'],
                    'name' => $translations[$item['Id']],
                    'type' => $translations2[$item['Id']]
                ]);
            }
        } catch (Exception $e) {
            echo 'error stickers';
            insertStickers();
        }
    }
    
    function insertGroups()
    {
        Group::truncate();
        $locales = ['sr', 'en', 'de', 'sq', 'hr', 'sl', 'mk'];
        
        $data = null;
        $translations = [];
        
        foreach ($locales as $lang) {
            $data = getData($lang, 'groups');
            foreach ($data as $key => $item) {
                $translations[$key][$lang] = $item['Name'];
            }
        }
        
        try {
            foreach ($data as $key => $item) {
                Group::create([
                    'pid' => $item['Code'],
                    'sort' => $item['Sort'],
                    'multitree' => $item['MultiTree'],
                    'parent' => $item['Parent'],
                    'name' => $translations[$key]
                ]);
            }
        } catch
        (Exception $e) {
            echo 'error groups';
            insertGroups();
        }
        // dg2_upisulog('groups');
    }
    
    function insertBrands()
    {
        $lang = 'en';
        $data = getData($lang, 'brand');
        Brand::truncate();
        
        foreach ($data as $item) {
            try {
                Brand::create([
                    'pid' => $item['Id'],
                    'image' => $item['Image']
                ]);
            } catch (Exception $e) {
                echo 'error brands';
                insertBrands();
            }
        }
    }
    
    function insertShades()
    {
        Shade::truncate();
        
        $locales = ['sr', 'en', 'de', 'sq', 'hr', 'sl', 'mk'];
        $data = null;
        $translations = [];
        
        foreach ($locales as $lang) {
            $data = getData($lang, 'shade');
            foreach ($data as $key => $item) {
                $translations[$key][$lang] = $item['Name'];
            }
        }
        try {
            foreach ($data as $key => $item) {
                Shade::create([
                    'id' => $item['Id'],
                    'html' => $item['HtmlColor'],
                    'image' => $item['Image'],
                    'name' => $translations[$key]
                ]);
            }
        } catch (Exception $e) {
            echo 'error shades';
            insertShades();
        }
    }
    
    function insertStatus()
    {
        Status::truncate();
        $locales = ['sr', 'en', 'de', 'sq', 'hr', 'sl', 'mk'];
        $translations = [];
        $data = null;
        
        foreach ($locales as $lang) {
            $data = getData($lang, 'status');
            foreach ($data as $key => $color) {
                $translations[$key][$lang] = $color['Name'];
            }
        }
        
        try {
            foreach ($data as $key => $item) {
                Status::create([
                    'id' => $item['Id'],
                    'image' => $item['Image'],
                    'name' => $translations[$key]
                ]);
            }
        } catch (Exception $e) {
            echo 'error status';
            insertStatus();
        }
    }
    
    function insertSize()
    {
        $lang = 'en';
        $data = getData($lang, 'size');
        
        Size::truncate();
        try {
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
        } catch (Exception $e) {
            echo 'error size';
            insertSize();
        }
        // dg2_upisulog('size');
    }
    
    function insertModels()
    {
        Pmodel::truncate();
        $locales = ['sr', 'en', 'de', 'sq', 'hr', 'sl', 'mk'];
        
        $data = null;
        $translations = [];
        
        foreach ($locales as $lang) {
            $data = getData($lang, 'model');
            foreach ($data as $key => $item) {
                $translations[$item['Name']][$lang] = $item['Description'];
            }
        }
        
        try {
            foreach ($data as $key => $item) {
                
                $model = Pmodel::create([
                    'id' => $item['Id'],
                    'name' => $item['Name'],
                    'image' => $item['Image'],
                    'imageWebP' => $item['ImageWebP'],
                    'imageGif' => $item['ImageGif'],
                    'imageHover' => $item['ImageHover'],
                    'groupWeb1' => $item['GroupWeb1'],
                    'groupWeb2' => $item['GroupWeb2'],
                    'groupWeb3' => $item['GroupWeb3'],
                    'sort' => $item['Sort'],
                    'description' => $translations[$item['Name']]
                ]);
                //                    $model->description = [$lang => $item['Description']];
                //                    $model->save();
            }
        } catch (Exception $e) {
            echo 'error model '.$e;
            insertModels();
        }
    }
    
    function insertProducts()
    {
        $lang = 'sr';
        $data = getData($lang, 'product');
        
        Product::truncate();
        try {
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
        } catch (Exception $e) {
            echo 'error product';
            insertProducts();
        }
        $models = Pmodel::all();
        foreach ($models as $model) {
            $model->minPrice = minPrice($model->name);
            $model->save();
        }
        //        dg2_upisulog('products');
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
        try {
            foreach ($data as $item) {
                DB::insert('insert into images (product_id, image_number,image,imageWebp,imageGif) values (?, ?,?,?,?)',
                    [
                        $item['ProductId'],
                        $item['No'],
                        $item['Image'],
                        $item['ImageWebP'],
                        $item['ImageGif'],
                    ]);
            }
        } catch (Exception $e) {
            echo 'error productimage';
            insertImages();
        }
        //        dg2_upisulog('images');
    }
    
    function insertMedia()
    {
        $lang = 'sr';
        $data = getData($lang, 'productmedia');
        
        Media::truncate();
        try {
            foreach ($data as $item) {
                Media::create([
                    'product_id' => $item['ProductId'],
                    'media' => $item['MediaUrl'],
                ]);
            }
        } catch (Exception $e) {
            echo 'error productmedia';
            insertMedia();
        }
        //        dg2_upisulog('media');
    }
    
    function insertProductStock()
    {
        $lang = 'sr';
        $data = getData($lang, 'productstock');
        
        ProductStock::truncate();
        try {
            foreach ($data as $item) {
                DB::insert('insert into product_stocks (product_id,warehouse, quantity) values (?, ?, ?)', [
                    $item['ProductId'],
                    $item['Warehouse'],
                    $item['Qty']
                ]);
                
            }
        } catch (Exception $e) {
            echo 'error productstock';
            insertProductStock();
        }
        //        dg2_upisulog('productstock');
    }
    
    function insertProductArrival()
    {
        ProductArrival::truncate();
        $locales = ['sr', 'en', 'de', 'sq', 'hr', 'sl', 'mk'];
        $data = null;
        $translations = [];
        
        foreach ($locales as $lang) {
            $data = getData($lang, 'productarrival');
            foreach ($data as $key => $item) {
                $translations[$key][$lang] = $item['Value'];
            }
        }
        
        try {
            foreach ($data as $key => $item) {
                $arrival = ProductArrival::create([
                    'product_id' => $item['ProductId'],
                    'date' => $item['Arrival'],
                    'quantity' => $item['Qty'],
                    'value' => $translations[$key]
                ]);
                
            }
        } catch (Exception $e) {
            echo 'error productarrival';
            insertProductArrival();
        }
        //        dg2_upisulog('productarrival');
    }
    
    function insertProductSticker()
    {
        $data = getData('en', 'productsticker');
        
        ProductSticker::truncate();
        try {
            foreach ($data as $item) {
                DB::insert('insert into product_stickers (product_id, sticker_id) values (?, ?)',
                    [$item['ProductId'], $item['StickerId']]);
            }
        } catch (Exception $e) {
            echo 'error productsticker';
            insertProductSticker();
        }
    }
    
    function insertProductStatus()
    {
        $data = getData('en', 'productstatus');
        
        ProductStatus::truncate();
        try {
            foreach ($data as $item) {
                ProductStatus::create([
                    'product_id' => $item['ProductId'],
                    'status_id' => $item['StatusId']
                ]);
            }
        } catch (Exception $e) {
            echo 'error productstatus';
            insertProductStatus();
        }
        //        dg2_upisulog('productstatus');
    }