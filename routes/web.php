<?php

    use App\Http\Controllers\PagesController;
    use App\Http\Controllers\PmodelController;
    use App\Http\Controllers\ProductController;
    use App\Http\Controllers\ProfileController;
    use Illuminate\Foundation\Application;
    use Illuminate\Support\Facades\Artisan;
    use Illuminate\Support\Facades\Route;
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

        $start_time = microtime(true);
        insertColors();
        insertStickers();
        insertGroups();
        insertBrands();
        insertShades();
        insertStatus();
        insertSize();
        insertModels();
        insertProducts();
        insertImages();
        insertMedia();
        insertProductStock();
        insertProductArrival();
        insertProductSticker();
        insertProductStatus();

        $end_time = microtime(true);
        $execution_time = ($end_time - $start_time);

        die('Gotovo za '.round($execution_time, 2).' sec');
    });

    require __DIR__.'/auth.php';