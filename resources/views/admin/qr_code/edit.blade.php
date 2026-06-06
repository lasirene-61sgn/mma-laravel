@extends('admin.layout.app')

@section('content')
<div class="p-6 md:p-8">

    <div class="flex items-center space-x-3 mb-6">
        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
        </svg>
        <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Edit QR Code</h2>
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 md:p-8">
        <form action="{{ route('admin.qr-codes.update', $qrCode->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- QR Code Image --}}
            <div class="mb-5">
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">
                    QR Code Image <span class="text-gray-400 text-xs font-normal">(Leave blank if keeping current image)</span>
                </label>
                <input type="file"
                       class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('image') border-red-500 @enderror"
                       id="image" name="image" accept="image/*"
                       onchange="previewImage(this)">
                @error('image')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                {{-- Image Display: Resolves storage path nicely using Storage::url --}}
                <div id="image-preview-container" class="mt-3 {{ !empty($qrCode->image) ? '' : 'hidden' }}">
                    <p class="text-sm text-gray-600 mb-1" id="preview-label">{{ !empty($qrCode->image) ? 'Current QR Code:' : 'Preview:' }}</p>
                    <img id="image-preview" 
     src="{{ !empty($qrCode->image) ? asset('storage/' . $qrCode->image) : '#' }}" 
     alt="QR Code Preview"
     class="h-40 w-40 object-contain border border-gray-200 rounded-lg bg-gray-50">
                </div>
            </div>

            {{-- App URL --}}
            <div class="mb-6">
                <label for="app_url" class="block text-sm font-medium text-gray-700 mb-1">App URL</label>
                <input type="url"
                       class="form-input w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('app_url') border-red-500 @enderror"
                       id="app_url" name="app_url" value="{{ old('app_url', $qrCode->app_url) }}"
                       placeholder="https://play.google.com/store/apps/...">
                @error('app_url')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Action Triggers --}}
            <div class="flex gap-3 pt-4 border-t border-gray-100">
                <button type="submit"
                        class="inline-flex justify-center items-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 15H16.5"/>
                    </svg>
                    Update
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
    const label = document.getElementById('preview-label');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            label.textContent = 'New Preview:';
            container.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection