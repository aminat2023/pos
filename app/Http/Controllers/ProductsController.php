<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Picqer\Barcode\BarcodeGeneratorJPG;
use Illuminate\Support\Facades\Log;

class ProductsController extends Controller
{
    public function index() {
        $products = Products::paginate(10); // or however many you want to paginate
        return view('products.index', compact('products'));
    }
    

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'brand'        => 'required|string|max:255',
            'alert_stock'  => 'required|integer|min:0',
            'description'  => 'required|string',
            'price'        => 'required|numeric|min:0',
            'quantity'     => 'required|integer|min:0',
        ]);

        $product_code = $request->product_code;

        $product = new Products();

        if ($request->hasFile('product_image')) {
        $file = $request->file('product_image'); // Get the uploaded file
        $product_image = $file->getClientOriginalName(); // Get the original file name
        $file->move(public_path('products/images'), $product_image); // Move the file to the desired location
        $product->product_image = $product_image; // Save the file name in the database
}


        try {
            $generator = new \Picqer\Barcode\BarcodeGeneratorJPG();
            $barcodeDirectory = public_path('products/barcodes/');

            if (!file_exists($barcodeDirectory)) {
                if (!mkdir($barcodeDirectory, 0755, true) && !is_dir($barcodeDirectory)) {
                    throw new \Exception("Failed to create barcode directory.");
                }
            }

            $barcodePath = $barcodeDirectory . $product_code . '.jpg';
            $barcodeContent = $generator->getBarcode($product_code, $generator::TYPE_CODE_128, 3, 50);

            if (file_put_contents($barcodePath, $barcodeContent) === false) {
                throw new \Exception("Failed to save the barcode image.");
            }

            if (!file_exists($barcodePath)) {
                throw new \Exception("Barcode image file not found after saving.");
            }
        } catch (\Exception $e) {
            \Log::error('Barcode generation error: ' . $e->getMessage());
            return redirect()->route('product.index')->with('error', 'Failed to generate barcode.');
        }

       
        $product->product_name = $request->product_name;
        $product->description = $request->description;
        $product->brand = $request->brand;
        $product->price = $request->price;
        $product->product_code = $product_code;
        $product->barcode = $product_code . '.jpg';
        $product->alert_stock = $request->alert_stock;
        $product->quantity = $request->quantity;
        $product->save();

        return redirect()->route('product.index')->with('success', 'Product created successfully');
    }

    public function show($id)
    {
        $product = Products::findOrFail($id);
        return view('products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Products::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'product_name'  => 'required|string|max:255',
            'brand'         => 'required|string|max:255',
            'alert_stock'   => 'required|integer|min:0',
            'description'   => 'required|string',
            'price'         => 'required|numeric|min:0',
            'quantity'      => 'required|integer|min:0',
            'product_code'  => 'required|string|max:255', // Ensure product_code is provided
        ]);
    
        // Find the product by ID
        $product = Products::findOrFail($id);
        $product_code = $request->product_code;
    
        // Handle product image upload
        if ($request->hasFile('product_image')) {
            // Define the directory path for product images
            $imageDirectory = public_path('products/images/');
    
            // Check if the product already has an image and it exists on the server
            if ($product->product_image && file_exists($imageDirectory . $product->product_image)) {
                // Delete the old image file
                unlink($imageDirectory . $product->product_image);
            }
    
            // Handle the new image upload
            $file = $request->file('product_image');
            $product_image = time() . '_' . $file->getClientOriginalName(); // Create a unique file name
            $file->move($imageDirectory, $product_image); // Save the file to the images directory
            $product->product_image = $product_image; // Save the new image name to the database
        }
    
        // Check if the product code has changed
        if ($product_code !== $product->product_code) {
            $unique = Products::where('product_code', $product_code)->first();
            if ($unique) { // Corrected this line
                return redirect()->route('product.index')->with('error', 'Product Code is already taken');
            }
    
            try {
                $generator = new \Picqer\Barcode\BarcodeGeneratorJPG();
                $barcodeDirectory = public_path('products/barcodes/');
    
                // Create the barcode directory if it doesn't exist
                if (!file_exists($barcodeDirectory)) {
                    if (!mkdir($barcodeDirectory, 0755, true) && !is_dir($barcodeDirectory)) {
                        throw new \Exception("Failed to create barcode directory.");
                    }
                }
    
                // Generate the new barcode
                $barcodePath = $barcodeDirectory . $product_code . '.jpg';
                $barcodeContent = $generator->getBarcode($product_code, $generator::TYPE_CODE_128, 3, 50);
    
                if (file_put_contents($barcodePath, $barcodeContent) === false) {
                    throw new \Exception("Failed to save the barcode image.");
                }
    
                // Delete the old barcode if it exists
                $oldBarcodePath = $barcodeDirectory . $product->product_code . '.jpg';
                if (file_exists($oldBarcodePath)) {
                    unlink($oldBarcodePath);
                }
    
                // Update the product's barcode and code
                $product->barcode = $product_code . '.jpg';
                $product->product_code = $product_code;
            } catch (\Exception $e) {
                \Log::error('Barcode generation error: ' . $e->getMessage());
                return redirect()->route('product.index')->with('error', 'Failed to generate barcode.');
            }
        }
    
        // Update product details
        $product->product_name = $request->product_name;
        $product->description = $request->description;
        $product->brand = $request->brand;
        $product->price = $request->price;
        $product->alert_stock = $request->alert_stock;
        $product->quantity = $request->quantity;
    
        // Save the updated product
        $product->save();
    
        return redirect()->route('product.index')->with('success', 'Product updated successfully');
    }
    

    public function destroy($id)
    {
        $product = Products::findOrFail($id);
        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product deleted successfully');
    }

    public function GetProductBarcodes()
    {
        $products = Products::all();
        return view('products.barcode.index', ['products' => $products]);
    }
}
