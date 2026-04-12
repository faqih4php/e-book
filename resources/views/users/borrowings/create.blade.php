@extends('layouts.base')
@section('title', 'User | Borrow Book')
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
    <div class="content">
        <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center py-2 text-center text-md-start">
            <div class="flex-grow-1 mb-1 mb-md-0">
                <h1 class="h3 fw-bold mb-2">Borrow Book</h1>
                <h2 class="h6 fw-medium text-muted mb-0">Fill in the details for your borrow request.</h2>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="row">
            <div class="col-md-4">
                <div class="block block-rounded">
                    <div class="block-content p-0 overflow-hidden text-center" style="height: 400px;">
                        @if($book->image)
                            <img class="img-fluid w-100 h-100 object-fit-cover" src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}">
                        @else
                            <div class="bg-body-light d-flex align-items-center justify-content-center h-100 w-100">
                                <i class="fa fa-book fa-5x text-muted"></i>
                            </div>
                        @endif
                    </div>
                    <div class="block-content block-content-full text-center">
                        <h4 class="mb-1">{{ $book->title }}</h4>
                        <p class="text-muted mb-0">{{ $book->author }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Request Details</h3>
                    </div>
                    <div class="block-content">
                        <form action="{{ route('user.borrowings.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                            <div class="mb-4">
                                <label class="form-label" for="borrow_date">Borrow Date</label>
                                <div class="input-group">
                                    <span class="input-group-text form-control-lg form-control-alt me-1">
                                        <i class="far fa-calendar"></i>
                                    </span>
                                    <input type="text" class="js-flatpickr form-control form-control-lg form-control-alt"
                                        id="borrow_date" name="borrow_date" placeholder="Month Day, Year"
                                        data-alt-input="true" data-date-format="Y-m-d" data-alt-format="F j, Y"
                                        aria-invalid="true" data-min-date="today">
                                </div>
                                <div id="borrow_date-error" class="invalid-feedback animate fadeIn">
                                    Please enter the borrow date
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="return_date">Return Date</label>
                                <div class="input-group">
                                    <span class="input-group-text form-control-lg form-control-alt me-1">
                                        <i class="far fa-calendar"></i>
                                    </span>
                                    <input type="text" class="js-flatpickr form-control form-control-lg form-control-alt"
                                        id="return_date" name="return_date" placeholder="Month Day, Year"
                                        data-alt-input="true" data-date-format="Y-m-d" data-alt-format="F j, Y"
                                        aria-invalid="true" data-min-date="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                </div>
                                <div id="return_date-error" class="invalid-feedback animate fadeIn">
                                    Please enter the return date
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="notes">Notes (Optional)</label>
                                <textarea class="form-control" id="notes" name="notes" rows="4" placeholder="Any additional information.."></textarea>
                            </div>
                            <div class="mb-4 text-end">
                                <a href="{{ route('user.borrowings.index') }}" class="btn btn-alt-secondary me-1">Cancel</a>
                                <button type="submit" class="btn btn-primary px-4">Submit Request</button>
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
