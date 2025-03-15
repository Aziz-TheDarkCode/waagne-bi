<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Nos Burgers') }}
            </h2>
            @if (auth()->user()?->isAdmin())
                <a href="{{ route('burgers.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                    Ajouter un burger
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Message de notification -->
            <div id="notification" class="hidden fixed top-4 right-4 px-4 py-2 rounded-md text-white"></div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($burgers as $burger)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        @if ($burger->image_path)
                            <img src="{{ Storage::url($burger->image_path) }}" alt="{{ $burger->name }}" class="w-full h-48 object-cover">
                        @endif
                        <div class="p-6">
                            <h3 class="text-lg font-semibold">{{ $burger->name }}</h3>
                            <p class="text-gray-600 mt-2">{{ $burger->description }}</p>
                            <div class="mt-4 flex justify-between items-center">
                                <span class="text-lg font-bold">{{ number_format($burger->price, 0) }} FCFA</span>
                                <span class="text-sm {{ $burger->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $burger->stock > 0 ? 'En stock' : 'Rupture de stock' }}
                                </span>
                            </div>
                            @if ($burger->stock > 0)
                                <div class="mt-4 flex items-center space-x-2">
                                    <input type="number" 
                                           min="1" 
                                           max="{{ $burger->stock }}" 
                                           value="1" 
                                           id="quantity-{{ $burger->id }}"
                                           class="w-20 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <button onclick="addToCart({{ $burger->id }})" 
                                            class="flex-1 bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                                        Ajouter au panier
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function showNotification(message, isSuccess = true) {
            const notification = document.getElementById('notification');
            notification.textContent = message;
            notification.className = `fixed top-4 right-4 px-4 py-2 rounded-md text-white ${isSuccess ? 'bg-green-500' : 'bg-red-500'}`;
            notification.classList.remove('hidden');
            
            setTimeout(() => {
                notification.classList.add('hidden');
            }, 3000);
        }

        function updateCartCount(count) {
            const cartCount = document.getElementById('cart-count');
            if (cartCount) {
                cartCount.textContent = count;
            }
        }

        function addToCart(burgerId) {
            const quantity = parseInt(document.getElementById(`quantity-${burgerId}`).value);
            
            fetch(`{{ url('cart/add') }}/${burgerId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ quantity: quantity })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message);
                    updateCartCount(data.cartCount);
                } else {
                    showNotification(data.message, false);
                }
            })
            .catch(error => {
                showNotification('Une erreur est survenue', false);
                console.error('Error:', error);
            });
        }
    </script>
    @endpush
</x-app-layout> 