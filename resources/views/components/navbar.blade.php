<nav class="bg-white/80 backdrop-blur border-b border-gray-200 sticky top-0 z-50" aria-label="Primary">
    <div class="max-w-[90vw] mx-auto px-4">
        <div class="flex h-16 items-center justify-between gap-4">
            <div class="flex items-center gap-3 min-w-0">
                <a href="{{ url('/') }}" class="flex items-center gap-2 shrink-0" aria-label="{{ config('app.name', 'ThriftCorner') }} Home">
                    <img src="{{ asset('storage/images/Logo.png') }}" alt="ThriftCorner Logo" width="192px">
                </a>
            </div>

            <!-- Desktop: links + search + auth -->
            @if(!auth()->check() || !auth()->user()->is_admin)
                <div class="hidden md:flex flex-1 justify-center">
                    <form action="{{ route('home') }}" class="flex items-center gap-2" method="GET">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search..." class="w-128 px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" />
                        <button type="submit" class="ml-2 border border-blue-700 rounded-full px-5 h-[35px] bg-blue-700 text-white hover:bg-transparent hover:text-black cursor-pointer transition-all">Search</button>
                    </form>
                </div>
            @endif

            <div class="hidden md:flex items-center gap-6 shrink-0">
                {{-- News Button --}}
                <a href="{{ route('news.index') }}" class="inline-flex items-center rounded-md px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-100 transition-colors {{ request()->routeIs('news.*') ? 'bg-gray-100 text-gray-900' : '' }}">
                    <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                    News
                </a>
                
                {{-- Sell Button (visible for non-admin users) --}}
                @if (Route::has('items.create') && (!auth()->check() || !auth()->user()->is_admin))
                    <a href="{{ auth()->check() ? route('items.create') : route('login') }}"
                       class="inline-flex items-center rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600 transition-colors">
                        <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Sell
                    </a>
                @endif
                
                <div class="flex items-center gap-4">
                    @auth
                        <div class="relative">
                            <button type="button"
                                    id="navbar-user-menu-button"
                                    class="flex items-center gap-2 rounded-full px-2 py-1 transition-colors hover:bg-gray-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600"
                                    aria-expanded="false"
                                    aria-haspopup="true"
                                    aria-controls="navbar-user-menu"
                                    data-navbar-user-toggle>
                                <img src="{{ Auth::user()->photo_url }}" alt="User photo from API" class="w-8 h-8 rounded-full object-cover">
                                <span class="text-sm font-medium text-gray-700">Welcome, {{ Auth::user()->first_name }}</span>
                                <svg class="h-4 w-4 text-gray-500 transition-transform duration-200 ease-out transform" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-arrow>
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.939l3.71-3.71a.75.75 0 111.06 1.061l-4.24 4.24a.75.75 0 01-1.06 0L5.25 8.29a.75.75 0 01-.02-1.06z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div id="navbar-user-menu" class="absolute right-0 mt-2 hidden min-w-[12rem] overflow-hidden rounded-lg border border-gray-100 bg-white shadow-lg focus:outline-none" data-navbar-user-menu role="menu" aria-labelledby="navbar-user-menu-button">
                                <ul class="py-2 text-sm text-gray-700" role="none">
                                    @if(!auth()->user()->is_admin)
                                        <li>
                                            <a href="{{ route('profile') }}" class="block px-4 py-2 hover:bg-gray-100" role="menuitem">Profile</a>
                                        </li>
                                        @if (Route::has('transactions.index'))
                                            <li>
                                                <a href="{{ route('transactions.index') }}" class="block px-4 py-2 hover:bg-gray-100" role="menuitem">My Transactions</a>
                                            </li>
                                        @endif
                                    @endif
                                    @if(auth()->user()->is_admin)
                                        <li class="{{ !auth()->user()->is_admin ? 'border-t border-gray-100 mt-2 pt-2' : '' }}">
                                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 hover:bg-purple-50 text-purple-600 font-semibold" role="menuitem">
                                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                                </svg>
                                                Admin Dashboard
                                            </a>
                                        </li>
                                    @else
                                        <li>
                                            <a href="#" class="block px-4 py-2 hover:bg-gray-100" role="menuitem">Settings</a>
                                        </li>
                                    @endif
                                    @if (Route::has('logout'))
                                        <li class="border-t border-gray-100 mt-2 pt-2">
                                            <form method="POST" action="{{ route('logout') }}" role="none">
                                                @csrf
                                                <button type="submit" class="flex w-full items-center justify-between px-4 py-2 text-left text-sm font-medium text-red-600 hover:bg-red-50 cursor-pointer" role="menuitem">
                                                    Sign out
                                                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd" d="M3 4.75A1.75 1.75 0 014.75 3h4.5a.75.75 0 010 1.5h-4.5a.25.25 0 00-.25.25v11.5c0 .138.112.25.25.25h4.5a.75.75 0 010 1.5h-4.5A1.75 1.75 0 013 16.25V4.75z" clip-rule="evenodd" />
                                                        <path fill-rule="evenodd" d="M8.47 5.47a.75.75 0 011.06 0l4.25 4.25a.75.75 0 010 1.06l-4.25 4.25a.75.75 0 11-1.06-1.06L11.69 11H7a.75.75 0 010-1.5h4.69L8.47 6.53a.75.75 0 010-1.06z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-4">
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-blue-700 transition-all">Log in</a>
                            @endif
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                   class="inline-flex items-center rounded-md border border-blue-700 bg-blue-700 px-3 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-transparent hover:text-black focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 transition-all">
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
                <a href="{{ route('home') }}" class="text-sm font-medium text-gray-700 hover:text-emerald-700 {{ request()->routeIs('home') || request()->routeIs('items') ? 'text-emerald-700' : '' }}">Browse Items</a>
                <a href="{{ route('news.index') }}" class="text-sm font-medium text-gray-700 hover:text-emerald-700 {{ request()->routeIs('news.*') ? 'text-emerald-700' : '' }}">News</a>
                @auth
                    @if (Route::has('transactions.index') && !auth()->user()->is_admin)
                        <a href="{{ route('transactions.index') }}" class="text-sm font-medium text-gray-700 hover:text-emerald-700 {{ request()->routeIs('transactions.*') ? 'text-emerald-700' : '' }}">Transactions</a>
                    @endif
                @endauth
                {{-- Sell Button (mobile - visible for non-admin users) --}}
                @if (Route::has('items.create') && (!auth()->check() || !auth()->user()->is_admin))
                    <a href="{{ auth()->check() ? route('items.create') : route('login') }}" class="text-sm font-semibold text-emerald-700">Sell</a>
                @endif
            </div>

            @if (!auth()->check() || !auth()->user()->is_admin)
                <form method="GET" action="{{ route('home') }}">
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

@once
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const toggle = document.querySelector('[data-navbar-user-toggle]');
                const menu = document.querySelector('[data-navbar-user-menu]');

                if (!toggle || !menu) {
                    return;
                }

                const arrow = toggle.querySelector('[data-arrow]');

                const closeMenu = () => {
                    toggle.setAttribute('aria-expanded', 'false');
                    menu.classList.add('hidden');
                    arrow?.classList.remove('rotate-180');
                };

                const openMenu = () => {
                    toggle.setAttribute('aria-expanded', 'true');
                    menu.classList.remove('hidden');
                    arrow?.classList.add('rotate-180');
                };

                toggle.addEventListener('click', (event) => {
                    event.preventDefault();
                    event.stopPropagation();

                    const isExpanded = toggle.getAttribute('aria-expanded') === 'true';
                    if (isExpanded) {
                        closeMenu();
                    } else {
                        openMenu();
                    }
                });

                document.addEventListener('click', (event) => {
                    if (!menu.contains(event.target) && !toggle.contains(event.target)) {
                        closeMenu();
                    }
                });

                document.addEventListener('keydown', (event) => {
                    if (event.key === 'Escape') {
                        closeMenu();
                    }
                });
            });
        </script>
    @endpush
@endonce
