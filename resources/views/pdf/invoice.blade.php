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
            text-align: center;
            margin-bottom: 30px;
        }
        .invoice-info {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
        }
        .total {
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>FACTURE</h1>
        <p>Numéro de commande: #{{ $order->id }}</p>
    </div>

    <div class="invoice-info">
        <p><strong>Date:</strong> {{ $order->created_at->format('d/m/Y') }}</p>
        <p><strong>Client:</strong> {{ $order->user->name }}</p>
        <p><strong>Email:</strong> {{ $order->user->email }}</p>
        <p><strong>Statut:</strong> {{ ucfirst($order->status) }}</p>
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
                    <td>{{ number_format($item->unit_price, 0) }} FCFA</td>
                    <td>{{ number_format($item->quantity * $item->unit_price, 0) }} FCFA</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="total">Total:</td>
                <td>{{ number_format($order->total_amount, 0) }} FCFA</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Merci de votre confiance!</p>
    </div>
</body>
</html> 