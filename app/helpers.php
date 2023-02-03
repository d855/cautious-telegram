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

    function insertColors()
    {
        $locales = ['sr', 'en', 'de', 'sq', 'hr', 'sl', 'mk'];

        foreach ($locales as $lang) {
            $data = getData($lang, 'color');
            foreach ($data as $color) {
                Color::updateOrCreate([
                    'pid' => $color['Id'],
                    'html' => $color['HtmlColor']
                ], ['image' => $color['Image'], 'name' => [$lang => $color['Name']]]);
            }
        }

    }

    function insertStickers()
    {
        $locales = ['sr', 'en', 'de', 'sq', 'hr', 'sl', 'mk'];

        foreach ($locales as $lang) {
            $data = getData($lang, 'sticker');
            foreach ($data as $item) {
                Sticker::updateOrCreate([
                    'id' => $item['Id'],
                    'image' => $item['Image'],
                ], ['name' => [$lang => $item['Name']], 'type' => [$lang => $item['Type']]]);
            }
        }
    }

    function insertGroups()
    {
        $locales = ['sr', 'en', 'de', 'sq', 'hr', 'sl', 'mk'];

        foreach ($locales as $lang) {
            $data = getData($lang, 'groups');
            foreach ($data as $item) {
                Group::updateOrCreate([
                    'pid' => $item['Code'],
                ], [
                    'sort' => $item['Sort'],
                    'multitree' => $item['MultiTree'],
                    'parent' => $item['Parent'],
                    'name'
                    => [$lang => $item['Name']]
                ]);
            }
        }
    }

    function insertBrands()
    {
        $lang = 'en';
        $data = getData($lang, 'brand');
        foreach ($data as $item) {
            Brand::firstOrCreate([
                'pid' => $item['Id'],
                'image' => $item['Image']
            ]);
        }
    }

    function insertShades()
    {
        $locales = ['sr', 'en', 'de', 'sq', 'hr', 'sl', 'mk'];

        foreach ($locales as $lang) {
            $data = getData($lang, 'shade');
            foreach ($data as $item) {
                Shade::updateOrCreate([
                    'id' => $item['Id'],
                    'html' => $item['HtmlColor']
                ], ['image' => $item['Image'], 'name' => [$lang => $item['Name']]]);
            }
        }
    }

    function insertStatus()
    {
        $locales = ['sr', 'en', 'de', 'sq', 'hr', 'sl', 'mk'];

        foreach ($locales as $lang) {
            $data = getData($lang, 'status');
            foreach ($data as $item) {
                Status::updateOrCreate([
                    'id' => $item['Id'],
                    'image' => $item['Image'],
                ], ['name' => [$lang => $item['Name']]]);
            }
        }
    }

    function insertSize()
    {
        $lang = 'en';
        $data = getData($lang, 'size');
        foreach ($data as $item) {
            Size::updateOrCreate([
                'pid' => $item['Id'],
                'size_oid' => $item['SizeOID'],
                'kid' => $item['KidsSize'],
                'image' => $item['Image'],
                'category' => $item['Category'],
            ], ['sort' => $item['Sort']]);
        }
    }

    function insertModels()
    {
        $locales = ['sr', 'en', 'de', 'sq', 'hr', 'sl', 'mk'];

        foreach ($locales as $lang) {
            $data = getData($lang, 'model');
            foreach ($data as $item) {
                Pmodel::updateOrCreate([
                    'id' => $item['Id'],
                    'name' => $item['Name'],
                ], [
                    'description' => [$lang => $item['Description']],
                    'image' => $item['Image'],
                    'imageWebP' => $item['ImageWebP'],
                    'imageGif' => $item['ImageGif'],
                    'imageHover' => $item['ImageHover'],
                    'groupWeb1' => $item['GroupWeb1'],
                    'groupWeb2' => $item['GroupWeb2'],
                    'groupWeb3' => $item['GroupWeb3'],
                    'sort' => $item['Sort']
                ]);
            }
        }
    }

    function insertProducts()
    {
        $lang = 'sr';
        $data = getData($lang, 'product');

        foreach ($data as $item) {
           Product::updateOrCreate([
                'pid' => $item['Id'],
                'id_view' => $item['ProductIdView'],
                'model_id' => substr($item['Id'], 0, 5),
                'model_name' => $item['Model'],
                'brand_id' => $item['Brand'],
            ], ['color_id' => $item['Color'], 'shade_id' => $item['Shade'], 'size_id' => $item['Size'], 'price' =>
               $item['Price'], 'pricePromobox' => $item['Price2'], 'name' => $item['Name']]);
        }
        $models = Pmodel::all();
        foreach ($models as $model) {
            $model->minPrice = minPrice($model->name);
            $model->save();
        }
    }

    function minPrice($modelName)
    {
        return Product::where('model_name', $modelName)->min('price');
    }

    function insertImages()
    {
        $lang = 'sr';
        $data = getData($lang, 'productimage');
        foreach ($data as $item) {
            Image::updateOrCreate([
                'product_id' => $item['ProductId'],
                'image_number' => $item['No'],
                'pid_inb' => $item['ProductId'].'_'.$item['No'],
            ], ['image' => $item['Image'], 'imageWebp' => $item['ImageWebP'], 'imageGif' => $item['ImageGif']]);
        }
    }

    function insertMedia()
    {
        $lang = 'sr';
        $data = getData($lang, 'productmedia');
        foreach ($data as $item) {
            Media::firstOrCreate([
                'product_id' => $item['ProductId'],
                'media' => $item['MediaUrl'],
            ]);
        }
    }

    function insertProductStock()
    {
        $lang = 'sr';
        $data = getData($lang, 'productstock');
        foreach ($data as $item) {
            $newItem = ProductStock::firstOrCreate([
                'product_id' => $item['ProductId'],
                'warehouse' => $item['Warehouse'],
                'quantity' => $item['Qty']
            ]);
        }
    }

    function insertProductArrival()
    {
        $locales = ['sr', 'en', 'de', 'sq', 'hr', 'sl', 'mk'];

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
    }

    function insertProductSticker()
    {
        $data = getData('en', 'productsticker');

        foreach ($data as $item) {
            ProductSticker::updateOrCreate([
                'product_id' => $item['ProductId'],
                'sticker_id' => $item['StickerId']
            ]);
        }
    }

    function insertProductStatus()
    {
        $data = getData('en', 'productstatus');
        foreach ($data as $item) {
            ProductStatus::firstOrCreate([
                'product_id' => $item['ProductId'],
                'status_id' => $item['StatusId']
            ]);
        }
    }