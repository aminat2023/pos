<?php

namespace App\Http\Controllers;

use App\Models\Order_Details;
use Illuminate\Http\Request;

class OrderDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
     
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderDetails  $order_Details
     * @return \Illuminate\Http\Response
     */
    public function show(OrderDetails $order_Details)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrderDetails  $order_Details
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderDetails $order_Details)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrderDetails  $order_Details
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderDetails $order_Details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderDetails  $order_Details
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order_Details $order_Details)
    {
        //
    }
  
}
