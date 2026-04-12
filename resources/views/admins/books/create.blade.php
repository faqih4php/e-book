@extends('layouts.base')
@section('title', 'Books | Create')
@section('css')
    <link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/ion-rangeslider/css/ion.rangeSlider.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/dropzone/min/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/flatpickr/flatpickr.min.css') }}">

    <!-- OneUI framework -->
    <link rel="stylesheet" id="css-main" href="{{ asset('css/oneui.min.css') }}">
@endsection
@section('content')
    <div class="main-container">
        <div class="content">
            <div class="block block-rounded col-xl-8">
                <div class="block-header block-header-default py-3 ps-4 mb-4">
                    <h2 class="block-title fs-lg">Create Books</h2>
                </div>
                <div class="block-content block-content-full">
                    <div class="col-lg-8 col-xl-11 mx-auto">
                        <form id="form-create-books" action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label for="title" class="form-label">Title</label>
                                <div class="input-group">
                                    <span class="input-group-text form-control-lg form-control-alt me-1">
                                        <i class="far fa-user"></i>
                                    </span>
                                    <input type="text" class="form-control form-control-lg form-control-alt"
                                        id="title" name="title" placeholder="Book Title" aria-invalid="true">
                                    <div id="title-error" class="invalid-feedback animate fadeIn">
                                        Please enter the title
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="author" class="form-label">Author</label>
                                <div class="input-group">
                                    <span class="input-group-text form-control-lg form-control-alt me-1">
                                        <i class="far fa-envelope"></i>
                                    </span>
                                    <input type="text" class="form-control form-control-lg form-control-alt"
                                        id="author" name="author" placeholder="Author Name" aria-invalid="true">
                                    <div id="author-error" class="invalid-feedback animate fadeIn">
                                        Please enter the author
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="publication_year">Publication Year</label>
                                <div class="input-group">
                                    <span class="input-group-text form-control-lg form-control-alt me-1">
                                        <i class="far fa-calendar"></i>
                                    </span>
                                    <input type="text" class="js-flatpickr form-control form-control-lg form-control-alt"
                                        id="publication_year" name="publication_year" placeholder="Month Day, Year"
                                        data-alt-input="true" data-date-format="Y-m-d" data-alt-format="F j, Y"
                                        aria-invalid="true">
                                </div>
                                <div id="publication_year-error" class="invalid-feedback animate fadeIn">
                                    Please enter the publication year
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="page">Pages</label>
                                <div class="input-group">
                                    <span class="input-group-text form-control-lg form-control-alt me-1">
                                        <i class="far fa-file"></i>
                                    </span>
                                    <input type="text" class="form-control form-control-lg form-control-alt"
                                        id="page" name="page" placeholder="Number of pages" aria-invalid="true">
                                </div>
                                <div id="page-error" class="invalid-feedback animate fadeIn">
                                    Please enter the number of pages
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="stock">Stock</label>
                                <div class="input-group">
                                    <span class="input-group-text form-control-lg form-control-alt me-1">
                                        <i class="far fa-copy"></i>
                                    </span>
                                    <input type="number" class="form-control form-control-lg form-control-alt @error('stock') is-invalid @enderror"
                                        id="stock" name="stock" placeholder="Number of stock" min="0" value="{{ old('stock', 0) }}">
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
                                    <textarea class="form-control form-control-lg form-control-alt"
                                        id="synopsis" name="synopsis" placeholder="Book Synopsis" rows="4" aria-invalid="true"></textarea>
                                </div>
                            </div>
                            <div class="mb-5">
                                <label class="form-label" for="image">Book Image</label>
                                <div class="input-group">
                                    <span class="input-group-text form-control-lg form-control-alt me-1">
                                        <i class="far fa-image"></i>
                                    </span>
                                    <input type="file" class="form-control form-control-lg form-control-alt"
                                        id="image" name="image" accept="image/*" aria-invalid="true">
                                </div>
                                <div id="image-error" class="invalid-feedback animate fadeIn d-none">
                                    Please select a book image
                                </div>
                            </div>
                            <div class="mb-5">
                                <button type="submit" class="btn btn-primary" class="">Create Book</button>
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
    <script src="{{ asset('js/plugins/dropzone/min/dropzone.min.js') }}"></script>
    <script>
        One.helpersOnLoad(['js-flatpickr', 'jq-datepicker', 'jq-maxlength', 'jq-select2', 'jq-masked-inputs',
            'jq-rangeslider'
        ]);
        
    </script>
@endsection
