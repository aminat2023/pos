<div class="modal fade" id="editproduct{{ $product->id }}" tabindex="-1"
    aria-labelledby="editproductLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Product</h4>
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data" autocomplete="o">
                    @csrf
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="product_name">Product Name</label>
                        <input type="text" name="product_name"
                            value="{{ $product->product_name }}"
                            class="form-control" required>
                    </div>
                    <label for="product_code">Product Code</label>
                    <input type="text" name="product_code" id="product_code"
                        value="{{ old('product_code', $product->product_code) }}"
                        required>
                    <div class="form-group">
                        <label for="brand">Brand</label>
                        <input type="text" name="brand"
                            value="{{ $product->brand }}" class="form-control"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="alert_stock">Stock Alert</label>
                        <input type="number" name="alert_stock"
                            value="{{ $product->alert_stock }}"
                            class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" cols="30" rows="2" class="form-control" required>{{ $product->description }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="product_image">Image</label>
                        <img src="{{ asset('products/images/' . $product->product_image) }}"
                            width="60" alt="Product Image">
                        <input type="file" name="product_image"
                            id="product_image" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" name="price"
                            value="{{ $product->price }}" class="form-control"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" name="quantity"
                            value="{{ $product->quantity }}" class="form-control"
                            required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit"
                            class="btn btn-primary btn-block">Update
                            Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>