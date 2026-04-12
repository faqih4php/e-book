@extends('layouts.base')
@section('title', 'Books | View Details')
@section('css')
    <!-- OneUI framework -->
    <link rel="stylesheet" id="css-main" href="{{ asset('css/oneui.min.css') }}">
@endsection
@section('content')
    <div class="main-container">
        <!-- Hero -->
        <div class="bg-image" style="background-image: url('{{ asset('media/photos/photo21@2x.jpg') }}');">
            <div class="bg-black-75">
                <div class="content content-top content-full text-center">
                    <div class="py-3">
                        <h1 class="h2 fw-bold text-white mb-2">
                            Book Details
                        </h1>
                        <h2 class="h5 fw-medium text-white-75 mb-0">
                            Discover more about this book before borrowing.
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Hero -->

        <!-- Page Content -->
        <div class="content content-boxed">
            <div class="row items-push">
                <div class="col-md-5 col-xl-4 text-center">
                    <!-- Book Cover -->
                    <div class="block block-rounded h-100 mb-0">
                        <div class="block-content p-4">
                            @if ($book->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($book->image))
                                <img class="img-fluid rounded shadow-lg" src="{{ asset('storage/' . $book->image) }}"
                                    alt="{{ $book->title }}">
                            @else
                                <div class="bg-body-light d-flex align-items-center justify-content-center h-100 w-100 rounded"
                                    style="min-height: 350px;">
                                    <i class="fa fa-book fa-6x text-muted"></i>
                                </div>
                            @endif
                            <div class="mt-4">
                                @if ($book->status === 'available')
                                    <span class="badge bg-success p-2 fs-sm text-uppercase"><i
                                            class="fa fa-check-circle me-1"></i> Available</span>
                                @else
                                    <span class="badge bg-danger p-2 fs-sm text-uppercase"><i
                                            class="fa fa-times-circle me-1"></i> Borrowed</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- END Book Cover -->
                </div>
                <div class="col-md-7 col-xl-8">
                    <!-- Book Information -->
                    <div class="block block-rounded h-100 mb-0">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Information</h3>
                            <div class="block-options">
                                <a href="{{ url()->previous() }}" class="btn btn-sm btn-alt-secondary">
                                    <i class="fa fa-arrow-left me-1"></i> Back
                                </a>
                            </div>
                        </div>
                        <div class="block-content block-content-full fs-sm">
                            <table class="table table-borderless table-striped table-vcenter">
                                <tbody>
                                    <tr>
                                        <td class="fw-semibold" style="width: 30%;">Title</td>
                                        <td><span class="fs-base fw-bold">{{ $book->title }}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Author</td>
                                        <td>{{ $book->author }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Publication Year</td>
                                        <td>{{ $book->publication_year ?? 'No publication year available' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Pages</td>
                                        <td>{{ $book->page ?? 'No page count available' }} Pages</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Synopsis</td>
                                        <td>{{ $book->synopsis ?? 'No synopsis available' }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            @if (auth()->user()->role == 'user')
                                <div class="mt-5 border-top pt-4 text-end">
                                    @if ($book->status === 'available')
                                        <a href="{{ route('user.borrowings.create', ['book_id' => $book->id]) }}"
                                            class="btn btn-lg btn-alt-primary">
                                            <i class="fa fa-hand-holding me-1"></i> Borrow This Book
                                        </a>
                                    @else
                                        <button type="button" class="btn btn-lg btn-alt-danger" disabled>
                                            <i class="fa fa-ban me-1"></i> Currently Unavailable
                                        </button>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- END Book Information -->
                </div>
            </div>
        </div>
        <!-- END Page Content -->
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/oneui.app.min.js') }}"></script>
@endsection
