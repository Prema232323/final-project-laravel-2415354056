{{-- resources/views/subscriptions/create.blade.php --}}
<div id="addDataModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-sm p-4">
    <div class="w-full max-w-md rounded-2xl bg-white shadow-xl">
        <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
            <h2 class="text-base font-bold text-gray-900">Add New Subscription</h2>
            <button onclick="closeAddModal()" class="rounded-lg p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <form action="{{ route('subscriptions.store') }}" method="POST" class="px-6 py-5 space-y-4">
            @csrf

            {{-- Customer --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Customer</label>
                <select name="customer_id"
                    class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 {{ $errors->has('customer_id') ? 'border-red-400' : '' }}">
                    <option value="">— Select Customer —</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer['id'] }}" {{ old('customer_id') == $customer['id'] ? 'selected' : '' }}>
                            {{ $customer['name'] }}
                        </option>
                    @endforeach
                </select>
                @error('customer_id') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            {{-- Service --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Service</label>
                <select name="service_id"
                    class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 {{ $errors->has('service_id') ? 'border-red-400' : '' }}">
                    <option value="">— Select Service —</option>
                    @foreach ($services as $service)
                        <option value="{{ $service['id'] }}" {{ old('service_id') == $service['id'] ? 'selected' : '' }}>
                            {{ $service['name'] }} — Rp {{ number_format($service['price'], 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
                @error('service_id') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            {{-- Date Range --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Start Date</label>
                    <input type="date" name="start_date" value="{{ old('start_date') }}"
                        class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 {{ $errors->has('start_date') ? 'border-red-400' : '' }}">
                    @error('start_date') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">End Date</label>
                    <input type="date" name="end_date" value="{{ old('end_date') }}"
                        class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 {{ $errors->has('end_date') ? 'border-red-400' : '' }}">
                    @error('end_date') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Status</label>
                <select name="status"
                    class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
                    <option value="active"    {{ old('status') === 'active'    ? 'selected' : '' }}>Active</option>
                    <option value="trial"     {{ old('status') === 'trial'     ? 'selected' : '' }}>Trial</option>
                    <option value="inactive"  {{ old('status') === 'inactive'  ? 'selected' : '' }}>Inactive</option>
                    <option value="isolir"    {{ old('status') === 'isolir'    ? 'selected' : '' }}>Isolir</option>
                    <option value="dismantle" {{ old('status') === 'dismantle' ? 'selected' : '' }}>Dismantle</option>
                </select>
                @error('status') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="closeAddModal()"
                    class="rounded-lg border border-gray-200 px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors">Cancel</button>
                <button type="submit"
                    class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 active:scale-95 transition-all">Save Subscription</button>
            </div>
        </form>
    </div>
</div>