<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Order Receipt</title>
    <style>
        /* Style for the receipt */
        #invoice_pos {
            box-shadow: 0 0 1in -0.25in rgb(0, 0, 0.5);
            padding: 2mm;
            margin: 0 auto;
            width: 58mm;
            background: #fff;
        }
        .logo{
            border: 5px solid blue;
            border-radius: 50%;
            width: min-content;
          
            

        }

        #invoice_pos h2 {
            font-size: 1.5em;
            color: #222;
        }

        #invoice_pos h3 {
            font-size: 1.2em;
            font-weight: 300;
            line-height: 2em;
        }

        #invoice_pos p {
            font-size: 0.7em;
            font-weight: 300;
            line-height: 1.2em;
            color: #666;
        }

        #invoice_pos #top,
        #invoice_pos #mid,
        #invoice_pos #bot {
            border-bottom: 2px solid #686464;
        }

        #invoice_pos #top {
            min-height: 100px;
            text-align: center;
        }

        #invoice_pos #mid {
            min-height: 80px;
        }

        #invoice_pos #bot {
            min-height: 50px;
        }

        #invoice_pos .table {
            width: 100%;
        }

        #invoice_pos .table_title {
            font-size: 0.5em;
            background: #eee;
        }

        #invoice_pos .service {
            border-bottom: 1px solid #eee;
        }

        #invoice_pos .item {
            width: 24mm;
        }

        #invoice_pos .itemtext {
            font-size: 0.5em;
        }

        #invoice_pos #legalcopy {
            margin-top: 5mm;
            text-align: center;
        }

        .serial-number {
            margin-top: 5mm;
            margin-bottom: 2mm;
            text-align: center;
            font-size: 12px;
        }

        .serial {
            font-size: 10px !important;
        }
    </style>
</head>

<body>
    <div id="invoice_pos">
        <!-- PRINT RECEIPT -->
        <div id="printed_content">
            <center id="top">
                <div class="logo">PM</div>
                <div class="info"></div>
                <h2>PM POS</h2>
            </center>
        </div>

        <div id="mid">
            <div class="info">
                <h2>Contact Us</h2>
                <p>
                    Address: Baale Animashaun Road Alakuko <br />Email: hamzat@gmail.com <br />phone:+2348115708692
                </p>
            </div>
        </div>

        <!-- end of receipt mid -->

        <div id="bot">
            <div class="table">
                <table>
                    <tr class="table_title">
                        <td class="item">
                            <h2>Item</h2>
                        </td>
                        <td class="hours">
                            <h2>QTY</h2>
                        </td>
                        <td class="rate">
                            <h2>Unit</h2>
                        </td>
                        <td class="rate">
                            <h2>Discount</h2>
                        </td>
                        <td class="rate">
                            <h2>Sub_total</h2>
                        </td>
                    </tr>

                    @foreach ($order_receipt as $receipt) 
                    <tr class="service">
                        <td class="tableitem">
                            <p class="itemtext">{{ $receipt->product->product_name }}</p>
                        </td>
                        <td class="tableitem">
                            <p class="itemtext">{{ $receipt->quantity }}</p>
                        </td>
                        <td class="tableitem">
                            <p class="itemtext">{{ number_format($receipt->unit_price, 2) }}</p>
                        </td>
                        <td class="tableitem">
                            <p class="itemtext">{{ number_format($receipt->discount ?? 0, 2) }}</p>
                        </td>
                        <td class="tableitem">
                            <p class="itemtext">{{ number_format($receipt->amount, 2) }}</p>
                        </td>
                    </tr>
                    @endforeach

                    <tr class="table_title">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="rate">Tax</td>
                        <td class="payment">
                            <h2>
                                {{-- Calculate total tax or add tax value --}}
                            </h2>
                        </td>
                    </tr>

                    <tr class="table_title">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="rate">Total</td>
                        <td class="payment">
                            <h2>
                                <p class="itemtext">&#8358;{{ number_format($total_amount, 2) }}</p>
                            </h2>
                        </td>
                    </tr>
                    
                </table>

                <div id="legalcopy">
                    <p class="legal">
                        <strong>
                            **** Thank you for visiting ****
                        </strong> <br> The goods are subject to prices and tax.
                    </p>
                </div>

                <div class="serial-number">
                    Serial: <span class="serial">1234567889</span>
                    <span>{{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}</span>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
