<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-bold fs-4 mb-0">
            Product Gallery
        </h2>
    </x-slot>

    <div class="container py-4">

        <div class="card shadow-sm">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="mb-1">{{ $product->name }}</h4>
                        <small class="text-muted">Manage product images</small>
                    </div>

                    <a href="{{ route('admin.products') }}" class="btn btn-secondary">
                        Back
                    </a>
                </div>

                {{-- Main Image --}}
                <div class="mb-5">
                    <h5 class="fw-bold mb-3">Main Image</h5>

                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <img src="{{ asset('layout/images/products/' . $product->image) }}"
                                class="img-fluid rounded shadow border">
                        </div>

                        <div class="col-md-8">
                            <form action="{{ route('admin.products.gallery.add', $product->id) }}" method="GET"
                                enctype="multipart/form-data">

                                <label class="form-label">Change Main Image</label>
                                <input type="file" name="image" class="form-control mb-3">

                                <button class="btn btn-primary">
                                    Update Main Image
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Gallery Images --}}
                <div>
                    <h5 class="fw-bold mb-3">Gallery Images</h5>

                    <form action="{{ route('admin.products.gallery.add', $product->id) }}" method="POST"
                        enctype="multipart/form-data" class="mb-4">
                        @csrf

                        <label class="form-label">Add Gallery Images</label>

                        <input type="file" name="images[]" multiple class="form-control mb-3">

                        <button class="btn btn-success">
                            Upload Gallery
                        </button>
                    </form>
                    <div class="row g-3">
                        @forelse($product->images as $gallery)
                            <div class="col-md-3">
                                <div class="card h-100 shadow-sm">

                                    <img src="{{ asset('layout/images/products/' . $gallery->image) }}" class="card-img-top"
                                        style="height:220px; object-fit:cover;">

                                    <div class="card-body text-center">
                                        <form
                                            action="{{ route('admin.products.gallery.delete', [$product->id, $gallery->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-danger w-100"
                                                onclick="return confirm('Delete image?')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center text-muted">
                                No gallery images
                            </div>
                        @endforelse
                    </div>

                </div>

            </div>
        </div>

    </div>
</x-app-layout>