<!-- Buttons -->
<a href="#" data-toggle="modal" data-target="#staticBackdrop" class="btn btn-outline rounded-pill"><i class="fa fa-list"></i></a>
<a href="{{route('users.index')}}" class="btn btn-outline rounded-pill"><i class="fa fa-user"></i> Users</a>
<a href="{{route('orders.index')}}" class="btn btn-outline rounded-pill"><i class="fa fa-laptop"></i> Cashier</a>
<a href="{{route('products.barcode')}}" class="btn btn-outline rounded-pill"><i class="fa fa-barcode"></i> Barcode</a>
<a href="{{route('product.index')}}" class="btn btn-outline rounded-pill"><i class="fa fa-box"></i> Products</a>
<a href="#" class="btn btn-outline rounded-pill"><i class="fa fa-money-bill"></i> Transactions</a>
<a href="#" class="btn btn-outline rounded-pill"><i class="fa fa-truck"></i> Suppliers</a>
<a href="#" class="btn btn-outline rounded-pill"><i class="fa fa-users"></i> Customers</a>
<a href="#" class="btn btn-outline rounded-pill"><i class="fa fa-chart"></i> Incomings</a>
<a href="#" class="btn btn-outline rounded-pill"><i class="fa fa-file"></i> Report</a>



<!-- Styles -->
<style>
    .btn-outline {
        border-color: #008B8B;
        color: #008B8B;
    }

    .btn-outline:hover {
        background-color: #008B8B;
        color: #fff;
    }

    /* Ensure all buttons have uniform padding, margin, and font-size */
    .btn {
        padding: 10px 7px;  /* Adjust padding for uniformity */
        margin: 5px;          /* Adjust margin for spacing */
        font-size: 14px;      /* Set a base font size */
    }
</style>
