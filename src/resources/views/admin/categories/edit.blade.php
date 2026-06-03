<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-bold fs-4 mb-0">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-body">

                <h1 class="h4 mb-4">Edit Category</h1>

                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Name --}}
                    <div class="mb-3">
                        <label class="form-label">Category Name</label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               value="{{ old('name', $category->name) }}"
                               required>
                    </div>

                    {{-- Parent Category --}}
                    <div class="mb-3">
                        <label class="form-label">Parent Category</label>

                        <select name="parent_id" class="form-select">
                            <option value="">-- Root Category --</option>

                            @foreach($categories as $item)
                                @if($item->id != $category->id)
                                    <option value="{{ $item->id }}"
                                        {{ old('parent_id', $category->parent_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endif
                            @endforeach

                        </select>
                    </div>

                    {{-- Description --}}
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description"
                                  class="form-control"
                                  rows="4">{{ old('description', $category->description) }}</textarea>
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="1"
                                {{ old('status', $category->status) == 1 ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="0"
                                {{ old('status', $category->status) == 0 ? 'selected' : '' }}>
                                Hidden
                            </option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Update Category
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                        Cancel
                    </button>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>