@extends('layouts.app')

@section('title', 'Subscriptions')

@section('content')
<div class="min-h-screen bg-gray-50 px-6 py-8">

    {{-- Page Header --}}
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Subscriptions</h1>
            <p class="mt-1 text-sm text-gray-500">Monitor and manage all customer subscriptions.</p>
        </div>
        <button onclick="openAddModal()"
            class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 active:scale-95 transition-all duration-150">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Add Subscription
        </button>
    </div>

    {{-- Table Card --}}
    <div class="overflow-x-auto rounded-2xl border border-gray-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-gray-100 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-5 py-3.5 text-left font-semibold text-gray-600">Customer</th>
                    <th class="px-5 py-3.5 text-left font-semibold text-gray-600">Service</th>
                    <th class="px-5 py-3.5 text-left font-semibold text-gray-600">Start Date</th>
                    <th class="px-5 py-3.5 text-left font-semibold text-gray-600">End Date</th>
                    <th class="px-5 py-3.5 text-left font-semibold text-gray-600">Status</th>
                    <th class="px-5 py-3.5 text-center font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($subscriptions as $sub)
                <tr class="hover:bg-gray-50 transition-colors duration-100">
                    <td class="px-5 py-4 font-medium text-gray-900">
                        {{ $sub['customer']['name'] ?? $sub['customer_id'] }}
                    </td>
                    <td class="px-5 py-4 text-gray-700">
                        {{ $sub['service']['name'] ?? $sub['service_id'] }}
                    </td>
                    <td class="px-5 py-4 text-gray-600">
                        {{ $sub['start_date'] ? \Carbon\Carbon::parse($sub['start_date'])->format('d M Y') : '-' }}
                    </td>
                    <td class="px-5 py-4 text-gray-600">
                        {{ $sub['end_date'] ? \Carbon\Carbon::parse($sub['end_date'])->format('d M Y') : '-' }}
                    </td>
                    <td class="px-5 py-4">
                        @php
                            $statusMap = [
                                'active'    => ['bg-emerald-50 text-emerald-700 ring-emerald-200', 'bg-emerald-500', 'Active'],
                                'inactive'  => ['bg-gray-100 text-gray-500 ring-gray-200',         'bg-gray-400',    'Inactive'],
                                'trial'     => ['bg-blue-50 text-blue-700 ring-blue-200',           'bg-blue-500',    'Trial'],
                                'isolir'    => ['bg-orange-50 text-orange-700 ring-orange-200',     'bg-orange-500',  'Isolir'],
                                'dismantle' => ['bg-red-50 text-red-700 ring-red-200',              'bg-red-500',     'Dismantle'],
                            ];
                            $s = $statusMap[$sub['status']] ?? $statusMap['inactive'];
                        @endphp
                        <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold ring-1 {{ $s[0] }}">
                            <span class="h-1.5 w-1.5 rounded-full {{ $s[1] }}"></span>
                            {{ $s[2] }}
                        </span>
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center justify-center gap-1">

                            {{-- ACTIVE --}}
                            @if (in_array($sub['status'], ['trial', 'inactive', 'isolir']))
                            <form action="{{ route('subscriptions.activate', $sub['id']) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <button type="submit" title="Activate"
                                    class="rounded-lg p-1.5 text-gray-400 hover:bg-emerald-50 hover:text-emerald-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </form>
                            @endif

                            {{-- TRIAL --}}
                            @if (in_array($sub['status'], ['active', 'inactive', 'isolir']))
                            <form action="{{ route('subscriptions.trial', $sub['id']) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <button type="submit" title="Set to Trial"
                                    class="rounded-lg p-1.5 text-gray-400 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z" />
                                    </svg>
                                </button>
                            </form>
                            @endif

                            {{-- ISOLIR --}}
                            @if ($sub['status'] === 'active')
                            <form action="{{ route('subscriptions.isolir', $sub['id']) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <button type="submit" title="Isolir"
                                    class="rounded-lg p-1.5 text-gray-400 hover:bg-orange-50 hover:text-orange-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                    </svg>
                                </button>
                            </form>
                            @endif

                            {{-- INACTIVE --}}
                            @if (in_array($sub['status'], ['active', 'trial', 'isolir']))
                            <form action="{{ route('subscriptions.deactivate', $sub['id']) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <button type="submit" title="Deactivate"
                                    class="rounded-lg p-1.5 text-gray-400 hover:bg-amber-50 hover:text-amber-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636" />
                                    </svg>
                                </button>
                            </form>
                            @endif

                            {{-- DISMANTLE --}}
                            @if ($sub['status'] !== 'dismantle')
                            <form action="{{ route('subscriptions.dismantle', $sub['id']) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <button type="submit"
                                    onclick="return confirm('Dismantle this subscription?')"
                                    title="Dismantle"
                                    class="rounded-lg p-1.5 text-gray-400 hover:bg-red-50 hover:text-red-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916" />
                                    </svg>
                                </button>
                            </form>
                            @endif

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-16 text-center text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-3 h-10 w-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <p class="text-sm font-medium">No subscriptions found.</p>
                        <p class="mt-1 text-xs">Add your first subscription to get started.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Include --}}
@include('subscriptions.create')

{{-- Toast --}}
@if (session('toast_success'))
<div id="toast-success" class="fixed bottom-6 right-6 z-[60] flex items-center gap-3 rounded-xl bg-emerald-600 px-4 py-3 text-sm font-medium text-white shadow-lg transition-all duration-300">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
    {{ session('toast_success') }}
</div>
@endif
@if (session('toast_error'))
<div id="toast-error" class="fixed bottom-6 right-6 z-[60] flex items-center gap-3 rounded-xl bg-red-600 px-4 py-3 text-sm font-medium text-white shadow-lg transition-all duration-300">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
    {{ session('toast_error') }}
</div>
@endif

@push('scripts')
<script>
    function openAddModal() {
        const m = document.getElementById('addDataModal');
        m.classList.remove('hidden'); m.classList.add('flex');
    }
    function closeAddModal() {
        const m = document.getElementById('addDataModal');
        m.classList.add('hidden'); m.classList.remove('flex');
    }

    document.getElementById('addDataModal').addEventListener('click', function(e) {
        if (e.target === this) { this.classList.add('hidden'); this.classList.remove('flex'); }
    });

    @if (session('open_modal'))
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('{{ session("open_modal") }}');
            if (modal) { modal.classList.remove('hidden'); modal.classList.add('flex'); }
        });
    @endif

    document.addEventListener('DOMContentLoaded', () => {
        ['toast-success','toast-error'].forEach(id => {
            const el = document.getElementById(id);
            if (el) setTimeout(() => {
                el.style.opacity = '0'; el.style.transform = 'translateY(8px)';
                setTimeout(() => el.remove(), 300);
            }, 3500);
        });
    });
</script>
@endpush

@endsection