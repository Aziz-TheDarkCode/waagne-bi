<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mon Panier') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if (count($cartItems) > 0)
                        <div class="flow-root">
                            <ul role="list" class="-my-6 divide-y divide-gray-200">
                                @foreach ($cartItems as $id => $item)
                                    <li class="flex py-6">
                                        <div class="flex-1 ml-4">
                                            <div class="flex justify-between text-base font-medium text-gray-900">
                                                <h3>{{ $item['name'] }}</h3>
                                                <p class="ml-4">{{ number_format($item['price'] * $item['quantity'], 2) }} FCFA</p>
                                            </div>
                                            <div class="flex mt-4 items-center">
                                                <div class="flex items-center border rounded-md">
                                                    <button type="button" onclick="updateQuantity({{ $id }}, -1)"
                                                        class="p-2 hover:bg-gray-100">-</button>
                                                    <span class="px-4">{{ $item['quantity'] }}</span>
                                                    <button type="button" onclick="updateQuantity({{ $id }}, 1)"
                                                        class="p-2 hover:bg-gray-100">+</button>
                                                </div>
                                                <form action="{{ route('cart.remove', $id) }}" method="POST" class="ml-4">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-500">Supprimer</button>
                                                </form>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
                            <div class="flex justify-between text-base font-medium text-gray-900">
                                <p>Total</p>
                                <p>{{ number_format($total, 2) }} FCFA</p>
                            </div>
                            <div class="mt-6 flex justify-between">
                                <form action="{{ route('cart.clear') }}" method="POST">
                                    @csrf
                                    <x-secondary-button type="submit">
                                        Vider le panier
                                    </x-secondary-button>
                                </form>
                                <form action="{{ route('orders.store') }}" method="POST">
                                    @csrf
                                    <x-primary-button type="submit">
                                        Commander
                                    </x-primary-button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <h3 class="text-lg font-medium text-gray-900">Votre panier est vide</h3>
                            <div class="mt-6">
                                <a href="{{ route('burgers.index') }}" class="text-indigo-600 hover:text-indigo-500">
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