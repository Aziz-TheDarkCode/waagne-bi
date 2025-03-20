<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Commande #') . $order->id }}
        </h2>
    </x-slot>

    <div class="py-12 /90">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Order Status Section -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Statut de la commande</h3>
                        @if(auth()->user()->isAdmin())
                            <form action="{{ route('orders.update.status', $order) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="status" 
                                        onchange="this.form.submit()"
                                        class="rounded-md border-gray-300 shadow-sm focus:border-brand-yellow focus:ring-brand-yellow">
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>En attente</option>
                                    <option value="preparing" {{ $order->status === 'preparing' ? 'selected' : '' }}>En préparation</option>
                                    <option value="ready" {{ $order->status === 'ready' ? 'selected' : '' }}>Prêt</option>
                                    <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Payé</option>
                                </select>
                            </form>
                        @else
                            <p class="text-gray-700">
                                Status actuel: <span class="font-semibold">{{ ucfirst($order->status) }}</span>
                            </p>
                        @endif
                    </div>

                    <!-- Order Details -->
                    <div class="mt-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Détails de la commande</h3>
                            <a href="{{ route('orders.invoice.download', $order) }}" 
                               class="bg-brand-coral text-white px-4 py-2 rounded-md">
                                Télécharger Facture
                            </a>
                        </div>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produit</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix unitaire</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($order->items as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->burger->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->quantity }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ number_format($item->unit_price, 2) }} FCFA</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ number_format($item->quantity * $item->unit_price, 2) }} FCFA</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-right font-semibold">Total:</td>
                                    <td class="px-6 py-4 whitespace-nowrap font-semibold">{{ number_format($order->total_amount, 2) }} FCFA</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 