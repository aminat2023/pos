<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Products as ProductsModel; // Alias the model

class Products extends Component
{
    public $products_details = [];

    public function mount()
    {

    }
    public function ProductDetails($product_id)
    {
       $this->products_details = ProductsModel::where('id',$product_id)->get(); // Use the alias
    
    }
    public function render()
    {
        return view('livewire.products', ['products' =>ProductsModel::all()]);
    }
}
