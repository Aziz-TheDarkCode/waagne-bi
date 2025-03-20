<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mon Panier') }}
        </h2>
    </x-slot>

    <div class="py-12 /90">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Debug information -->
          
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if (count($cartItems) > 0)
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produit</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix unitaire</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($cartItems as $id => $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item['name'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ number_format($item['price'], 0) }} FCFA</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center space-x-2">
                                                @csrf
                                                @method('PATCH')
                                                <input type="number" 
                                                       name="quantity" 
                                                       value="{{ $item['quantity'] }}" 
                                                       min="1"
                                                       class="w-20 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                       onchange="this.form.submit()">
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ number_format($item['price'] * $item['quantity'], 0) }} FCFA</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <form action="{{ route('cart.remove', $id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-right font-bold">Total:</td>
                                    <td class="px-6 py-4 font-bold">{{ number_format($total, 0) }} FCFA</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>

                        <div class="mt-6 flex justify-between">
                            <form action="{{ route('cart.clear') }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                                    Vider le panier
                                </button>
                            </form>

                            <form action="{{ route('orders.store') }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                                    Commander
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="text-center py-12 /90">
                            <h3 class="text-lg font-medium text-gray-900">Votre panier est vide</h3>
                            <div class="mt-6">
                                <a href="{{ route('burgers.index') }}" class="text-brand-yellow hover:text-brand-yellow">
                                    Continuer les achats <span aria-hidden="true"> &rarr;</span>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function updateQuantity(burgerId, change) {
            const currentQuantity = parseInt(document.querySelector(`[data-burger-id="${burgerId}"]`).textContent);
            const newQuantity = Math.max(1, currentQuantity + change);

            fetch(`/cart/update/${burgerId}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ quantity: newQuantity })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }
    </script>
    @endpush
</x-app-layout> 