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
                    <h1 class="h4 mb-0">Category List</h1>

                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                        Add Category
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th width="80">No</th>
                                <th>Name</th>
                                <th width="250">Parent Category</th>
                                <th width="140">Status</th>
                                <th width="170">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $no = 1;

                                function renderCategory($categories, $parentId = null, $level = 0, &$no = 1)
                                {
                                    foreach ($categories->where('parent_id', $parentId) as $category) {
                                        echo '<tr>';

                                        echo '<td>' . $no++ . '</td>';

                                        echo '<td>
                                            <a href="' . route('admin.categories.edit', $category->id) . '"
                                            class="text-decoration-none text-dark fw-semibold d-inline-block"
                                            style="padding-left:' . ($level * 25) . 'px;">';

                                        if ($level > 0) {
                                            echo '└─ ';
                                        }

                                        echo $category->name . '</a></td>';

                                        echo '<td>' . ($category->parent?->name ?? '--- Root Category ---') . '</td>';

                                        echo '<td><span class="badge bg-success">Active</span></td>';

                                        echo '<td>
                                            <a href="' . route('admin.categories.edit', $category->id) . '"
                                            class="btn btn-sm btn-warning me-1">Edit</a>

                                            <form action="' . route('admin.categories.delete', $category->id) . '"
                                                method="POST"
                                                class="d-inline">
                                                ' . csrf_field() . '
                                                <input type="hidden" name="_method" value="DELETE">

                                                <button type="submit"
                                                    onclick=""
                                                    class="btn btn-sm btn-danger">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>';

                                        echo '</tr>';

                                        renderCategory($categories, $category->id, $level + 1, $no);
                                    }
                                }
                            @endphp

                            @if ($categories->count())
                                {!! renderCategory($categories, null, 0, $no) !!}
                            @else
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        No categories found
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
</x-app-layout>