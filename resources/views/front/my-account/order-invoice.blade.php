<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('images/favicon.ico') }}" rel="shortcut icon" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap"
        rel="stylesheet">
    <title>Moms Moonpie | Invoice</title>
    <style>
        * {
            box-sizing: border-box;
        }

        html {
            min-height: 100%;
            position: relative;
        }

        body {
            font-family: "Nunito", sans-serif;
            color: #000;
            font-size: 14px;
            margin: 0;
            padding: 0;
        }

        a,
        img {
            border: 0;
            outline: 0;
        }

        a {
            color: #000;
        }

        a:hover {
            color: #023467;
        }

        .page-wrapper {
            max-width: 750px;
            margin: 0px auto;
            background: #FFFFFF;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border: 0;
        }

        p {
            margin: 0 0 20px 0;
        }

        h1,
        h2,
        h3 {
            margin: 0;
        }
    </style>
</head>
@php
    function currency(){
        return '₹';
    }
@endphp
<body>
    <div class="page-wrapper">
        <table width="100%" style="border: 0; border-collapse: collapse;">
            <tr>
                <td><img src="{{ asset('images/logo.png') }}" style="max-width: 100%;" height="90"></td>
                <td style="text-align: right; padding-bottom: 15px;">
                    <p style="margin: 0 0 5px 0;"><strong>Order No.:</strong> #{{ $order->id }}</p>
                    <p style="margin: 0 0 5px 0;"><strong>Date:</strong>
                        {{ \Carbon\Carbon::parse($order->created_at)->format('d F Y') }}</p>
                    <p style="margin: 0 0 5px 0;"><strong>Payment Status:</strong> {{ $order->payment_status ?? 'N/A' }}</p>
                    <p style="margin: 0 0 5px 0;"><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table width="100%" style="border: 0; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th style="background: #f1f1f1; height: 50px; padding: 10px 8px; text-align: left;"></th>
                                <th style="background: #f1f1f1; height: 50px; padding: 10px 8px; text-align: left;">
                                    Product Name</th>
                                <th style="background: #f1f1f1; height: 50px; padding: 10px 8px; text-align: left;">
                                    Product Type</th>
                                <th style="background: #f1f1f1; height: 50px; padding: 10px 8px; text-align: left;">
                                    Price</th>
                                <th style="background: #f1f1f1; height: 50px; padding: 10px 8px; text-align: left;">
                                    Quantity</th>
                                <th style="background: #f1f1f1; height: 50px; padding: 10px 8px; text-align: left;">
                                    Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($order->orderItems as $item)
                                <tr>
                                    <td style="padding: 10px 8px; border-bottom: 1px solid #ccc;">
                                        <img src="{{ url('images/product-image') }}/{{ $item->product->productImages->first()->image_path ?? '' }}" style="max-width: 80px" alt="">
                                    </td>
                                    <td style="width: 200px; padding: 10px 8px; border-bottom: 1px solid #ccc;">{{ $item->product->title }}</td>
                                    <td style="padding: 10px 8px; border-bottom: 1px solid #ccc;">{{ $item->product->productType->title }}</td>
                                    <td style="padding: 10px 8px; border-bottom: 1px solid #ccc;">{{ $item->price }}</td>
                                    <td style="padding: 10px 8px; border-bottom: 1px solid #ccc; text-align:center;">{{ $item->quantity }}</td>
                                    <td style="padding: 10px 8px; border-bottom: 1px solid #ccc;">{{ $item->total_amount }}</td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="width: 60%;"></td>
                <td style="text-align: right; font-size: 16px;">
                    <table style="width: 100%; border: 0; border-collapse: collapse;">
                        <tr>
                            <td style="padding: 5px 0px;">Subtotal</td>
                            <td style="padding: 5px 0px;">{{ currency() }}{{ $order->subtotal }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px 0px;">Tax</td>
                            <td style="padding: 5px 0px;">{{ currency() }}{{ $order->tax_amount }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px 0px;">Shipping Charge</td>
                            <td style="padding: 5px 0px;">{{ currency() }}{{ $order->shipping_charge }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 10px 0px; border-top: 1px solid #ccc; font-weight: bold;">Grand Total
                            </td>
                            <td style="padding: 10px 0px; border-top: 1px solid #ccc; font-weight: bold;">
                                {{ currency() }}{{ $order->total_amount }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr></tr>
            <tr></tr>
            <tr>
                <td>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
