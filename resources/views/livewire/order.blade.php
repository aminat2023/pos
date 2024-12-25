<div class="col-lg-12">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"style="background:#008B8B; color:#ffff;" >
                    <h4 style="float:left"> PAYMENT</h4>
                    <a href="#" style="float:right" class="btn btn-dark" data-toggle="modal" data-target="#addproduct">
                        <i class="fa fa-plus"></i> Add new product
                    </a>
                </div>
              
                {{-- <form wire:submit.prevent="storeOrder"> --}}
                    <div class="card-body">
                        {{-- {{$productIncart}} --}}
                        <form wire:submit.prevent="InsertToCart">  <!-- Change this line -->
                            <div class="my-2">
                                <input type="text" wire:model="product_code" class="form-control" placeholder="Enter Product Code">
                                @if($message)
                                    <div class="alert alert-info mt-2">{{ $message }}</div>
                                @endif
                            </div>
                       
                        </form>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Discount(%)</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orderItems as $index => $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <input type="text" value="{{ optional(\App\Models\Products::find($item['product_id']))->product_name ?? 'Select a product' }}" name="product_name" class="form-control" readonly>
                                    </td>
                                    <td width="15%">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <button class="btn btn-sm btn-success" wire:click.prevent="IncreamentQty({{ $index }})">+</button> <!-- Pass $index -->
                                            </div>
                                            <div class="col-md-1">
                                                <label for="">{{ $orderItems[$index]['quantity'] ?? 0 }}</label>
                                            </div>
                                            <div class="col-md-2">
                                                <button class="btn btn-sm btn-danger" wire:click.prevent="DecrementQty({{ $index }})">-</button> <!-- Pass $index -->
                                            </div>
                                        </div>
                                    </td>
                                    
        
                                    <td>
                                        <input type="number" name="price[]" wire:model.lazy="orderItems.{{ $index }}.price" class="form-control" />
                                    </td>
                                    <td>
                                        <input type="number" name="discount[]" wire:model.lazy="orderItems.{{ $index }}.discount" class="form-control" />
                                    </td>
                                    <td>
                                        <input type="number" name="total_amount" value="{{ $item['total_amount'] }}" class="form-control" readonly />
                                    </td>
                                     <td>
                                        <button type="button" class="btn btn-sm btn-danger" wire:click="removeRow({{ $index }})">
                                            <i class="fa fa-times-circle"></i>
                                        </button>
                                    </td> 
                                </tr>
                                @endforeach
                            </tbody>
                            
                        </table>
                    </div>
                {{-- </form> --}}
                
            </div>
        </div>
       


        <div class="col-md-4">
            <div class="card">
                <div class="card-header" style="background:#008B8B; color:#ffff;">
                    <h1>Total <b class="total">{{ collect($orderItems)->sum('total_amount') }}</b></h1>
                </div>
                <form action="{{ route('orders.store') }}" method="POST">
                    @csrf
                    @foreach($orderItems as $index => $item)
                        <div class="row mb-3">
                            <input type="hidden" value="{{ optional(\App\Models\Products::find($item['product_id']))->id }}" name="product_id[]"> 
                            <input type="hidden" value="{{ $item['quantity'] }}" name="quantity[]">
                            <input type="hidden" value="{{ $item['price'] }}" name="price[]">
                        </div>
                    @endforeach
                
                    <div class="card-body" style="text-align: center;">
                        <div class="btn-group mb-3" style="display: inline-block;">
                            <button type="button" onclick="PrintReciptContent('print')" class="btn btn-dark">
                                <i class="fa fa-print"></i> Print
                            </button>
                            <button type="button" class="btn btn-primary">
                                <i class="fa fa-history"></i> History
                            </button>
                            <button type="button" class="btn btn-danger">
                                <i class="fa fa-chart-line"></i> Report
                            </button>
                        </div>
                
                        <!-- Customer Information -->
                        <div class="panel" style="display: inline-block; text-align: left;">
                            <table class="table" style="display: inline-block;">
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label for="customer_name">Customer Name</label>
                                            <input type="text" name="customer_name" class="form-control" required>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <label for="customer_phone">Customer Phone</label>
                                            <input type="number" name="customer_phone" class="form-control" required>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                
                            <!-- Payment Section -->
                            <div class="payment-section" style="display: inline-block; text-align: left;">
                                <h5>Payment</h5>
                                <div class="radio-item">
                                    <input type="radio" id="payment_method_cash" name="payment_method" value="cash" checked>
                                    <label for="payment_method_cash"><i class="fa fa-money-bill text-success"></i> Cash</label>
                                </div>
                                <div class="radio-item">
                                    <input type="radio" id="payment_method_bank" name="payment_method" value="bank_transfer">
                                    <label for="payment_method_bank"><i class="fa fa-university text-danger"></i> Bank Transfer</label>
                                </div>
                                <div class="radio-item">
                                    <input type="radio" id="payment_method_card" name="payment_method" value="credit_card">
                                    <label for="payment_method_card"><i class="fa fa-credit-card text-success"></i> Credit Card</label>
                                </div>
                            </div>
                
                            <div class="payment-field" style="display: inline-block; width: 100%;">
                                <label for="paid_amount">Payment</label>
                                <input type="number" name="paid_amount" wire:model="pay_money" id="paid_amount" class="form-control">
                            </div>
                            <label for="balance">Returning Change</label>
                            <input type="number" wire:model="balance" readonly name="balance" id="balance" class="form-control">
                        </div>
                    </div>
                
                    <!-- Action Buttons -->
                    <div style="display: inline-block; width: 100%;">
                        <button type="submit" class="btn btn-primary btn-lg btn-block mb-2">Save</button>
                        <!-- Calculate button should be of type 'button' if not meant to submit -->
                        <button type="button" class="btn btn-danger btn-lg btn-block">Calculate</button>
                    </div>
                
                    <div class="text-center mt-3" style="display: inline-block; width: 100%;">
                        <a href="#" class="text-danger"><i class="fa fa-sign-out-alt"></i></a>
                    </div>
                </form>
                
                </div>
            </div>
        </div>
        
    </div>
</div>

