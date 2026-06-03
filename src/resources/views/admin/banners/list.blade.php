<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-bold fs-4 mb-0">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container py-4">

        <div class="card shadow-sm">
            <div class="card-body">

                {{-- HEADER --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h4 mb-0">Banner List</h1>

                    <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">
                        + Add Banner
                    </a>
                </div>

                {{-- TABLE --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-dark">
                            <tr>
                                <th width="60">No</th>
                                <th>Title</th>
                                <th width="200">Image</th>
                                <th width="120">Type</th>
                                <th width="120">Device</th>
                                <th width="120">Status</th>
                                <!-- <th width="100">Position</th> -->
                                <th width="180">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($banners as $key => $banner)
                                <tr>

                                    {{-- No --}}
                                    <td>{{ $key + 1 }}</td>

                                    {{-- Title + link --}}
                                    <td>
                                        <div class="fw-semibold">{{ $banner->title }}</div>

                                        @if($banner->link_url)
                                            <a href="{{ $banner->link_url }}" target="_blank" class="small text-primary">
                                                Open link
                                            </a>
                                        @endif
                                    </td>

                                    {{-- Image --}}
                                    <td>
                                        <img src="{{ asset('layout/images/banners/' . $banner->image_url) }}"
                                             alt="{{ $banner->title }}"
                                             style="width: 160px; height: 70px; object-fit: cover; border-radius: 6px;">
                                    </td>

                                    {{-- Type --}}
                                    <td>
                                        <span class="badge bg-info text-dark">
                                            {{ $banner->type }}
                                        </span>
                                    </td>

                                    {{-- Device --}}
                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ $banner->device ?? 'all' }}
                                        </span>
                                    </td>

                                    {{-- Status --}}
                                    <td>
                                        @if($banner->status == 1)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>

                                    {{-- Position --}}
                                    <!-- <td>
                                        {{ $banner->position }}
                                    </td> -->

                                    {{-- Actions --}}
                                    <td class="d-flex gap-1">

                                        <a href="{{ route('admin.banners.edit', $banner->id) }}"
                                           class="btn btn-sm btn-warning">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.banners.delete', $banner->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Delete this banner?')">

                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-sm btn-danger">
                                                Delete
                                            </button>
                                        </form>

                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">
                                        No banners found
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