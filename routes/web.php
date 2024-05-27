<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {

    $products = Product::orderBy('created_at', 'desc')->get();
    
    return view('welcome', compact('products'));
});

Route::post('/products', [ProductController::class, 'store'])->name('product.store');

Route::put('/products/{product}', [ProductController::class, 'update'])->name('product.update');