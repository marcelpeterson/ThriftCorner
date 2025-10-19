<nav class="bg-white md:bg-white/80 md:backdrop-blur border-b border-gray-200 fixed top-0 left-0 right-0 z-50" aria-label="Primary">
    <!-- Mobile & Desktop Top Bar -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <!-- Mobile: Logo + Icons -->
        <div class="flex h-16 items-center justify-between gap-2">
            <!-- Logo (Mobile-only optimized) -->
            <a href="{{ url('/') }}" class="flex items-center shrink-0" aria-label="{{ config('app.name', 'ThriftCorner') }} Home">
                <!-- Mobile Logo (Image only) -->
                <img src="https://storage.thriftcorner.store/assets/Logo-img.jpg" alt="ThriftCorner Logo" class="h-8 w-auto md:hidden">
                <!-- Desktop Logo (With text) -->
                <img src="https://storage.thriftcorner.store/assets/Logo.png" alt="ThriftCorner Logo" class="hidden md:block h-8 w-auto">
            </a>

            <!-- Desktop Search -->
            @if(!auth()->check() || !auth()->user()->is_admin)
                <div class="hidden md:flex flex-1 justify-center px-4">
                    <form action="{{ route('home') }}" class="flex items-center gap-2 w-full max-w-lg" method="GET">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search..." class="flex-1 px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" />
                        <button type="submit" class="border border-blue-700 rounded-full px-5 h-[35px] font-semibold bg-blue-700 text-white hover:bg-blue-800 cursor-pointer hover:bg-transparent hover:text-black transition-all text-sm whitespace-nowrap">Search</button>
                    </form>
                </div>
            @endif

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center gap-2 shrink-0">
                {{-- News Button --}}
                <a href="{{ route('news.index') }}" class="inline-flex items-center rounded-md px-3 lg:px-4 py-2 text-xs sm:text-sm font-semibold text-gray-700 hover:bg-gray-100 transition-all transition-colors {{ request()->routeIs('news.*') ? 'bg-gray-100 text-gray-900' : '' }} whitespace-nowrap">
                    <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                    News
                </a>

                {{-- Sell Button --}}
                @if (Route::has('items.create') && (!auth()->check() || !auth()->user()->is_admin))
                    <a href="{{ auth()->check() ? route('items.create') : route('login') }}"
                       class="inline-flex items-center rounded-md mr-2 bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-700 transition-colors whitespace-nowrap">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Sell
                    </a>
                @endif

                {{-- User Menu --}}
                <div class="flex items-center gap-3">
                    @auth
                        <div class="relative">
                            <button type="button"
                                    id="navbar-user-menu-button"
                                    class="flex items-center gap-2 rounded-full px-2 py-1 transition-colors hover:bg-gray-100"
                                    aria-expanded="false"
                                    aria-haspopup="true"
                                    aria-controls="navbar-user-menu"
                                    data-navbar-user-toggle>
                                <img src="{{ Auth::user()->photo_url }}" alt="User photo" class="w-8 h-8 rounded-full object-cover">
                                <span class="text-sm font-medium text-gray-700">Hi, {{ Auth::user()->first_name }}</span>
                                <svg class="h-4 w-4 text-gray-500 transition-transform duration-200" viewBox="0 0 20 20" fill="currentColor" data-arrow>
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.939l3.71-3.71a.75.75 0 111.06 1.061l-4.24 4.24a.75.75 0 01-1.06 0L5.25 8.29a.75.75 0 01-.02-1.06z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div id="navbar-user-menu" class="absolute right-0 mt-2 hidden min-w-[12rem] overflow-hidden rounded-lg border border-gray-100 bg-white shadow-lg" data-navbar-user-menu role="menu" aria-labelledby="navbar-user-menu-button">
                                <ul class="py-2 text-sm text-gray-700" role="none">
                                    @if(!auth()->user()->is_admin)
                                        <li><a href="{{ route('profile') }}" class="block px-4 py-2 hover:bg-gray-100" role="menuitem">Profile</a></li>
                                        @if (Route::has('transactions.index'))
                                            <li><a href="{{ route('transactions.index') }}" class="block px-4 py-2 hover:bg-gray-100" role="menuitem">My Transactions</a></li>
                                        @endif
                                    @endif
                                    @if(auth()->user()->is_admin)
                                        <li><a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 hover:bg-purple-50 text-purple-600 font-semibold" role="menuitem">Admin Dashboard</a></li>
                                    @else
                                        <li><a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100" role="menuitem">Settings</a></li>
                                    @endif
                                    @if (Route::has('logout'))
                                        <li class="border-t border-gray-100 mt-2 pt-2">
                                            <form method="POST" action="{{ route('logout') }}" role="none">
                                                @csrf
                                                <button type="submit" class="flex w-full items-center justify-between px-4 py-2 text-left text-sm font-medium text-red-600 hover:bg-red-50 md:cursor-pointer" role="menuitem">
                                                    Sign out
                                                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
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
                        <div class="flex items-center gap-3">
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-blue-700 transition-all">Log in</a>
                            @endif
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center rounded-md border border-blue-700 bg-blue-700 px-3 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-transparent hover:text-black transition-all whitespace-nowrap">
                                    Register
                                </a>
                            @endif
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Mobile: Icon Buttons (Carousell Style) -->
            <div class="md:hidden flex items-center gap-1">
                {{-- Explore Icon --}}
                {{-- <a href="{{ route('home') }}" class="flex items-center justify-center w-10 h-10 rounded-full hover:bg-gray-100 transition-colors" title="Explore">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                </a> --}}

                {{-- News Button --}}
                <a href="{{ route('news.index') }}" class="inline-flex items-center rounded-md px-3 lg:px-4 py-2 text-xs sm:text-sm font-semibold text-gray-700 hover:bg-gray-100 transition-colors {{ request()->routeIs('news.*') ? 'bg-gray-100 text-gray-900' : '' }} whitespace-nowrap">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                </a>

                {{-- Account/Profile Icon --}}
                <button type="button" id="mobile-account-button" class="flex items-center justify-center w-11 h-11 rounded-full hover:bg-gray-100 transition-colors" title="Account" aria-expanded="false" aria-controls="mobile-account-menu">
                    @auth
                        <img src="{{ Auth::user()->photo_url }}" alt="User photo" class="w-7 h-7 rounded-full object-cover">
                    @else
                        <svg class="w-7 h-7 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    @endauth
                </button>
            </div>
        </div>

        <!-- Mobile: Search Bar (Full Width Below) -->
        @if(!auth()->check() || !auth()->user()->is_admin)
            <div class="md:hidden py-3 px-2 border-t border-gray-100">
                <form method="GET" action="{{ route('home') }}" class="flex items-center gap-2">
                    <div class="flex-1 flex items-center gap-2 bg-gray-100 rounded-full px-4 py-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input id="mobile-search" name="q" value="{{ request('q') }}" type="search"
                               placeholder="Search for an item..."
                               class="flex-1 bg-transparent text-sm placeholder-gray-500 focus:outline-none" />
                    </div>
                </form>
            </div>
        @endif
    </div>

    <!-- Mobile Account Drawer/Menu -->
    <div id="mobile-account-menu" class="hidden fixed inset-0 bg-gray-900/30 backdrop-blur-sm z-40 md:hidden" aria-hidden="true"></div>

    <div id="mobile-account-drawer" class="hidden fixed inset-x-0 top-16 bottom-0 bg-white shadow-xl z-40 overflow-y-auto md:hidden transform transition-transform duration-300">
        <div class="p-6">
            @auth
                {{-- User Header --}}
                <div class="mb-6 pb-6 border-b border-gray-200">
                    <div class="flex items-center gap-3 mb-2">
                        <img src="{{ Auth::user()->photo_url }}" alt="User photo" class="w-12 h-12 rounded-full object-cover">
                        <div>
                            <p class="font-semibold text-gray-900">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>

                {{-- Menu Items --}}
                <ul class="space-y-1">
                    {{-- Profile --}}
                    <li>
                        <a href="{{ route('profile') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-100 transition-colors text-gray-900">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="font-medium">Profile</span>
                        </a>
                    </li>

                    {{-- My Transactions --}}
                    <li>
                        <a href="{{ route('transactions.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-100 transition-colors text-gray-900">
                            <svg xmlns="http://www.w3.org/2000/svg" 
                            viewBox="0 0 24 24" 
                            fill="none" 
                            stroke="currentColor" 
                            stroke-width="2" 
                            stroke-linecap="round" 
                            stroke-linejoin="round" 
                            class="w-5 h-5">
                        <!-- Outer circle -->
                        <circle cx="12" cy="12" r="9" />
                        
                        <!-- History arrow (clockwise) -->
                        <path d="M12 7v5l3 3" />
                        
                        <!-- Small arc to indicate “time/history” -->
                        <path d="M21 12a9 9 0 1 0-9 9" />
                        </svg>
                            <span class="font-medium">My Transactions</span>
                        </a>
                    </li>

                    {{-- Buying Section --}}
                    {{-- <li class="pt-4">
                        <p class="text-xs font-semibold text-gray-400 uppercase px-4 mb-2">Buying</p>
                        <a href="{{ route('profile') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-100 transition-colors text-gray-900">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            <span class="font-medium">Likes</span>
                        </a>
                    </li> --}}

                    {{-- Selling Section --}}
                    @if (Route::has('items.create') && (!auth()->check() || !auth()->user()->is_admin))
                        <li class="pt-4">
                            <p class="text-xs font-semibold text-gray-400 uppercase px-4 mb-2">Selling</p>
                            <a href="{{ auth()->check() ? route('items.create') : route('login') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-red-50 transition-colors text-gray-900">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                <span class="font-medium text-red-600">Create Listing</span>
                            </a>
                        </li>
                    @endif

                    {{-- Account Section --}}
                    <li class="pt-4">
                        <p class="text-xs font-semibold text-gray-400 uppercase px-4 mb-2">Account</p>
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-100 transition-colors text-gray-900">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="font-medium">Settings</span>
                        </a>
                    </li>

                    {{-- Log Out --}}
                    <li class="pt-6 border-t border-gray-200 mt-6">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-red-50 transition-colors text-red-600 font-medium cursor-pointer">
                                <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 4.75A1.75 1.75 0 014.75 3h4.5a.75.75 0 010 1.5h-4.5a.25.25 0 00-.25.25v11.5c0 .138.112.25.25.25h4.5a.75.75 0 010 1.5h-4.5A1.75 1.75 0 013 16.25V4.75z" clip-rule="evenodd" />
                                    <path fill-rule="evenodd" d="M8.47 5.47a.75.75 0 011.06 0l4.25 4.25a.75.75 0 010 1.06l-4.25 4.25a.75.75 0 11-1.06-1.06L11.69 11H7a.75.75 0 010-1.5h4.69L8.47 6.53a.75.75 0 010-1.06z" clip-rule="evenodd" />
                                </svg>
                                <span>Log out</span>
                            </button>
                        </form>
                    </li>
                </ul>
            @else
                {{-- Not Logged In --}}
                <div class="space-y-3">
                    <p class="text-gray-600 font-medium mb-4 max-md:text-center">Sign in to your account</p>
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="block w-full text-center px-4 py-3 rounded-lg border border-blue-700 bg-blue-700 text-white font-semibold hover:bg-blue-800 transition-colors">
                            Log in
                        </a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="block w-full text-center px-4 py-3 rounded-lg border border-gray-300 bg-white text-gray-700 font-semibold hover:bg-gray-50 transition-colors">
                            Register
                        </a>
                    @endif
                </div>
            @endauth
        </div>
    </div>
