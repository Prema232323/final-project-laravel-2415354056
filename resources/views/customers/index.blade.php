@extends('layouts.app')

@section('title', 'Customers')

@section('content')
<div class="min-h-screen bg-gray-50 px-6 py-8">

    {{-- Page Header --}}
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Customers</h1>
            <p class="mt-1 text-sm text-gray-500">Manage all your customer data in one place.</p>
        </div>
        <button onclick="openAddModal()"
            class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 active:scale-95 transition-all duration-150">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Add Customer
        </button>
    </div>

    {{-- Table Card --}}
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-gray-100 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-5 py-3.5 text-left font-semibold text-gray-600">Customer ID</th>
                    <th class="px-5 py-3.5 text-left font-semibold text-gray-600">Name</th>
                    <th class="px-5 py-3.5 text-left font-semibold text-gray-600">Email</th>
                    <th class="px-5 py-3.5 text-left font-semibold text-gray-600">Phone</th>
                    <th class="px-5 py-3.5 text-left font-semibold text-gray-600">Address</th>
                    <th class="px-5 py-3.5 text-left font-semibold text-gray-600">Status</th>
                    <th class="px-5 py-3.5 text-center font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($customers as $customer)
                <tr class="hover:bg-gray-50 transition-colors duration-100">
                    <td class="px-5 py-4 font-mono text-gray-700">{{ $customer['customer_id'] }}</td>
                    <td class="px-5 py-4 font-medium text-gray-900">{{ $customer['name'] }}</td>
                    <td class="px-5 py-4 text-gray-600">{{ $customer['email'] }}</td>
                    <td class="px-5 py-4 text-gray-600">{{ $customer['phone'] }}</td>
                    <td class="px-5 py-4 text-gray-600 max-w-[180px] truncate" title="{{ $customer['address'] }}">{{ $customer['address'] }}</td>
                    <td class="px-5 py-4">
                        @if ($customer['status'])
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-200">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                Active
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-500 ring-1 ring-gray-200">
                                <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span>
                                Inactive
                            </span>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center justify-center gap-2">

                            {{-- Edit --}}
                            <button
                                onclick="openEditModal({{ json_encode($customer) }})"
                                class="rounded-lg p-1.5 text-gray-400 hover:bg-indigo-50 hover:text-indigo-600 transition-colors"
                                title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 3.487a2.25 2.25 0 113.182 3.182L7.5 19.213l-4.5 1 1-4.5 12.862-12.726z" />
                                </svg>
                            </button>

                            {{-- Activate / Deactivate --}}
                            @if (!$customer['status'])
                                <form action="{{ route('customers.activate', $customer['id']) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                        class="rounded-lg p-1.5 text-gray-400 hover:bg-emerald-50 hover:text-emerald-600 transition-colors"
                                        title="Activate">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                            fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                </form>
                            @endif

                            {{-- Delete --}}
                            <button
                                onclick="openDeleteModal({{ $customer['id'] }}, '{{ addslashes($customer['name']) }}')"
                                class="rounded-lg p-1.5 text-gray-400 hover:bg-red-50 hover:text-red-600 transition-colors"
                                title="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
                                </svg>
                            </button>

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-5 py-16 text-center text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-3 h-10 w-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-4a4 4 0 11-8 0 4 4 0 018 0zm6 4a2 2 0 11-4 0 2 2 0 014 0zM3 18a2 2 0 114 0" />
                        </svg>
                        <p class="text-sm font-medium">No customers found.</p>
                        <p class="mt-1 text-xs">Add your first customer to get started.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ===================== MODAL INCLUDES ===================== --}}
@include('customers.create')
@include('customers.edit')
@include('customers.delete')

{{-- ===================== TOAST NOTIFICATIONS ===================== --}}
@if (session('toast_success'))
<div id="toast-success"
    class="fixed bottom-6 right-6 z-[60] flex items-center gap-3 rounded-xl bg-emerald-600 px-4 py-3 text-sm font-medium text-white shadow-lg transition-all duration-300">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
    </svg>
    {{ session('toast_success') }}
</div>
@endif

@if (session('toast_error'))
<div id="toast-error"
    class="fixed bottom-6 right-6 z-[60] flex items-center gap-3 rounded-xl bg-red-600 px-4 py-3 text-sm font-medium text-white shadow-lg transition-all duration-300">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
    </svg>
    {{ session('toast_error') }}
</div>
@endif

@push('scripts')
<script>
    // ── ADD MODAL ──────────────────────────────────────────────
    function openAddModal() {
        const modal = document.getElementById('addDataModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeAddModal() {
        const modal = document.getElementById('addDataModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // ── EDIT MODAL ─────────────────────────────────────────────
    function openEditModal(customer) {
        document.getElementById('edit_customer_id').value = customer.customer_id ?? '';
        document.getElementById('edit_name').value        = customer.name        ?? '';
        document.getElementById('edit_email').value       = customer.email       ?? '';
        document.getElementById('edit_phone').value       = customer.phone       ?? '';
        document.getElementById('edit_address').value     = customer.address     ?? '';
        document.getElementById('edit_status').value      = customer.status ? 'active' : 'inactive';
        document.getElementById('editForm').action        = `/customers/${customer.id}`;

        const modal = document.getElementById('editDataModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeEditModal() {
        const modal = document.getElementById('editDataModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // ── DELETE MODAL ───────────────────────────────────────────
    function openDeleteModal(id, name) {
        document.getElementById('delete_customer_name').textContent = name;
        document.getElementById('deleteForm').action = `/customers/${id}`;

        const modal = document.getElementById('deleteDataModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteDataModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // ── Close modal on backdrop click ──────────────────────────
    ['addDataModal', 'editDataModal', 'deleteDataModal'].forEach(id => {
        document.getElementById(id).addEventListener('click', function (e) {
            if (e.target === this) {
                this.classList.add('hidden');
                this.classList.remove('flex');
            }
        });
    });

    // ── Auto-open modal on server-side validation error ────────
    @if (session('open_modal'))
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('{{ session("open_modal") }}');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            @if (session('edit_customer_id'))
                document.getElementById('editForm').action        = '/customers/{{ session("edit_customer_id") }}';
                document.getElementById('edit_customer_id').value = '{{ old("customer_id") }}';
                document.getElementById('edit_name').value        = '{{ old("name") }}';
                document.getElementById('edit_email').value       = '{{ old("email") }}';
                document.getElementById('edit_phone').value       = '{{ old("phone") }}';
                document.getElementById('edit_address').value     = '{{ old("address") }}';
                document.getElementById('edit_status').value      = '{{ old("status") }}';
            @endif
        });
    @endif

    // ── Auto-dismiss toast after 3.5s ──────────────────────────
    document.addEventListener('DOMContentLoaded', () => {
        ['toast-success', 'toast-error'].forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                setTimeout(() => {
                    el.style.opacity = '0';
                    el.style.transform = 'translateY(8px)';
                    setTimeout(() => el.remove(), 300);
                }, 3500);
            }
        });
    });
</script>
@endpush

@endsection