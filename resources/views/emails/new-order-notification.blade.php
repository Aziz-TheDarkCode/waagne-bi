<!DOCTYPE html>
<html>
<head>
    <title>Nouvelle Commande</title>
</head>
<body>
    <h1>Nouvelle Commande #{{ $order->id }}</h1>
    
    <h2>Détails de la commande:</h2>
    <p>Client: {{ $order->user->name }}</p>
    <p>Email: {{ $order->user->email }}</p>
    <p>Date: {{ $order->created_at->format('d/m/Y H:i') }}</p>
    
    <h3>Articles commandés:</h3>
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Produit</th>
                <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Quantité</th>
                <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Prix unitaire</th>
                <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $item->burger->name }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $item->quantity }}</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ number_format($item->unit_price, 2) }} FCFA</td>
                    <td style="border: 1px solid #ddd; padding: 8px;">{{ number_format($item->quantity * $item->unit_price, 2) }} FCFA</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="border: 1px solid #ddd; padding: 8px; text-align: right;"><strong>Total:</strong></td>
                <td style="border: 1px solid #ddd; padding: 8px;"><strong>{{ number_format($order->total_amount, 2) }} FCFA</strong></td>
            </tr>
        </tfoot>
    </table>

    <p>
        <a href="{{ route('orders.show', $order->id) }}" style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
            Voir la commande
        </a>
    </p>
</body>
</html> 