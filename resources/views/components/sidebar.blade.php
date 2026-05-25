{{-- resources/views/components/sidebar.blade.php --}}
<aside class="fixed inset-y-0 left-0 z-40 flex w-64 flex-col bg-white border-r border-gray-100 shadow-sm">

    {{-- Logo --}}
    <div class="flex h-16 items-center gap-3 px-6 border-b border-gray-100">
        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
        </div>
        <span class="text-base font-bold text-gray-900 tracking-tight">{{ config('app.name') }}</span>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-0.5">

        <p class="px-3 pb-2 text-[10px] font-semibold uppercase tracking-widest text-gray-400">Main Menu</p>

        {{-- Dashboard --}}
        <a href="{{ url('/') }}"
            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-colors
            {{ $active === 'dashboard' ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Dashboard
        </a>

        {{-- Customers --}}
        <a href="{{ route('customers.index') }}"
            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-colors
            {{ $active === 'customers' ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-4a4 4 0 11-8 0 4 4 0 018 0zm6 4a2 2 0 11-4 0 2 2 0 014 0zM3 18a2 2 0 114 0" />
            </svg>
            Customers
        </a>

        {{-- Services --}}
        <a href="{{ route('services.index') }}"
            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-colors
            {{ $active === 'services' ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
            </svg>
            Services
        </a>

        {{-- Subscriptions --}}
        <a href="{{ route('subscriptions.index') }}"
            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-colors
            {{ $active === 'subscriptions' ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            Subscriptions
        </a>

    </nav>

    {{-- Bottom: User info + Logout --}}
    <div class="border-t border-gray-100 px-4 py-4">
        <div class="flex items-center gap-3">
            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold shrink-0">
                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
            </div>
            <div class="min-w-0">
                <p class="truncate text-sm font-semibold text-gray-900">{{ auth()->user()->name ?? 'User' }}</p>
                <p class="truncate text-xs text-gray-400">{{ auth()->user()->email ?? '' }}</p>
            </div>
                @csrf
                <button type="submit"
                    class="rounded-lg p-1.5 text-gray-400 hover:bg-red-50 hover:text-red-500 transition-colors"
                    title="Logout">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

</aside>