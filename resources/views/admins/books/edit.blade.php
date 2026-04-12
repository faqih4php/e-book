@extends('layouts.base')
@section('title', 'Books | Edit')
@section('css')
    <link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/ion-rangeslider/css/ion.rangeSlider.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/flatpickr/flatpickr.min.css') }}">

    <!-- OneUI framework -->
    <link rel="stylesheet" id="css-main" href="{{ asset('css/oneui.min.css') }}">
@endsection
@section('content')
    <div class="main-container">
        <div class="content">
            <div class="block block-rounded col-xl-8">
                <div class="block-header block-header-default py-3 ps-4 mb-4">
                    <h2 class="block-title fs-lg">Edit Book</h2>
                </div>
                <div class="block-content block-content-full">
                    <div class="col-lg-8 col-xl-11 mx-auto">
                        <form id="form-edit-books" action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label for="title" class="form-label">Title</label>
                                <div class="input-group">
                                    <span class="input-group-text form-control-lg form-control-alt me-1">
                                        <i class="far fa-user"></i>
                                    </span>
                                    <input type="text" class="form-control form-control-lg form-control-alt @error('title') is-invalid @enderror"
                                        id="title" name="title" placeholder="Book Title" aria-invalid="true" value="{{ old('title', $book->title) }}">
                                    @error('title')
                                        <div id="title-error" class="invalid-feedback animate fadeIn">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="author" class="form-label">Author</label>
                                <div class="input-group">
                                    <span class="input-group-text form-control-lg form-control-alt me-1">
                                        <i class="far fa-envelope"></i>
                                    </span>
                                    <input type="text" class="form-control form-control-lg form-control-alt @error('author') is-invalid @enderror"
                                        id="author" name="author" placeholder="Author Name" aria-invalid="true" value="{{ old('author', $book->author) }}">
                                    @error('author')
                                        <div id="author-error" class="invalid-feedback animate fadeIn">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="publication_year">Publication Year</label>
                                <div class="input-group">
                                    <span class="input-group-text form-control-lg form-control-alt me-1">
                                        <i class="far fa-calendar"></i>
                                    </span>
                                    <input type="text" class="js-flatpickr form-control form-control-lg form-control-alt @error('publication_year') is-invalid @enderror"
                                        id="publication_year" name="publication_year" placeholder="Month Day, Year"
                                        data-alt-input="true" data-date-format="Y-m-d" data-alt-format="F j, Y"
                                        aria-invalid="true" value="{{ old('publication_year', $book->publication_year . '-01-01') }}">
                                </div>
                                @error('publication_year')
                                    <div id="publication_year-error" class="invalid-feedback animate fadeIn d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="page">Pages</label>
                                <div class="input-group">
                                    <span class="input-group-text form-control-lg form-control-alt me-1">
                                        <i class="far fa-file"></i>
                                    </span>
                                    <input type="text" class="form-control form-control-lg form-control-alt @error('page') is-invalid @enderror"
                                        id="page" name="page" placeholder="Number of pages" aria-invalid="true" value="{{ old('page', $book->page) }}">
                                </div>
                                @error('page')
                                    <div id="page-error" class="invalid-feedback animate fadeIn d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="stock">Stock</label>
                                <div class="input-group">
                                    <span class="input-group-text form-control-lg form-control-alt me-1">
                                        <i class="far fa-copy"></i>
                                    </span>
                                    <input type="number" class="form-control form-control-lg form-control-alt @error('stock') is-invalid @enderror"
                                        id="stock" name="stock" placeholder="Number of stock" min="0" value="{{ old('stock', $book->stock) }}">
                                </div>
                                @error('stock')
                                    <div id="stock-error" class="invalid-feedback animate fadeIn d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="synopsis" class="form-label">Synopsis</label>
                                <div class="input-group">
                                    <span class="input-group-text form-control-lg form-control-alt me-1">
                                        <i class="far fa-comment-dots"></i>
                                    </span>
                                    <textarea class="form-control form-control-lg form-control-alt @error('synopsis') is-invalid @enderror"
                                        id="synopsis" name="synopsis" placeholder="Book Synopsis" rows="4" aria-invalid="true">{{ old('synopsis', $book->synopsis) }}</textarea>
                                    @error('synopsis')
                                        <div id="synopsis-error" class="invalid-feedback animate fadeIn">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-5">
                                <label class="form-label" for="image">Book Image (Leave empty to keep current)</label>
                                
                                <div class="mb-2">
                                    @if ($book->image)
                                        <img src="{{ Storage::url($book->image) }}" alt="Current Image" class="img-fluid" style="max-height: 200px;">
                                    @else
                                        <p class="text-muted">No image available</p>
                                    @endif
                                </div>

                                <div class="input-group">
                                    <span class="input-group-text form-control-lg form-control-alt me-1">
                                        <i class="far fa-image"></i>
                                    </span>
                                    <input type="file" class="form-control form-control-lg form-control-alt @error('image') is-invalid @enderror"
                                        id="image" name="image" accept="image/*" aria-invalid="true">
                                </div>
                                @error('image')
                                    <div id="image-error" class="invalid-feedback animate fadeIn d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-5">
                                <button type="submit" class="btn btn-primary" class="">Update Book</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('js/oneui.app.min.js') }}"></script>

    <!-- jQuery (required for BS Datepicker + BS Maxlength + Select2 + Masked Inputs + Ion Range Slider plugins) -->
    <script src="{{ asset('js/lib/jquery.min.js') }}"></script>

    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
    <script src="{{ asset('js/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
    <script>
        One.helpersOnLoad(['js-flatpickr', 'jq-datepicker', 'jq-maxlength', 'jq-select2', 'jq-masked-inputs',
            'jq-rangeslider'
        ]);
    </script>
@endsection
