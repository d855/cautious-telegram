<?php
    
    use App\Http\Controllers\PagesController;
    use App\Http\Controllers\PmodelController;
    use App\Http\Controllers\ProductController;
    use App\Http\Controllers\ProfileController;
    use Illuminate\Foundation\Application;
    use Illuminate\Support\Facades\Artisan;
    use Illuminate\Support\Facades\Config;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Schema;
    use Inertia\Inertia;
    
    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | contains the "web" middleware group. Now create something great!
    |
    */
    
    Route::get('/', [PagesController::class, 'home']);
    
    Route::resource('products', ProductController::class);
    Route::resource('models', PmodelController::class);
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
    
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
    
    Route::get('/updatedb', function () {
        
      //  Artisan::call('migrate:fresh');
        
        $start_time = microtime(true);
        
        Config::set('database.default', 'mysqlupdate');
        DB::reconnect('mysqlupdate');
        
        Schema::disableForeignKeyConstraints();
        
//        insertColors();
//        insertStickers();
        insertGroups();
//        insertBrands();
//        insertShades();
//        insertStatus();
//        insertSize();
//        insertModels();
//        insertProducts();
//        insertImages();
//        insertMedia();
//        insertProductStock();
//        insertProductArrival();
//        insertProductSticker();
//        insertProductStatus();
        
        Config::set('database.default', 'mysql');
        DB::reconnect('mysql');
        
        Schema::enableForeignKeyConstraints();
        
        $end_time = microtime(true);
        $execution_time = ($end_time - $start_time);
        
        dg2_upisulog('Gotovo za '.round($execution_time, 2).' sec');
        die('Gotovo za '.round($execution_time, 2).' sec');
    });
    
    require __DIR__.'/auth.php';