<form action="{{ route('orders.update.status', $order) }}" method="POST">
    @csrf
    @method('PATCH')
    <select name="status" onchange="this.form.submit()">
        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>En attente</option>
        <option value="preparing" {{ $order->status === 'preparing' ? 'selected' : '' }}>En préparation</option>
        <option value="ready" {{ $order->status === 'ready' ? 'selected' : '' }}>Prêt</option>
        <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Payé</option>
    </select>
</form> 