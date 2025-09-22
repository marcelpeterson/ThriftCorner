<footer class="mt-12 border-t border-gray-200 bg-black" aria-label="Footer">
    <div class="max-w-[90vw] mx-auto px-4 py-10">
        <div class="flex justify-between">
            <div>
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2" aria-label="ThriftCorner Home">
                    <span class="text-white font-extrabold text-lg tracking-tight" style="font-size: 48px;">ThriftCorner</span>
                </a>
                <p class="text-sm text-white w-[300px]">
                    A marketplace for Binus students to buy and sell textbooks, electronics, and dorm essentials.
                </p>
            </div>

            <div class="flex flex-col justify-center">
                <ul class="mt-3 space-y-2 text-md flex gap-16">
                    <li><a href="{{ url('/about') }}" class="text-white hover:text-blue-700">About Us</a></li>
                    <li><a href="{{ url('/contact') }}" class="text-white hover:text-blue-700">Contact</a></li>
                    <li><a href="{{ url('/terms') }}" class="text-white hover:text-blue-700">Terms</a></li>
                    <li><a href="{{ url('/privacy') }}" class="text-white hover:text-blue-700">Privacy</a></li>
                </ul>
            </div>
        </div>

        <div class="mt-10 flex flex-col gap-3 border-t border-gray-200 pt-6 sm:flex-row sm:items-center sm:justify-between text-white">
            <p class="text-xs">&copy; {{ date('Y') }} {{ config('app.name', 'ThriftCorner') }}. All rights reserved.</p>
            <p class="text-xs">Built for Binus students — buy smart, sell sustainably.</p>
        </div>
    </div>
</footer>
