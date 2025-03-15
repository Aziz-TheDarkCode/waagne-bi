<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Détails de la Commande') }} #{{ $order->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3>Status: {{ ucfirst($order->status) }}</h3>

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

                    <!-- Other order details here -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 