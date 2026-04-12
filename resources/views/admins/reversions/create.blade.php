@extends('layouts.base')
@section('title', 'Dashboard | Return Book')
@section('css')
    <!-- OneUI framework -->
    <link rel="stylesheet" id="css-main" href="{{ asset('css/oneui.min.css') }}">
@endsection

@section('content')
    <div class="main-container">
        <div class="content">
            <div class="block block-rounded col-xl-8">
                <div class="block-header block-header-default py-3 ps-4 mb-4">
                    <h2 class="block-title fs-lg">Return Book: "{{ $borrowing->book->title }}"</h2>
                </div>
                <div class="block-content block-content-full">
                    <div class="col-lg-8 col-xl-11 mx-auto">
                        @if(session('error'))
                            <div class="alert alert-danger fade show" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        
                        <div class="mb-4">
                            <h5>Borrowing Details</h5>
                            <ul>
                                <li><strong>User:</strong> {{ $borrowing->user->name }}</li>
                                <li><strong>Borrow Date:</strong> {{ $borrowing->borrow_date }}</li>
                                <li><strong>Expected Return:</strong> {{ $borrowing->return_date }}</li>
                            </ul>
                        </div>

                        <form id="form-create-reversion" action="{{ route('reversions.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="borrowing_id" value="{{ $borrowing->id }}">
                            
                            <div class="mb-4">
                                <label class="form-label" for="notes">Return Notes / Condition</label>
                                <textarea class="form-control" id="notes" name="notes" rows="4" placeholder="Book condition, delays, etc..." required></textarea>
                            </div>

                            <div class="mb-5">
                                <button type="submit" class="btn btn-success">Confirm Return</button>
                                <a href="{{ route('reversions.index') }}" class="btn btn-alt-secondary">Cancel</a>
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
@endsection
