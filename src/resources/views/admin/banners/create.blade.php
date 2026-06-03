<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-bold fs-4 mb-0">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-body">

                <h1 class="h4 mb-4">Add New Banner</h1>

                <form action="{{ route('admin.banners.add') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Title --}}
                    <div class="mb-3">
                        <label class="form-label">Banner Title</label>
                        <input type="text"
                               name="title"
                               class="form-control"
                               value="{{ old('title') }}"
                               required>
                    </div>

                    {{-- Upload Image --}}
                    <div class="mb-3">
                        <label class="form-label">Banner Image</label>

                        <input type="file"
                               name="image"
                               class="form-control"
                               accept="image/*"
                               onchange="previewBanner(event)"
                               required>

                        <small class="text-muted">
                            JPG, PNG, WEBP...
                        </small>

                        <div class="mt-3">
                            <img id="preview-image"
                                 src=""
                                 style="display:none; width:220px; height:100px; object-fit:cover; border-radius:8px; border:1px solid #ddd;">
                        </div>
                    </div>

                    {{-- Link URL --}}
                    <div class="mb-3">
                        <label class="form-label">Link URL</label>
                        <input type="text"
                               name="link_url"
                               class="form-control"
                               value="{{ old('link_url') }}"
                               placeholder="https://example.com">
                    </div>

                    <div class="row">

                        {{-- Type --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Type</label>
                            <select name="type" class="form-select">
                                <option value="home">Home</option>
                                <option value="popup">Popup</option>
                                <option value="sidebar">Sidebar</option>
                                <option value="promo">Promo</option>
                            </select>
                        </div>

                        {{-- Device --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Device</label>
                            <select name="device" class="form-select">
                                <option value="all">All</option>
                                <option value="desktop">Desktop</option>
                                <option value="mobile">Mobile</option>
                            </select>
                        </div>

                        {{-- Position --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Position</label>
                            <input type="number"
                                   name="position"
                                   class="form-control"
                                   value="{{ old('position', 0) }}">
                        </div>

                    </div>

                    {{-- Start / End --}}
                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Start At</label>
                            <input type="date"
                                   name="start_at"
                                   class="form-control"
                                   value="{{ old('start_at') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">End At</label>
                            <input type="date"
                                   name="end_at"
                                   class="form-control"
                                   value="{{ old('end_at') }}">
                        </div>

                    </div>

                    {{-- Description --}}
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description"
                                  class="form-control"
                                  rows="3">{{ old('description') }}</textarea>
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            Save Banner
                        </button>

                        <button type="button"
                                class="btn btn-secondary"
                                onclick="window.history.back()">
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