@extends('layouts.base')
@section('title', 'User | My Borrowings')
@section('content')
    <div class="content">
        <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center py-2 text-center text-md-start">
            <div class="flex-grow-1 mb-1 mb-md-0">
                <h1 class="h3 fw-bold mb-2">My Active Borrowings</h1>
                <h2 class="h6 fw-medium text-muted mb-0">List of books you currently have. Request to return them below.</h2>
            </div>
            <div class="mt-3 mt-md-0 ms-md-3">
                <a class="btn btn-sm btn-alt-secondary" href="{{ route('users.dashboard') }}">
                    <i class="fa fa-arrow-left opacity-50"></i> Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <div class="content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row items-push">
            @forelse($borrowings as $borrowing)
            <div class="col-md-4 col-xl-3">
                <div class="block block-rounded h-100 mb-0 d-flex flex-column">
                    <div class="block-content p-0 overflow-hidden text-center" style="height: 250px;">
                        @if($borrowing->book->image)
                            <img class="img-fluid w-100 h-100 object-fit-cover" src="{{ asset('storage/' . $borrowing->book->image) }}" alt="{{ $borrowing->book->title }}">
                        @else
                            <div class="bg-body-light d-flex align-items-center justify-content-center h-100 w-100">
                                <i class="fa fa-book fa-4x text-muted"></i>
                            </div>
                        @endif
                    </div>
                    <div class="block-content flex-grow-1">
                        <h4 class="mb-1 text-truncate" title="{{ $borrowing->book->title }}">{{ $borrowing->book->title }}</h4>
                        <p class="fs-sm text-muted mb-1">Borrowed on: {{ date('d M Y', strtotime($borrowing->borrow_date)) }}</p>
                        <p class="fs-sm text-muted">Must return by: {{ date('d M Y', strtotime($borrowing->return_date)) }}</p>
                    </div>
                    <div class="block-content block-content-full bg-body-light text-center mt-auto">
                        <button type="button" class="btn btn-sm btn-alt-success w-100" data-bs-toggle="modal" data-bs-target="#modal-return-{{ $borrowing->id }}">
                            <i class="fa fa-undo me-1"></i> Kembalikan Buku
                        </button>
                    </div>
                </div>
            </div>

            <!-- Return Modal -->
            <div class="modal fade" id="modal-return-{{ $borrowing->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-return-{{ $borrowing->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="block block-rounded block-transparent mb-0">
                            <div class="block-header block-header-default">
                                <h3 class="block-title">Return Book: {{ $borrowing->book->title }}</h3>
                                <div class="block-options">
                                    <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="fa fa-fw fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="block-content">
                                <form action="{{ route('user.reversions.store', $borrowing->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="form-label text-white" for="notes-{{ $borrowing->id }}">Return Notes</label>
                                        <textarea class="form-control" id="notes-{{ $borrowing->id }}" name="notes" rows="4" placeholder="Explain the condition of the book.." required></textarea>
                                    </div>
                                    <div class="block-content block-content-full text-end bg-body">
                                        <button type="button" class="btn btn-sm btn-alt-secondary me-1" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-sm btn-primary">Submit Return Request</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Return Modal -->

            @empty
            <div class="col-12">
                <div class="alert alert-info text-center">You have no active borrowings.</div>
            </div>
            @endforelse
        </div>
    </div>
@endsection
