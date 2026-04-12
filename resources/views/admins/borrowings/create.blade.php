@extends('layouts.base')
@section('title', 'Dashboard | Create Borrowing')
@section('css')
    <link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/flatpickr/flatpickr.min.css') }}">

    <!-- OneUI framework -->
    <link rel="stylesheet" id="css-main" href="{{ asset('css/oneui.min.css') }}">
@endsection

@section('content')
    <div class="main-container">
        <div class="content">
            <div class="block block-rounded col-xl-8">
                <div class="block-header block-header-default py-3 ps-4 mb-4">
                    <h2 class="block-title fs-lg">Create Borrowing for "{{ $book->title }}"</h2>
                </div>
                <div class="block-content block-content-full">
                    <div class="col-lg-8 col-xl-11 mx-auto">
                        @if(session('error'))
                            <div class="alert alert-danger fade show" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        
                        <form id="form-create-borrowing" action="{{ route('borrowings.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                            
                            <div class="mb-4">
                                <label for="user_id" class="form-label">User</label>
                                <select class="js-select2 form-select" id="user_id" name="user_id" style="width: 100%;" data-placeholder="Choose one..">
                                    <option></option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="borrow_date">Borrow Date</label>
                                <div class="input-group">
                                    <span class="input-group-text form-control-lg form-control-alt me-1">
                                        <i class="far fa-calendar"></i>
                                    </span>
                                    <input type="text" class="js-flatpickr form-control form-control-lg form-control-alt"
                                        id="borrow_date" name="borrow_date" placeholder="Month Day, Year"
                                        data-alt-input="true" data-date-format="Y-m-d" data-alt-format="F j, Y">
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label" for="return_date">Return Date</label>
                                <div class="input-group">
                                    <span class="input-group-text form-control-lg form-control-alt me-1">
                                        <i class="far fa-calendar-check"></i>
                                    </span>
                                    <input type="text" class="js-flatpickr form-control form-control-lg form-control-alt"
                                        id="return_date" name="return_date" placeholder="Month Day, Year"
                                        data-alt-input="true" data-date-format="Y-m-d" data-alt-format="F j, Y">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label" for="notes">Notes</label>
                                <textarea class="form-control" id="notes" name="notes" rows="4" placeholder="Optional notes..."></textarea>
                            </div>

                            <div class="mb-5">
                                <button type="submit" class="btn btn-primary">Process Borrowing</button>
                                <a href="{{ route('borrowings.index') }}" class="btn btn-alt-secondary">Cancel</a>
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
    <script src="{{ asset('js/lib/jquery.min.js') }}"></script>
    <script src="{{ asset('js/plugins/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        One.helpersOnLoad(['js-flatpickr', 'jq-select2']);
    </script>
@endsection
