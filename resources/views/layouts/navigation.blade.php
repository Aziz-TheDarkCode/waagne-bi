<nav x-data="{ open: false }" class="border-b border-brand-light/20 text-white">
    <!-- Navigation principale -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <a href="{{ route('burgers.index') }}" class="flex items-center">
                    <x-application-logo class="h-10 w-auto fill-current text-brand-yellow" />
                </a>

                <!-- Liens de navigation -->
                <div class="hidden sm:flex space-x-8 ms-12">
                    <x-nav-link :href="route('burgers.index')" :active="request()->routeIs('burgers.index')" class="text-brand-light hover:text-brand-yellow transition-colors duration-200 font-medium">
                        {{ __('Menu') }}
                    </x-nav-link>

                    @auth
                        <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')" class="text-brand-light hover:text-brand-yellow transition-colors duration-200 font-medium">
                            {{ __('Mes Commandes') }}
                        </x-nav-link>

                        @if (auth()->user()->isAdmin())
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="text-brand-light hover:text-brand-yellow transition-colors duration-200 font-medium">
                                {{ __('Tableau de bord') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Boutons de droite -->
            <div class="hidden sm:flex items-center space-x-6">
                @auth
                    <!-- Panier -->
                    <a href="{{ route('cart.index') }}" class="relative flex items-center px-4 py-2 bg-brand-coral text-white rounded-lg shadow-sm hover:bg-opacity-90 transition-all duration-200">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        
                        Finaliser mes achats 
                    </a>

                    <!-- Menu déroulant du profil -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center px-4 py-2 border border-brand-light/20 rounded-lg bg-brand-yellow text-brand-dark transition-all duration-200">
                                <div class="font-medium">{{ Auth::user()->name }}</div>
                                <svg class="ml-2 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="bg-white rounded-md shadow-lg py-1">
                                <x-dropdown-link :href="route('profile.edit')" class="text-brand-dark hover:bg-brand-light/10">
                                    {{ __('Profile') }}
                                </x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-brand-dark hover:bg-brand-light/10">
                                        {{ __('Déconnexion') }}
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="space-x-6">
                        <a href="{{ route('login') }}" class="text-brand-light hover:text-brand-yellow transition-colors duration-200 font-medium">Se connecter</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-brand-yellow text-brand-dark rounded-lg hover:bg-opacity-90 transition-all duration-200 font-medium">S'inscrire</a>
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open" class="p-2 rounded-md text-brand-light hover:text-brand-yellow transition-colors duration-200">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'block': !open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'block': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menu mobile -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1 border-t border-brand-light/10">
            <x-responsive-nav-link :href="route('burgers.index')" :active="request()->routeIs('burgers.index')" class="block px-3 py-2 text-base font-medium hover:bg-brand-dark/50 hover:text-brand-yellow">
                {{ __('Menu') }}
            </x-responsive-nav-link>

            @auth
                <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')" class="block px-3 py-2 text-base font-medium hover:bg-brand-dark/50 hover:text-brand-yellow">
                    {{ __('Mes Commandes') }}
                </x-responsive-nav-link>

                @if (auth()->user()->isAdmin())
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="block px-3 py-2 text-base font-medium hover:bg-brand-dark/50 hover:text-brand-yellow">
                        {{ __('Tableau de bord') }}
                    </x-responsive-nav-link>
                @endif

                <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')" class="block px-3 py-2 text-base font-medium hover:bg-brand-dark/50 hover:text-brand-yellow">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        {{ __('Panier') }}
                    </div>
                </x-responsive-nav-link>
            @endauth
        </div>

        <!-- Menu mobile du profil -->
        @auth
            <div class="pt-4 pb-3 border-t border-brand-light/10">
                <div class="px-4">
                    <div class="font-medium text-base text-brand-yellow">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-brand-light/70">{{ Auth::user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')" class="block px-3 py-2 text-base font-medium hover:bg-brand-dark/50 hover:text-brand-yellow">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-3 py-2 text-base font-medium hover:bg-brand-dark/50 hover:text-brand-yellow">
                            {{ __('Déconnexion') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-4 border-t border-brand-light/10 px-4 space-y-4">
                <div>
                    <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2 border border-brand-light/20 text-white rounded-lg hover:text-brand-yellow hover:border-brand-yellow transition-colors duration-200">
                        {{ __('Se connecter') }}
                    </a>
                </div>
                <div>
                    <a href="{{ route('register') }}" class="block w-full text-center px-4 py-2 bg-brand-yellow text-brand-dark rounded-lg hover:bg-opacity-90 transition-all duration-200 font-medium">
                        {{ __('S\'inscrire') }}
                    </a>
                </div>
            </div>
        @endauth
    </div>
</nav>