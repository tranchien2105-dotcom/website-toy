<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-bold fs-4 mb-0">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-body">

                <h1 class="h4 mb-4">Add New Product</h1>

                <form action="{{ route('admin.products.add') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- hiển thị lỗi --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Category --}}
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">-- Select Category --</option>

                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    {{-- Brand --}}
                    <div class="mb-3">
                        <label class="form-label">Brand</label>
                        <select name="brand_id" class="form-select" required>
                            <option value="">-- Select Brand --</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Name --}}
                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" 
                               name="name" 
                               class="form-control"
                               value="{{ old('name') }}"
                               required>
                    </div>

                    {{-- Price --}}
                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" 
                               name="price" 
                               class="form-control"
                               value="{{ old('price') }}"
                               required>
                    </div>

                    {{-- Stock --}}
                    <div class="mb-3">
                        <label class="form-label">Stock</label>
                        <input type="number" 
                               name="stock" 
                               class="form-control"
                               value="{{ old('stock', 0) }}"
                               required>
                    </div>

                    {{-- Description --}}
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" 
                                  class="form-control" 
                                  rows="4">{{ old('description') }}</textarea>
                    </div>

                    {{-- Image --}}
                    <div class="mb-3">
                        <label class="form-label">Product Image</label>
                        <input type="file" 
                               name="image" 
                               class="form-control">
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="1">Active</option>
                            <option value="0">Hidden</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Add Product
                    </button>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>