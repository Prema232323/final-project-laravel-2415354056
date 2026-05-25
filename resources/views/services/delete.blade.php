{{-- resources/views/services/delete.blade.php --}}
<div id="deleteDataModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-sm p-4">
    <div class="w-full max-w-sm rounded-2xl bg-white shadow-xl">
        <div class="px-6 py-6 text-center">
            <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-red-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
                </svg>
            </div>
            <h2 class="text-base font-bold text-gray-900">Delete Service</h2>
            <p class="mt-1.5 text-sm text-gray-500">
                Are you sure you want to delete
                <span id="delete_service_name" class="font-semibold text-gray-700"></span>?
                This action cannot be undone.
            </p>
        </div>
        <form id="deleteForm" action="" method="POST" class="flex gap-3 border-t border-gray-100 px-6 py-4">
            @csrf @method('DELETE')
            <button type="button" onclick="closeDeleteModal()"
                class="flex-1 rounded-lg border border-gray-200 px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors">Cancel</button>
            <button type="submit"
                class="flex-1 rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700 active:scale-95 transition-all">Yes, Delete</button>
        </form>
    </div>
</div>