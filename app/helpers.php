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
        $url = "http://apiv1.promosolution.services/{$lang}/api/{$model}";
        $token = getDBToken() ?? getToken();

        $response = Http::withToken($token['value'])->timeout(300)->acceptJson()->get($url);
        if ($response->failed()) {
            $token = getToken();
            $response = Http::withToken($token['value'])->timeout(300)->acceptJson()->get($url);
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
            'username' => 'penda',
            'password' => 'PND011!bgd'
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
                $newColor = Color::firstOrCreate([
                    'pid' => $color['Id'],
                    'html' => $color['HtmlColor']
                ]);
                $newColor->image = $color['Image'];
                $newColor->name = [$lang => $color['Name']];
                $newColor->save();
            }
        }

    }

    function insertStickers()
    {
        $locales = ['sr', 'en', 'de', 'sq', 'hr', 'sl', 'mk'];

        foreach ($locales as $lang) {
            $data = getData($lang, 'sticker');
            foreach ($data as $item) {
                $newItem = Sticker::firstOrCreate([
                    'id' => $item['Id'],
                    'image' => $item['Image'],
                ]);
                $newItem->name = [$lang => $item['Name']];
                $newItem->type = [$lang => $item['Type']];
                $newItem->save();
            }
        }
    }

    function insertGroups()
    {
        $locales = ['sr', 'en', 'de', 'sq', 'hr', 'sl', 'mk'];

        foreach ($locales as $lang) {
            $data = getData($lang, 'groups');
            foreach ($data as $item) {
                $newItem = Group::firstOrCreate([
                    'pid' => $item['Code'],
                ]);
                $newItem->sort = $item['Sort'];
                $newItem->multitree = $item['MultiTree'];
                $newItem->parent = $item['Parent'];
                $newItem->name = [$lang => $item['Name']];
                $newItem->save();
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
                $newItem = Shade::firstOrCreate([
                    'id' => $item['Id'],
                    'html' => $item['HtmlColor']
                ]);
                $newItem->image = $item['Image'];
                $newItem->name = [$lang => $item['Name']];
                $newItem->save();
            }
        }
    }

    function insertStatus()
    {
        $locales = ['sr', 'en', 'de', 'sq', 'hr', 'sl', 'mk'];

        foreach ($locales as $lang) {
            $data = getData($lang, 'status');
            foreach ($data as $item) {
                $newItem = Status::firstOrCreate([
                    'id' => $item['Id'],
                    'image' => $item['Image'],
                ]);
                $newItem->name = [$lang => $item['Name']];
                $newItem->save();
            }
        }
    }

    function insertSize()
    {
        $lang = 'en';
        $data = getData($lang, 'size');
        foreach ($data as $item) {
            $newItem = Size::firstOrCreate([
                'pid' => $item['Id'],
                'size_oid' => $item['SizeOID'],
                'kid' => $item['KidsSize'],
                'image' => $item['Image'],
                'category' => $item['Category'],
            ]);
            $newItem->sort = $item['Sort'];
            $newItem->save();
        }
    }

    function insertModels()
    {
        $locales = ['sr', 'en', 'de', 'sq', 'hr', 'sl', 'mk'];

        foreach ($locales as $lang) {
            $data = getData($lang, 'model');
            foreach ($data as $item) {
                $newItem = Pmodel::firstOrCreate([
                    'id' => $item['Id'],
                    'name' => $item['Name'],
                ]);
                $newItem->description = [$lang => $item['Description']];
                $newItem->image = $item['Image'];
                $newItem->imageWebP = $item['ImageWebP'];
                $newItem->imageGif = $item['ImageGif'];
                $newItem->imageHover = $item['ImageHover'];
                $newItem->groupWeb1 = $item['GroupWeb1'];
                $newItem->groupWeb2 = $item['GroupWeb2'];
                $newItem->groupWeb3 = $item['GroupWeb3'];
                $newItem->sort = $item['Sort'];
                $newItem->save();
            }
        }
    }

    function insertProducts()
    {
        $lang = 'sr';
        $data = getData($lang, 'product');
        foreach ($data as $item) {
            $newItem = Product::firstOrCreate([
                'pid' => $item['Id'],
                'id_view' => $item['ProductIdView'],
                'model_id' => substr($item['Id'], 0, 5),
                'model_name' => $item['Model'],
                'brand_id' => $item['Brand'],
            ]);

            $newItem->color_id = $item['Color'];
            $newItem->shade_id = $item['Shade'];
            $newItem->size_id = $item['Size'];
            $newItem->price = $item['Price'];
            $newItem->pricePromobox = $item['Price2'];
            $newItem->name = $item['Name'];
            $newItem->save();
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
            $newItem = Image::firstOrCreate([
                'product_id' => $item['ProductId'],
                'image_number' => $item['No'],
                'pid_inb' => $item['ProductId'].'_'.$item['No'],
            ]);

            $newItem->image = $item['Image'];
            $newItem->imageWebp = $item['ImageWebP'];
            $newItem->imageGif = $item['ImageGif'];
            $newItem->save();
        }
    }

    function insertMedia()
    {
        $lang = 'sr';
        $data = getData($lang, 'productmedia');
        foreach ($data as $item) {
            $newItem = Media::firstOrCreate([
                'product_id' => $item['ProductId'],
                'media' => $item['MediaUrl'],
            ]);
            //            $newItem->save();
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
                //                'date' => $item['']
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
                $newItem = ProductArrival::firstOrCreate([
                    'product_id' => $item['ProductId'],
                    'date' => $item['Arrival'],
                    'quantity' => $item['Qty'],
                ]);
                $newItem->value = [$lang => $item['Value']];
                $newItem->save();
            }
        }
    }

    function insertProductSticker()
    {
        $data = getData('en', 'productsticker');
        foreach ($data as $item) {
            ProductSticker::firstOrCreate([
                'product_id' => $item['ProductId'],
                'sticker_id' => $item['StickerId']
            ]);
            //                $product = Product::where('pid', $item['ProductId'])->firstOrFail()->stickers()->attach($item['StickerId']);
            //                dd($product, $item['ProductId']);
            //->stickers()->attach($item['StickerId']);
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