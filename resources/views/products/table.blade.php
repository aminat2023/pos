<table class="table table-bordered table-left">
    <thead>
        <tr>
            <th>#</th>
            <th>Product Name</th>
            <th>Description</th>
            <th>Brand</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Alert Stock</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $key => $product)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td style="cursor: pointer" data-toogle="tooltip" data-placement="right" title="Click to view details" wire:click="ProductDetails({{ $product->id}})">{{ $product->product_name }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->brand }}</td>
                <td>{{ number_format($product->price, 2) }}</td>
                <td>{{ $product->quantity }}</td>
                <td>
                    @if ($product->alert_stock <= 50)
                        <span class="badge badge-danger">Stock < 50</span>
                            @else
                                <span class="badge badge-success">{{ $product->alert_stock }}</span>
                    @endif
                </td>
                @include('products.delete')
            </tr>
            {{-- LIVEWiRE --}}


            {{-- <div class="card-body">
                @livewire('products') <!-- Use Livewire for dynamic rendering -->
            </div> --}}

            <!-- Edit Product Modal -->
            @include('products.edit')
        @endforeach
    </tbody>
</table>
