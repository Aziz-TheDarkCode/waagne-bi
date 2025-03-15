<!DOCTYPE html>
<html>
<head>
    <title>Order #{{ $order->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .order-details {
            margin: 20px;
        }
        .order-details table {
            width: 100%;
            border-collapse: collapse;
        }
        .order-details th, .order-details td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Commande #{{ $order->id }}</h1>
        <p>Date: {{ $order->created_at->format('d/m/Y H:i') }}</p>
        <p>Status: {{ ucfirst($order->status) }}</p>
    </div>

    <div class="order-details">
        <h2>Details de la commande</h2>
        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Quantite</th>
                    <th>Prix unitaire</th>
                    <th>Prix total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->burger->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->unit_price, 2) }} FCFA</td>
                        <td>{{ number_format($item->quantity * $item->unit_price, 2) }} FCFA</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <h3>Montant total: {{ number_format($order->total_amount, 2) }} FCFA</h3>
    </div>
</body>
</html> 