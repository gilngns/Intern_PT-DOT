@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8">
                <h2>Category List</h2>
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                    data-bs-target="#createCategoryModal">
                    Create Category
                </button>
                <div class="list-group mb-4">
                    @foreach ($categories as $category)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <h5>{{ $category->name }}</h5>
                            <div>
                                <!-- Tombol Edit -->
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editCategoryModal{{ $category->id }}">
                                    Edit
                                </button>

                                <!-- Tombol Hapus dengan SweetAlert -->
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $category->id }})">
                                    Delete
                                </button>

                                <form id="delete-form-{{ $category->id }}" method="POST"
                                    action="{{ route('categories.destroy', $category->id) }}" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </div>

                        <!-- Modal untuk Edit Kategori -->
                        <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1"
                            aria-labelledby="editCategoryModalLabel{{ $category->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editCategoryModalLabel{{ $category->id }}">Edit Category
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('categories.update', $category->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Category Name</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    value="{{ $category->name }}" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>

    <!-- Modal untuk membuat kategori baru -->
    <div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createCategoryModalLabel">New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('categories.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script untuk SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Konfirmasi Hapus dengan SweetAlert
        function confirmDelete(categoryId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + categoryId).submit();
                }
            })
        }
    </script>

    <!-- Menampilkan pesan sukses dengan SweetAlert -->
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif
@endsection
