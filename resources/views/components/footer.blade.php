<footer class="mt-12 border-t border-gray-200 bg-black" aria-label="Footer">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8 sm:py-10">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
            <div>
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2" aria-label="ThriftCorner Home">
                    <span class="text-white font-extrabold text-2xl sm:text-2xl md:text-4xl tracking-tight">ThriftCorner</span>
                </a>
                <p class="text-xs sm:text-sm text-gray-300 mt-3 max-md:mt-1 max-w-xs leading-relaxed">
                    A marketplace for Binus students to buy and sell textbooks, electronics, and dorm essentials.
                </p>
            </div>

            <div class="flex flex-col justify-start md:justify-center">
                <ul class="space-y-2 text-xs sm:text-sm flex md:ml-auto gap-6 md:gap-12">
                    <li><a href="{{ url('/about') }}" class="text-gray-300 hover:text-blue-400 transition-colors">About Us</a></li>
                    <li><a href="{{ route('support.create') }}" class="text-gray-300 hover:text-blue-400 transition-colors">Support</a></li>
                    <li><a href="{{ url('/terms') }}" class="text-gray-300 hover:text-blue-400 transition-colors">Terms</a></li>
                    <li><a href="{{ url('/privacy') }}" class="text-gray-300 hover:text-blue-400 transition-colors">Privacy</a></li>
                </ul>
            </div>
        </div>

        <div class="mt-8 sm:mt-10 flex flex-col sm:flex-row gap-3 sm:gap-6 border-t border-gray-700 pt-6 sm:items-center sm:justify-between text-white">
            <p class="text-xs text-gray-400">&copy; {{ date('Y') }} {{ config('app.name', 'ThriftCorner') }}. All rights reserved.</p>
            <p class="text-xs text-gray-400">Built for Binus students — buy smart, sell sustainably.</p>
        </div>
    </div>
</footer>
