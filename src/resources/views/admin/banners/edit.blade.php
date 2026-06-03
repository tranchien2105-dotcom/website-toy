<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-bold fs-4 mb-0">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-body">

                <h1 class="h4 mb-4">Edit Banner</h1>

                <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Title --}}
                    <div class="mb-3">
                        <label class="form-label">Banner Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $banner->title) }}"
                            required>
                    </div>

                    {{-- Banner Image --}}
                    <div class="mb-3">
                        <label class="form-label">Banner Image</label>

                        <input type="file" name="image" class="form-control" accept="image/*"
                            onchange="previewBanner(event)">

                        <small class="text-muted">
                            Leave blank if you don't want to change image
                        </small>

                        <div class="mt-3">
                            <img id="preview-image"
                                src="{{ $banner->image_url ? asset('layout/images/banners/' . $banner->image_url) : asset('layout/images/no-image.png') }}"
                                style="display:block; width:220px; height:100px; object-fit:cover; border-radius:8px; border:1px solid #ddd;">
                        </div>
                    </div>

                    {{-- Link URL --}}
                    <div class="mb-3">
                        <label class="form-label">Link URL</label>
                        <input type="text" name="link_url" class="form-control"
                            value="{{ old('link_url', $banner->link_url) }}" placeholder="https://example.com">
                    </div>

                    <div class="row">

                        {{-- Type --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Type</label>

                            <select name="type" class="form-select">
                                <option value="home" {{ old('type', $banner->type) == 'home' ? 'selected' : '' }}>Home
                                </option>
                                <option value="popup" {{ old('type', $banner->type) == 'popup' ? 'selected' : '' }}>Popup
                                </option>
                                <option value="sidebar" {{ old('type', $banner->type) == 'sidebar' ? 'selected' : '' }}>
                                    Sidebar</option>
                                <option value="promo" {{ old('type', $banner->type) == 'promo' ? 'selected' : '' }}>Promo
                                </option>
                            </select>
                        </div>

                        {{-- Device --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Device</label>

                            <select name="device" class="form-select">
                                <option value="all" {{ old('device', $banner->device) == 'all' ? 'selected' : '' }}>All
                                </option>
                                <option value="desktop" {{ old('device', $banner->device) == 'desktop' ? 'selected' : '' }}>Desktop</option>
                                <option value="mobile" {{ old('device', $banner->device) == 'mobile' ? 'selected' : '' }}>
                                    Mobile</option>
                            </select>
                        </div>

                        {{-- Position --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Position</label>

                            <input type="number" name="position" class="form-control"
                                value="{{ old('position', $banner->position) }}">
                        </div>

                    </div>

                    {{-- Start / End --}}
                    {{-- Start / End --}}
                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Start At</label>
                            <input type="datetime-local" name="start_at" class="form-control"
                                value="{{ old('start_at', \Carbon\Carbon::parse($banner->start_at)->format('Y-m-d\TH:i')) }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">End At</label>
                            <input type="datetime-local" name="end_at" class="form-control"
                                value="{{ old('end_at', \Carbon\Carbon::parse($banner->end_at)->format('Y-m-d\TH:i')) }}">
                        </div>

                    </div>

                    {{-- Description --}}
                    <div class="mb-3">
                        <label class="form-label">Description</label>

                        <textarea name="description" class="form-control"
                            rows="3">{{ old('description', $banner->description) }}</textarea>
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <label class="form-label">Status</label>

                        <select name="status" class="form-select">
                            <option value="1" {{ old('status', $banner->status) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status', $banner->status) == 0 ? 'selected' : '' }}>Inactive
                            </option>
                        </select>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            Update Banner
                        </button>

                        <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                            Cancel
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <script>
        function previewBanner(event) {
            let file = event.target.files[0];
            let preview = document.getElementById('preview-image');

            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
            }
        }
    </script>
</x-app-layout>