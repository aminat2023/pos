<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Transactions;
use App\Models\Cart; // Correctly importing Cart model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{
    public function index()
    {
        $products = Products::all();
        $orders = Order::all();
        $lastID = Order::max('id');
        $order_receipt = OrderDetails::where('order_id', $lastID)->get();
        $total_amount = $order_receipt->sum('amount');
        
        return view('orders.index', [
            'products' => $products, 
            'orders' => $orders, 
            'order_receipt' => $order_receipt,
            'total_amount' => $total_amount,
        ]);
    }
    

    public function store(Request $request)
    {
        // Validate essential fields
        $request->validate([
            'balance' => 'required|numeric',
            'paid_amount' => 'required|numeric',
            'payment_method' => 'required|string',
            'customer_name' => 'required|string',
            'customer_phone' => 'required|string', // Ensure this field is correctly validated
            'product_id' => 'required|array',
            'product_id.*' => 'required|integer',
            'quantity' => 'required|array',
            'quantity.*' => 'required|integer|min:1',
            'price' => 'required|array',
            'price.*' => 'required|numeric',
        ]);

        
    
        DB::beginTransaction(); // Start a transaction
    
        try {
            // Step 1: Create a new order
            $order = new Order();
            $order->name = $request->customer_name;
            $order->phone = $request->customer_phone; // Include this line
            $order->save(); // Save the order
    
            $order_id = $order->id; // Get the newly created order ID
    
            // Step 2: Save the order details
            foreach ($request->product_id as $index => $product_id) {
                $quantity = $request->quantity[$index];
                $price = $request->price[$index];
                $total_amount = $price * $quantity; // Calculate total amount
    
                // Save order details
                $order_details = new OrderDetails();
                $order_details->order_id = $order_id;
                $order_details->product_id = $product_id;
                $order_details->unit_price = $price;
                $order_details->quantity = $quantity;
                $order_details->amount = $total_amount;
                $order_details->discount = $request->discount[$index] ?? 0; // Optional discount
                $order_details->save(); // Save each order detail
            }
    
            // Step 3: Save transaction details
            $transaction = new Transactions();
            $transaction->order_id = $order_id;
            $transaction->user_id = auth()->user()->id; // Assuming user authentication is in place
            $transaction->balance = $request->balance;
            $transaction->paid_amount = $request->paid_amount;
            $transaction->payment_method = $request->payment_method;
            $transaction->transaction_amount = array_sum(array_map(function ($price, $quantity) {
                return $price * $quantity;
            }, $request->price, $request->quantity)); // Calculate total transaction amount
            $transaction->transaction_date = now();
            $transaction->save(); // Save the transaction
    
            DB::commit(); // Commit transaction if everything is successful
    
            // Truncate the cart after successful transaction
            Cart::truncate(); // This clears the entire cart
    
            return redirect()->route('orders.index')->with('success', 'Order created successfully!');
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback in case of any failure
            return redirect()->back()->with('error', 'Order creation failed: ' . $e->getMessage());
        }
    }
    
    
    
    public function show(Order $order)
    {
        //
    }

    public function edit(Order $order)
    {
        //
    }

    public function update(Request $request, Order $order)
    {
        //
    }

    public function destroy(Order $order)
    {
        //
    }
}
