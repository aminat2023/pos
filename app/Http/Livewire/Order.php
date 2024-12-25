<?php

namespace App\Http\Livewire;

use App\Models\Products;
use App\Models\Cart;
use Livewire\Component;

class Order extends Component
{
    public $orderItems = [];
    public $products;
    public $product_code;
    public $message = '';
    public $productIncart = [];
    public $addQty;
    public $pay_money;
    public $balance;

    public function mount()
    {
        // Fetch all products and cart items
        $this->products = Products::all();
        $this->productIncart = Cart::all();

        // Initialize the order items array
        foreach ($this->productIncart as $cart) {
            $this->orderItems[] = [
                'product_id' => $cart->product_id,
                'quantity' => $cart->product_qty,
                'price' => $cart->product_price,
                'discount' => $cart->discount ?? 0,
                'total_amount' => $this->calculateTotal($cart->product_qty, $cart->product_price, $cart->discount ?? 0),
            ];
        }
    }

    public function calculateTotal($quantity, $price, $discount)
    {
        $discountAmount = ($discount / 100) * $price * $quantity;
        return max(0, ($price * $quantity) - $discountAmount);
    }

    public function removeRow($index)
    {
        // Remove the row at the specified index
        unset($this->orderItems[$index]);
        // Re-index the array to avoid gaps in the keys
        $this->orderItems = array_values($this->orderItems);
    }

    public function InsertToCart()
    {
        // Ensure the user is authenticated
        if (!auth()->check()) {
            $this->message = 'You need to be logged in to add items to the cart.';
            return;
        }

        // Fetch product based on product_code
        $countProduct = Products::where('id', $this->product_code)->get();

        if ($countProduct->isEmpty()) {
            return $this->message = 'Product not Found';
        }

        $product = $countProduct->first(); // Get the first product if it exists

        // Check if the product already exists in the cart
        $countCartProduct = Cart::where('product_id', $product->id)->count();
        if ($countCartProduct > 0) {
            return $this->message = 'Product ' . $product->product_name . ' already exists in cart';
        }

        // Add to cart
        $add_to_cart = new Cart;
        $add_to_cart->product_id = $product->id;
        $add_to_cart->product_qty = 1; // Set quantity to 1; modify if needed
        $add_to_cart->product_price = $product->price;
        $add_to_cart->user_id = auth()->id(); // Get the authenticated user ID

        $add_to_cart->save();

        // Reset product_code and set success message
        $this->product_code = '';
        return $this->message = 'Product Added Successfully';
    }

    public function IncreamentQty($index)
    {
        // Increment quantity
        if (isset($this->orderItems[$index])) {
            $this->orderItems[$index]['quantity'] += 1; // Increment quantity
            $this->orderItems[$index]['total_amount'] = $this->calculateTotal($this->orderItems[$index]['quantity'], $this->orderItems[$index]['price'], $this->orderItems[$index]['discount']);
            
            // Update the cart in the database
            Cart::where('product_id', $this->orderItems[$index]['product_id'])
                ->update(['product_qty' => $this->orderItems[$index]['quantity']]);
        }
    }

    public function DecrementQty($index)
    {
        // Decrement quantity
        if (isset($this->orderItems[$index])) {
            $this->orderItems[$index]['quantity'] = max(0, $this->orderItems[$index]['quantity'] - 1); // Ensure it doesn't go below 0
            $this->orderItems[$index]['total_amount'] = $this->calculateTotal($this->orderItems[$index]['quantity'], $this->orderItems[$index]['price'], $this->orderItems[$index]['discount']);
            
            // Update the cart in the database
            Cart::where('product_id', $this->orderItems[$index]['product_id'])
                ->update(['product_qty' => $this->orderItems[$index]['quantity']]);
        }
    }

    public function saveCart()
    {
        // Iterate over orderItems and save them into the cart
        foreach ($this->orderItems as $item) {
            // Update or create the cart item
            Cart::updateOrCreate(
                ['product_id' => $item['product_id'], 'user_id' => auth()->id()],
                ['product_qty' => $item['quantity'], 'product_price' => $item['price']]
            );
        }

        session()->flash('message', 'Cart saved successfully.');
        return redirect()->route('cart.index'); // Redirect after saving
    }

    public function render()
    {
        // Ensure $this->pay_money is treated as a float or integer
        $payMoney = floatval($this->pay_money); // Cast to float

        // Calculate total prices
        $totalPrice = array_sum(array_column($this->orderItems, 'total_amount'));

        // Perform the subtraction
        $totalAmount = $payMoney - $totalPrice;

        // Update the balance
        $this->balance = $totalAmount;

        return view('livewire.order', [
            'products' => $this->products,
        ]);
    }
}