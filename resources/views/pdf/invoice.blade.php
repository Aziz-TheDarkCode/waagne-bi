<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture #{{ $order->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
        }
        .header {
            padding: 20px 0;
            border-bottom: 1px solid #ddd;
        }
        .company-info {
            float: left;
            width: 50%;
        }
        .invoice-info {
            float: right;
            width: 50%;
            text-align: right;
        }
        .clear {
            clear: both;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
        }
        .total {
            text-align: right;
            font-weight: bold;
            font-size: 16px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-info">
            <h1>{{ $company['name'] }}</h1>
            <p>{{ $company['address'] }}<br>
               {{ $company['city'] }}<br>
               Tél: {{ $company['phone'] }}<br>
               Email: {{ $company['email'] }}</p>
        </div>
        <div class="invoice-info">
            <h2>Facture #{{ $order->id }}</h2>
            <p>Date: {{ $order->created_at->format('d/m/Y') }}<br>
               Client: {{ $order->user->name }}<br>
               Email: {{ $order->user->email }}</p>
        </div>
        <div class="clear"></div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->burger->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->unit_price, 2) }} FCFA</td>
                    <td>{{ number_format($item->unit_price * $item->quantity, 2) }} FCFA</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        Total: {{ number_format($order->total_amount, 2) }} FCFA
    </div>

    <div style="margin-top: 40px">
        <p>Merci de votre confiance !</p>
    </div>
</body>
</html> 