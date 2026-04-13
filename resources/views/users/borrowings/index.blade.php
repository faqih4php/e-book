@extends('layouts.base')
@section('title', 'User | Borrow Books')
@section('content')
    <div class="content">
        <div
            class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center py-2 text-center text-md-start">
            <div class="flex-grow-1 mb-1 mb-md-0">
                <h1 class="h3 fw-bold mb-2">Available Books</h1>
                <h2 class="h6 fw-medium text-muted mb-0">
                    @if (isset($query) && $query)
                        Search results for: <span class="fw-semibold text-primary">"{{ $query }}"</span>
                    @else
                        Browse and request to borrow books.
                    @endif
                </h2>
            </div>
            <div class="mt-3 mt-md-0 ms-md-3 d-flex align-items-center">
                <form action="{{ route('user.borrowings.index') }}" method="GET" class="me-3">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control form-control-alt" id="search" name="search"
                            placeholder="Search books..." value="{{ $query ?? '' }}">
                        <button type="submit" class="btn btn-alt-primary">
                            <i class="fa fa-search w-100"></i>
                        </button>
                    </div>
                </form>
                <a class="btn btn-sm btn-alt-secondary" href="{{ route('users.dashboard') }}">
                    <i class="fa fa-arrow-left opacity-50"></i> Back
                </a>
            </div>
        </div>
    </div>

    <div class="content">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row items-push">
            @forelse($books as $book)
                <div class="col-md-4 col-xl-3">
                    <div class="block block-rounded h-100 mb-0 d-flex flex-column">
                        <div class="block-content p-0 overflow-hidden text-center" style="height: 250px;">
                            @if ($book->image)
                                <img class="img-fluid w-100 h-100 object-fit-cover"
                                    src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}"
                                    onerror="this.onerror=null;this.src='{{ asset('media/various/placeholder.png') }}';">
                            @else
                                <div class="bg-body-light d-flex align-items-center justify-content-center h-100 w-100">
                                    <i class="fa fa-book fa-4x text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="block-content flex-grow-1">
                            <h4 class="mb-1 text-truncate" title="{{ $book->title }}">{{ $book->title }}</h4>
                            <p class="fs-sm fw-medium text-muted mb-1">{{ $book->author }} ({{ $book->publication_year }})
                            </p>
                            <p class="fs-sm text-muted mb-1">{{ $book->page }} pages</p>
                            <p class="fs-sm text-muted mb-2"><strong>Stock:</strong> {{ $book->stock }}</p>
                            @if ($book->synopsis)
                                <p class="fs-sm text-muted text-break"
                                    style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;"
                                    title="{{ $book->synopsis }}">
                                    {{ $book->synopsis }}
                                </p>
                            @endif
                        </div>
                        <div class="block-content block-content-full bg-body-light text-center mt-auto">
                            @if ($book->stock > 0)
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('user.borrowings.create', ['book_id' => $book->id]) }}"
                                        class="btn btn-sm btn-alt-primary w-75">
                                        <i class="fa fa-plus me-1"></i> Borrow this book
                                    </a>
                                    <button type="button" class="btn btn-sm btn-alt-primary js-bs-tooltip-enabled"
                                        data-bs-toggle="tooltip" aria-label="View" data-bs-original-title="View">
                                        <a href="{{ route('books.show.user', $book->id) }}"
                                            class="text-primary text-decoration-none">
                                            <i class="fa fa-fw fa-eye"></i>
                                        </a>
                                    </button>
                                </div>
                            @else
                                <button type="button" class="btn btn-sm btn-alt-danger w-100" disabled>
                                    <i class="fa fa-times me-1"></i> Out of Stock
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">No books available at the moment.</div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
