@extends('layouts.base')
@section('title', 'Dashboard | User')
@section('content')
    <div class="content">
        <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center py-2 text-center text-md-start">
            <div class="flex-grow-1 mb-1 mb-md-0">
                <h1 class="h3 fw-bold mb-2">User Dashboard</h1>
                <h2 class="h6 fw-medium text-muted mb-0">Welcome <span class="fw-semibold">{{ auth()->user()->name }}</span>, find your next read below.</h2>
            </div>
            <div class="mt-3 mt-md-0 ms-md-3">
                <form action="{{ route('user.borrowings.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-alt" id="search" name="search" placeholder="Search books by title, author, synopsis...">
                        <button type="submit" class="btn btn-alt-primary">
                            <i class="fa fa-search opacity-50"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="content">
        <!-- Stats -->
        <div class="row items-push">
            <div class="col-sm-6 col-xxl-3">
                <div class="block block-rounded d-flex flex-column h-100 mb-0">
                    <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                        <dl class="mb-0">
                            <dt class="fs-3 fw-bold">{{ $books->where('status', 'available')->count() }}</dt>
                            <dd class="fs-sm fw-medium text-muted mb-0">Books Available</dd>
                        </dl>
                        <div class="item item-rounded-lg bg-body-light">
                            <i class="fa fa-book fs-3 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xxl-3">
                <div class="block block-rounded d-flex flex-column h-100 mb-0">
                    <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                        <dl class="mb-0">
                            <dt class="fs-3 fw-bold">{{ $borrowings->where('status', 'approved')->count() }}</dt>
                            <dd class="fs-sm fw-medium text-muted mb-0">Active Borrowings</dd>
                        </dl>
                        <div class="item item-rounded-lg bg-body-light">
                            <i class="fa fa-hand-holding fs-3 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xxl-3">
                <div class="block block-rounded d-flex flex-column h-100 mb-0">
                    <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                        <dl class="mb-0">
                            <dt class="fs-3 fw-bold">{{ $borrowings->where('status', 'pending')->count() }}</dt>
                            <dd class="fs-sm fw-medium text-muted mb-0">Pending Requests</dd>
                        </dl>
                        <div class="item item-rounded-lg bg-body-light">
                            <i class="fa fa-clock fs-3 text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Stats -->

        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Recommended Books</h3>
                <div class="block-options">
                    <a href="{{ route('user.borrowings.index') }}" class="btn btn-sm btn-alt-primary">View All</a>
                </div>
            </div>
            <div class="block-content">
                <div class="row items-push">
                    @foreach($books->where('status', 'available')->take(4) as $book)
                    <div class="col-md-3">
                        <div class="block block-rounded h-100 mb-0 bg-primary">
                            <div class="block-content p-0 overflow-hidden text-center" style="height: 200px;">
                                @if($book->image)
                                    <img class="img-fluid w-100 h-100 object-fit-cover" src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}">
                                @else
                                    <div class="bg-body-light d-flex align-items-center justify-content-center h-100 w-100">
                                        <i class="fa fa-book fa-3x text-muted"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="block-content block-content-full text-center">
                                <h5 class="mb-1 text-truncate">{{ $book->title }}</h5>
                                <p class="fs-sm text-white fw-semibold mb-0">Author: {{ $book->author }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
