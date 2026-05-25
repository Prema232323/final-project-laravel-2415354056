@extends('layouts.app')

@section('title', 'Services')

@section('content')
<div class="min-h-screen bg-gray-50 px-6 py-8">

    {{-- Page Header --}}
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Services</h1>
            <p class="mt-1 text-sm text-gray-500">Manage all available service packages.</p>
        </div>
        <button onclick="openAddModal()"
            class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 active:scale-95 transition-all duration-150">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Add Service
        </button>
    </div>

    {{-- Table Card --}}
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-gray-100 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-5 py-3.5 text-left font-semibold text-gray-600">Name</th>
                    <th class="px-5 py-3.5 text-left font-semibold text-gray-600">Price</th>
                    <th class="px-5 py-3.5 text-left font-semibold text-gray-600">Description</th>
                    <th class="px-5 py-3.5 text-left font-semibold text-gray-600">Status</th>
                    <th class="px-5 py-3.5 text-center font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($services as $service)
                <tr class="hover:bg-gray-50 transition-colors duration-100">
                    <td class="px-5 py-4 font-medium text-gray-900">{{ $service['name'] }}</td>
                    <td class="px-5 py-4 text-gray-700 font-mono">
                        Rp {{ number_format($service['price'], 0, ',', '.') }}
                    </td>
                    <td class="px-5 py-4 text-gray-600 max-w-[220px] truncate" title="{{ $service['description'] }}">
                        {{ $service['description'] ?? '-' }}
                    </td>
                    <td class="px-5 py-4">
                        @if ($service['status'])
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
                            <button onclick="openEditModal({{ json_encode($service) }})"
                                class="rounded-lg p-1.5 text-gray-400 hover:bg-indigo-50 hover:text-indigo-600 transition-colors"
                                title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 3.487a2.25 2.25 0 113.182 3.182L7.5 19.213l-4.5 1 1-4.5 12.862-12.726z" />
                                </svg>
                            </button>

                            {{-- Activate --}}
                            @if (!$service['status'])
                                <form action="{{ route('services.activate', $service['id']) }}" method="POST" class="inline">
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
                            <button onclick="openDeleteModal({{ $service['id'] }}, '{{ addslashes($service['name']) }}')"
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
                    <td colspan="5" class="px-5 py-16 text-center text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-3 h-10 w-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
                        </svg>
                        <p class="text-sm font-medium">No services found.</p>
                        <p class="mt-1 text-xs">Add your first service to get started.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Includes --}}
@include('services.create')
@include('services.edit')
@include('services.delete')

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

    function openEditModal(service) {
        document.getElementById('edit_name').value        = service.name        ?? '';
        document.getElementById('edit_price').value       = service.price       ?? '';
        document.getElementById('edit_description').value = service.description ?? '';
        document.getElementById('edit_status').value      = service.status ? 'active' : 'inactive';
        document.getElementById('editForm').action        = `/services/${service.id}`;
        const m = document.getElementById('editDataModal');
        m.classList.remove('hidden'); m.classList.add('flex');
    }
    function closeEditModal() {
        const m = document.getElementById('editDataModal');
        m.classList.add('hidden'); m.classList.remove('flex');
    }

    function openDeleteModal(id, name) {
        document.getElementById('delete_service_name').textContent = name;
        document.getElementById('deleteForm').action = `/services/${id}`;
        const m = document.getElementById('deleteDataModal');
        m.classList.remove('hidden'); m.classList.add('flex');
    }
    function closeDeleteModal() {
        const m = document.getElementById('deleteDataModal');
        m.classList.add('hidden'); m.classList.remove('flex');
    }

    ['addDataModal','editDataModal','deleteDataModal'].forEach(id => {
        document.getElementById(id).addEventListener('click', function(e) {
            if (e.target === this) { this.classList.add('hidden'); this.classList.remove('flex'); }
        });
    });

    @if (session('open_modal'))
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('{{ session("open_modal") }}');
            if (modal) { modal.classList.remove('hidden'); modal.classList.add('flex'); }

            @if (session('edit_service_id'))
                document.getElementById('editForm').action        = '/services/{{ session("edit_service_id") }}';
                document.getElementById('edit_name').value        = '{{ old("name") }}';
                document.getElementById('edit_price').value       = '{{ old("price") }}';
                document.getElementById('edit_description').value = '{{ old("description") }}';
                document.getElementById('edit_status').value      = '{{ old("status") }}';
            @endif
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