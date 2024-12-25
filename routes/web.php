<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------|
| Web Routes                                                               |
|--------------------------------------------------------------------------|
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::resource('suppliers', App\Http\Controllers\SuppliersController::class);
Route::resource('order_details', App\Http\Controllers\OrderDetailsController::class);
Route::resource('orders', App\Http\Controllers\OrderController::class);
Route::resource('users', App\Http\Controllers\UserController::class);
Route::resource('companies', App\Http\Controllers\CompaniesController::class);
Route::resource('transactions', App\Http\Controllers\TransactionsController::class);
Route::get('barcode', [App\Http\Controllers\ProductsController::class, 'GetProductBarcodes'])->name('products.barcode');
Route::resource('product', App\Http\Controllers\ProductsController::class);
Route::resource('sections', App\Http\Controllers\SectionController::class);
Route::resource('section_twos', App\Http\Controllers\SectionTwoController::class);
Route::get('/test-barcode', function () {
    try {
        $generator = new \Picqer\Barcode\BarcodeGeneratorJPG();
        $barcodeDirectory = public_path('products/barcodes/');

        // Ensure directory exists
        if (!file_exists($barcodeDirectory)) {
            mkdir($barcodeDirectory, 0775, true);
        }

        $product_code = $request->product_code; // Example product code
        $barcodePath = $barcodeDirectory . $product_code . '.jpg';
        $barcodeContent = $generator->getBarcode($product_code, $generator::TYPE_CODE_128, 3, 50);

        if (file_put_contents($barcodePath, $barcodeContent) === false) {
            throw new \Exception("Failed to save the barcode image.");
        }

        return response()->json([
            'success' => true,
            'message' => 'Barcode created successfully!',
            'path' => $barcodePath
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ]);
    }
});


