<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-bold fs-4 mb-0">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container py-4">

        <div class="card shadow-sm">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h4 mb-0">Product List</h1>

                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                        Add Product
                    </a>
                </div>

                {{-- Search + Sort --}}
                <form method="GET" action="{{ route('admin.products') }}" class="row g-2 mb-4">
                    <div class="col-md-5 position-relative">
                        <input type="text" name="keyword" id="searchInput" class="form-control" autocomplete="off"
                            placeholder="Search product...">

                        <div id="suggestBox" class="list-group position-absolute w-100 shadow" style="z-index:999;">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <select name="sort" class="form-select">
                            <option value="">Sort By</option>
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Newest</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price Low →
                                High</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price High
                                → Low</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>A → Z</option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Z → A
                            </option>
                        </select>
                    </div>

                    <div class="col-md-1">
                        <select name="per_page" class="form-select" onchange="this.form.submit()">
                            <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                            <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                            <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </div>

                    <div class="col-md-3 d-grid">
                        <button class="btn btn-dark">Apply</button>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th width="80">No</th>
                                <th width="180">Image</th>
                                <th>Name</th>
                                <th width="140">Price</th>
                                <th width="50">Stock</th>
                                <th width="140">Status</th>
                                <th width="160">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($products as $index => $product)
                                <tr>
                                    <td>{{ $products->firstItem() + $index }}</td>

                                    <td>
                                        <a href="{{ route('admin.products.gallery', $product->id) }}">
                                            <img src="{{ asset('layout/images/products/' . $product->image) }}" width="100%"
                                                class="rounded border shadow-sm" style="cursor:pointer;">
                                        </a>
                                    </td>

                                    <td>
                                        <a href="{{ route('admin.products.edit', $product->id) }}"
                                            class="text-decoration-none fw-semibold text-dark">
                                            {{ $product->name }}
                                        </a>
                                    </td>

                                    <td>
                                        {{ number_format($product->price, 0, ',', '.') }}₫
                                    </td>
                                    <td>
                                        {{ $product->stock }}
                                    </td>

                                    <td>
                                        @if ($product->status == 1)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('admin.products.edit', $product->id) }}"
                                            class="btn btn-sm btn-warning">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.products.delete', $product->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" onclick="return confirm('Delete product?')"
                                                class="btn btn-sm btn-danger">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        No products found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-3">
                    {{ $products->appends(request()->query())->links() }}
                </div>

            </div>
        </div>

    </div>
</x-app-layout>