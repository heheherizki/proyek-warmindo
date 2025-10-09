<nav 
    class="bg-white/80 backdrop-blur-md shadow-lg sticky top-0 z-50" 
    x-data="{ 
        open: false, 
        cartCount: {{ count((array) session('cart')) }} 
    }"
    @cart-updated.window="cartCount = $event.detail.count"
>
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
        <a href="/" class="font-bold text-2xl text-orange-500">WarmindoKu</a>
        
        <div class="flex items-center space-x-4">
            <div class="hidden md:flex space-x-6 items-center">
                <a href="/#keunggulan" class="text-slate-600 hover:text-orange-500 transition duration-300">Keunggulan</a>
                <a href="/#menu" class="text-slate-600 hover:text-orange-500 transition duration-300">Menu</a>
                <a href="/#lokasi" class="text-slate-600 hover:text-orange-500 transition duration-300">Lokasi</a>
            </div>

            <a href="{{ route('cart.index') }}" class="relative text-slate-600 hover:text-orange-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <span 
                    id="cart-count"
                    x-show="cartCount > 0"
                    x-text="cartCount"
                    class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center"
                ></span>
            </a>
            
            <div class="hidden md:flex items-center">
                @guest
                    <a href="{{ route('login') }}" class="ml-4 bg-orange-500 text-white font-semibold py-2 px-4 rounded-full hover:bg-orange-600 transition duration-300 transform hover:scale-105">
                        Login Admin
                    </a>
                @endguest
                @auth
                    <a href="{{ url('/dashboard') }}" class="ml-4 font-semibold text-slate-600 hover:text-orange-500">Dashboard</a>
                @endauth
            </div>
            
            <div class="md:hidden">
                <button @click="open = !open" class="text-slate-600 hover:text-orange-500 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path :class="{'hidden': open, 'inline-block': !open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        <path :class="{'hidden': !open, 'inline-block': open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="open" @click.away="open = false" class="md:hidden bg-white shadow-lg border-t border-gray-200" style="display: none;">
        <a href="/#keunggulan" class="block py-3 px-4 text-base text-slate-600 hover:bg-orange-50 hover:text-orange-500">Keunggulan</a>
        <a href="/#menu" class="block py-3 px-4 text-base text-slate-600 hover:bg-orange-50 hover:text-orange-500">Menu</a>
        <a href="/#lokasi" class="block py-3 px-4 text-base text-slate-600 hover:bg-orange-50 hover:text-orange-500">Lokasi</a>
        <div class="border-t border-gray-100 my-1"></div>
        @guest
            <a href="{{ route('login') }}" class="block py-3 px-4 text-base font-semibold text-orange-500 hover:bg-orange-50">Login Admin</a>
        @endguest
        @auth
            <a href="{{ url('/dashboard') }}" class="block py-3 px-4 text-base text-slate-600 hover:bg-orange-50 hover:text-orange-500">Dashboard</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                        class="block w-full text-left py-3 px-4 text-base text-slate-600 hover:bg-orange-50 hover:text-orange-500">
                    Logout
                </a>
            </form>
        @endauth
    </div>
</nav>