<nav class="bg-white/80 backdrop-blur border-b border-gray-200 sticky top-0 z-50" aria-label="Primary">
    <div class="max-w-[90vw] mx-auto px-4">
        <div class="flex h-16 items-center justify-between gap-4">
            <div class="flex items-center gap-3 min-w-0">
                <a href="{{ url('/') }}" class="flex items-center gap-2 shrink-0" aria-label="{{ config('app.name', 'ThriftCorner') }} Home">
                    <img src="{{ asset('storage/images/Logo.png') }}" alt="ThriftCorner Logo" width="192px">
                </a>
            </div>

            <!-- Desktop: links + search + auth -->
            <div class="hidden md:flex flex-1 justify-center">
                <form action="" class="flex items-center gap-2" method="GET">
                    <input type="text" placeholder="Search..." class="w-128 px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                    <button type="submit" class="ml-2 border border-blue-700 rounded-full px-5 h-[35px] bg-blue-700 text-white hover:bg-transparent hover:text-black cursor-pointer">Search</button>
                </form>
            </div>

            <div class="hidden md:flex items-center gap-6 shrink-0">
                @if (Route::has('listings.index'))
                    <a href="{{ route('listings.index') }}"
                       class="text-sm font-medium transition-colors {{ request()->routeIs('listings.*') ? 'text-emerald-700' : 'text-gray-700 hover:text-emerald-700' }}">
                        Listings
                    </a>
                @endif

                @if (Route::has('categories.index'))
                    <a href="{{ route('categories.index') }}"
                       class="text-sm font-medium transition-colors {{ request()->routeIs('categories.*') ? 'text-emerald-700' : 'text-gray-700 hover:text-emerald-700' }}">
                        Categories
                    </a>
                @endif

                @auth
                    @if (Route::has('listings.create'))
                        <a href="{{ route('listings.create') }}"
                           class="inline-flex items-center rounded-md bg-emerald-600 px-3 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600">
                            Post Listing
                        </a>
                    @endif
                @endauth
                
                <div class="flex items-center gap-4">
                    @auth
                        <span class="text-sm font-medium text-gray-700 hover:text-blue-700">Welcome, {{ Auth::user()->first_name }}</span>
                        @if (Route::has('logout'))
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="inline-flex items-center rounded-md bg-red-700 px-3 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-red-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-700 cursor-pointer">Log out</button>
                            </form>
                        @endif
                    @else
                        <div class="flex items-center gap-3">
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-blue-700">Log in</a>
                            @endif
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                   class="inline-flex items-center rounded-md border border-blue-700 bg-blue-700 px-3 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-transparent hover:text-black focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                                    Register
                                </a>
                            @endif
                        </div>
                    @endauth
                </div>
            </div>
        </div>
        <div class="md:hidden py-2 space-y-2">
            <div class="flex flex-wrap items-center gap-x-4 gap-y-1">
                @if (Route::has('listings.index'))
                    <a href="{{ route('listings.index') }}" class="text-sm font-medium text-gray-700 hover:text-emerald-700 {{ request()->routeIs('listings.*') ? 'text-emerald-700' : '' }}">Listings</a>
                @endif
                @if (Route::has('categories.index'))
                    <a href="{{ route('categories.index') }}" class="text-sm font-medium text-gray-700 hover:text-emerald-700 {{ request()->routeIs('categories.*') ? 'text-emerald-700' : '' }}">Categories</a>
                @endif
                @auth
                    @if (Route::has('listings.create'))
                        <a href="{{ route('listings.create') }}" class="text-sm font-semibold text-emerald-700">Post Listing</a>
                    @endif
                @endauth
            </div>

            @if (Route::has('listings.index'))
                <form method="GET" action="{{ route('listings.index') }}">
                    <label for="nav-search-mobile" class="sr-only">Search listings</label>
                    <input id="nav-search-mobile" name="q" value="{{ request('q') }}" type="search"
                           placeholder="Search listings..."
                           class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm placeholder:text-gray-400 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500" />
                </form>
            @endif

            <div class="flex items-center gap-3">
                @auth
                    @if (Route::has('dashboard'))
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-700 hover:text-emerald-700">Dashboard</a>
                    @endif
                    @if (Route::has('logout'))
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-700">Log out</button>
                        </form>
                    @endif
                @else
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-emerald-700">Log in</a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-sm font-medium text-gray-700 hover:text-emerald-700">Register</a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</nav>
