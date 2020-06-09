<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 40px;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        th {
            text-align: left;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">

    <div class="content">
        <div class="title m-b-md">
            New Checkout
        </div>

        <div>
            <table>
                <thead>
                <tr>
                    <th>name</th>
                    <th>category</th>
                    <th>price</th>
                    <th>number</th>
                    <th>brand</th>
                </tr>
                </thead>
                <tbody>
                @foreach($checkout->checkoutProducts as $product)
                <tr>
                    <td>{{ $product->product->name }}</td>
                    <td>{{ $product->product->category->name }}</td>
                    <td>{{ $product->product->price }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->product->brand }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