</nav>

@once
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Desktop user menu dropdown
                const desktopToggle = document.querySelector('[data-navbar-user-toggle]');
                const desktopMenu = document.querySelector('[data-navbar-user-menu]');

                if (desktopToggle && desktopMenu) {
                    const arrow = desktopToggle.querySelector('[data-arrow]');

                    const closeDesktopMenu = () => {
                        desktopToggle.setAttribute('aria-expanded', 'false');
                        desktopMenu.classList.add('hidden');
                        arrow?.classList.remove('rotate-180');
                    };

                    const openDesktopMenu = () => {
                        desktopToggle.setAttribute('aria-expanded', 'true');
                        desktopMenu.classList.remove('hidden');
                        arrow?.classList.add('rotate-180');
                    };

                    desktopToggle.addEventListener('click', (event) => {
                        event.preventDefault();
                        event.stopPropagation();
                        const isExpanded = desktopToggle.getAttribute('aria-expanded') === 'true';
                        if (isExpanded) {
                            closeDesktopMenu();
                        } else {
                            openDesktopMenu();
                        }
                    });

                    document.addEventListener('click', (event) => {
                        if (!desktopMenu.contains(event.target) && !desktopToggle.contains(event.target)) {
                            closeDesktopMenu();
                        }
                    });

                    document.addEventListener('keydown', (event) => {
                        if (event.key === 'Escape') {
                            closeDesktopMenu();
                        }
                    });
                }

                // Mobile account drawer
                const mobileAccountButton = document.getElementById('mobile-account-button');
                const mobileAccountDrawer = document.getElementById('mobile-account-drawer');
                const mobileAccountMenu = document.getElementById('mobile-account-menu');

                if (mobileAccountButton && mobileAccountDrawer && mobileAccountMenu) {
                    const openDrawer = () => {
                        mobileAccountButton.setAttribute('aria-expanded', 'true');
                        mobileAccountDrawer.classList.remove('hidden');
                        mobileAccountMenu.classList.remove('hidden');
                        document.body.style.overflow = 'hidden';
                    };

                    const closeDrawer = () => {
                        mobileAccountButton.setAttribute('aria-expanded', 'false');
                        mobileAccountDrawer.classList.add('hidden');
                        mobileAccountMenu.classList.add('hidden');
                        document.body.style.overflow = 'auto';
                    };

                    mobileAccountButton.addEventListener('click', (event) => {
                        event.stopPropagation();
                        const isExpanded = mobileAccountButton.getAttribute('aria-expanded') === 'true';
                        if (isExpanded) {
                            closeDrawer();
                        } else {
                            openDrawer();
                        }
                    });

                    mobileAccountMenu.addEventListener('click', closeDrawer);
                    mobileAccountDrawer.addEventListener('click', (event) => event.stopPropagation());

                    // Close drawer when clicking on a link
                    mobileAccountDrawer.querySelectorAll('a').forEach(link => {
                        link.addEventListener('click', closeDrawer);
                    });

                    document.addEventListener('keydown', (event) => {
                        if (event.key === 'Escape' && mobileAccountButton.getAttribute('aria-expanded') === 'true') {
                            closeDrawer();
                        }
                    });
                }
            });
        </script>
    @endpush
@endonce
