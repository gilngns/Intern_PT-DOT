@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8">
                <h2>Post List</h2>
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createPostModal">
                    Create Post
                </button>
                <div class="list-group mb-4">
                    @foreach ($posts as $post)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h5>{{ $post->title }}</h5>
                                <p>{{ $post->content }}</p>
                                <small>Category: {{ $post->category->name }}</small>
                            </div>
                            <div>
                                <!-- Tombol Edit -->
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editPostModal{{ $post->id }}">
                                    Edit
                                </button>

                                <!-- Tombol Hapus dengan SweetAlert -->
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $post->id }})">
                                    Delete
                                </button>

                                <form id="delete-form-{{ $post->id }}" method="POST"
                                    action="{{ route('posts.destroy', $post->id) }}" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </div>

                        <!-- Modal untuk Edit Post -->
                        <div class="modal fade" id="editPostModal{{ $post->id }}" tabindex="-1"
                            aria-labelledby="editPostModalLabel{{ $post->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editPostModalLabel{{ $post->id }}">Edit Post</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('posts.update', $post->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label for="title" class="form-label">Post Title</label>
                                                <input type="text" class="form-control" id="title" name="title"
                                                    value="{{ $post->title }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="categories_id" class="form-label">Category</label>
                                                <select class="form-select" id="categories_id" name="categories_id" required>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            {{ $category->id == $post->categories_id ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="content" class="form-label">Content</label>
                                                <textarea class="form-control" id="content" name="content" rows="4" required>{{ $post->content }}</textarea>
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

    <!-- Modal untuk membuat post baru -->
    <div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="createPostModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createPostModalLabel">New Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('posts.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Post Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>

                        <div class="mb-3">
                            <label for="categories_id" class="form-label">Category</label>
                            <select class="form-select" id="categories_id" name="categories_id" required>
                                <option value="" disabled selected>Select a category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea class="form-control" id="content" name="content" rows="4" required></textarea>
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
        function confirmDelete(postId) {
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
                    document.getElementById('delete-form-' + postId).submit();
                }
            })
        }

        // Menampilkan pesan sukses dengan SweetAlert
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    </script>
@endsection
