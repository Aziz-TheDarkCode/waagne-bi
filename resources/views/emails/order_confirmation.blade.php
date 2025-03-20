<!DOCTYPE html>
<html>
<head>
    <title>Confirmation de votre commande</title>
</head>
<body>
    <h1>Merci pour votre commande!</h1>
    <p>Votre commande #{{ $order->id }} a été reçue et est en cours de traitement.</p>
    <p>Statut: {{ ucfirst($order->status) }}</p>
    <p>Montant total: {{ number_format($order->total_amount, 2) }} FCFA</p>
    <p>Nous vous informerons lorsque votre commande sera prête.</p>
</body>
</html> 