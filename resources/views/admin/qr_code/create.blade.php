@extends('admin.layout.app')

@section('content')
<div class="p-6 md:p-8">

    <div class="flex items-center space-x-3 mb-6">
        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
        </svg>
        <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Add New QR Code</h2>
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 md:p-8">
        <form action="{{ route('admin.qr-codes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- QR Code Image --}}
            <div class="mb-5">
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">
                    QR Code Image <span class="text-red-500">*</span>
                </label>
                <input type="file"
                       class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('image') border-red-500 @enderror"
                       id="image" name="image" accept="image/*" required
                       onchange="previewImage(this)">
                @error('image')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                {{-- Preview --}}
                <div id="image-preview-container" class="mt-3 hidden">
                    <p class="text-sm text-gray-600 mb-1">Preview:</p>
                    <img id="image-preview" src="#" alt="QR Code Preview"
                         class="h-40 w-40 object-contain border border-gray-200 rounded-lg">
                </div>
            </div>

            {{-- App URL --}}
            <div class="mb-6">
                <label for="app_url" class="block text-sm font-medium text-gray-700 mb-1">App URL</label>
                <input type="url"
                       class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('app_url') border-red-500 @enderror"
                       id="app_url" name="app_url" value="{{ old('app_url') }}"
                       placeholder="https://play.google.com/store/apps/...">
                @error('app_url')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Buttons --}}
            <div class="flex gap-3 pt-4 border-t border-gray-100">
                <button type="submit"
                        class="inline-flex justify-center items-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Save
                </button>
                <a href="{{ route('admin.qr-codes.index') }}"
                   class="inline-flex justify-center items-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition duration-150 ease-in-out">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(input) {
    const container = document.getElementById('image-preview-container');
    const preview = document.getElementById('image-preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            container.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
