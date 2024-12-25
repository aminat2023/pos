<div style="padding: 0 8%">
    <!-- Display Success and Error Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="col-lg-12">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="background:  #008B8B; color:white" >
                        <h4 style="float:left">Manage Products</h4>
                        <a href="#" style="float:right" class="btn btn-dark" data-toggle="modal"
                            data-target="#addproduct">
                            <i class="fa fa-plus"></i> Add New Product
                        </a>
                    </div>
                    <div class="card-body">
                     @include('products.table')
                        <!-- Add this where you want pagination -->
                        {{-- <div class="pagination" >
                            {{ $products->links() }}
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header" style="background: #008B8B; color:white" >
                        <h4> PRODUCT DETAILS</h4>
                    </div>
                    <div class="card-body">
                       @include('products.product_detail')
                    </div>
                  
                </div>
            </div>
        </div>
    </div>
</div>