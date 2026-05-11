<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-bold fs-4 mb-0">
                {{ __('Edit Product') }}
            </h2>

            <a href="{{ route('admin.products') }}" class="btn btn-outline-secondary btn-sm">
                ← Back
            </a>
        </div>
    </x-slot>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="card border-0 shadow rounded-4">
                    <div class="card-body p-4">

                        <h4 class="fw-bold mb-4 text-primary">Update Product: {{ $product->name }}</h4>

                        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">

                                {{-- Category --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Category</label>
                                    <select name="category_id" class="form-select">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Brand --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Brand</label>
                                    <select name="brand_id" class="form-select">
                                        <option value="">Select Brand</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}"
                                                {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Name --}}
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Product Name</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ old('name', $product->name) }}">
                                </div>

                                {{-- Price --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Price</label>
                                    <input type="number" name="price" class="form-control"
                                        value="{{ old('price', $product->price) }}">
                                </div>

                                {{-- Stock --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Stock</label>
                                    <input type="number" name="stock" class="form-control"
                                        value="{{ old('stock', $product->stock) }}">
                                </div>

                                {{-- Description --}}
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Description</label>
                                    <textarea name="description" rows="4" class="form-control">{{ old('description', $product->description) }}</textarea>
                                </div>

                                {{-- Current Image --}}
                                @if ($product->image)
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Current Image</label>
                                        <div class="mb-2">
                                            <img src="{{ asset('layout/images/products/' . $product->image) }}" alt="{{ $product->name }}"
                                                width="120"
                                                class="rounded shadow-sm border">
                                        </div>
                                    </div>
                                @endif

                                {{-- Upload Image --}}
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Change Image</label>
                                    <input type="file" name="image" class="form-control">
                                </div>

                                {{-- Status --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Hidden</option>
                                    </select>
                                </div>

                            </div>

                            {{-- Button --}}
                            <div class="mt-4 d-flex gap-2">
                                <button type="submit" class="btn btn-primary px-4">
                                    Update Product
                                </button>

                                <a href="{{ route('admin.products') }}" class="btn btn-light border px-4">
                                    Cancel
                                </a>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>