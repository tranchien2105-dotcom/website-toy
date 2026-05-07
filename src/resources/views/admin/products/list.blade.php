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

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th width="80">No</th>
                                <th width="180">Image</th>
                                <th>Name</th>
                                <th width="140">Price</th>
                                <th width="140">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($products as $index => $product)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <img src="{{ asset('layout/images/products/' . $product->image) }}" alt="{{ $product->name }}" width="100%">
                                    </td>

                                    <td>{{ $product->name }}</td>

                                    <td>
                                        {{ number_format($product->price, 0, ',', '.') }}₫
                                    </td>

                                    <td>
                                        <a href="" class="btn btn-sm btn-warning">
                                            Edit
                                        </a>

                                        <form action="" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                onclick="return confirm('Delete product?')"
                                                class="btn btn-sm btn-danger">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        No products found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

            </div>
        </div>

    </div>
</x-app-layout>