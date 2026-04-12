@extends('layouts.base')
@section('title', 'Dashboard | Return Requests')
@section('css')
  <link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
@endsection
@section('js')
  <script src="{{ asset('js/lib/jquery.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables/dataTables.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons-jszip/jszip.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/pdfmake.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/vfs_fonts.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons/buttons.print.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('js/pages/be_tables_datatables.min.js') }}"></script>
  <script src="{{ asset('js/plugins/sweetalert2/sweetalert2.all.js') }}"></script>
  <script>
      document.addEventListener("DOMContentLoaded", function() {
          @if(session('success'))
              Swal.fire({ icon: 'success', title: 'Success', text: "{{ session('success') }}", timer: 3000, showConfirmButton: false });
          @endif
          @if(session('error'))
              Swal.fire({ icon: 'error', title: 'Error', text: "{{ session('error') }}", timer: 3000, showConfirmButton: false });
          @endif
      });
  </script>
@endsection
@section('content')
    <div class="content">
        <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center py-2 text-center text-md-start">
            <div class="flex-grow-1 mb-1 mb-md-0">
                <h1 class="h3 fw-bold mb-2">Return Requests</h1>
                <h2 class="h6 fw-medium text-muted mb-0">Manage pending book return requests.</h2>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Pending Returns</h3>
            </div>
            <div class="block-content block-content-full table-responsive">
                <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons fs-sm">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 5%;">NO</th>
                            <th>User</th>
                            <th>Book Title</th>
                            <th>Borrow Date</th>
                            <th>Return Notes</th>
                            <th class="text-center" style="width: 15%;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reversions as $reversion)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="fw-semibold">{{ $reversion->borrowing->user->name }}</td>
                                <td>{{ $reversion->borrowing->book->title }}</td>
                                <td>{{ $reversion->borrowing->borrow_date }}</td>
                                <td>{{ $reversion->notes }}</td>
                                <td class="text-center">
                                    <form action="{{ route('reversions.approve', $reversion->borrowing_id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-alt-success" title="Approve Return">
                                            <i class="fa fa-check"></i> Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('reversions.reject', $reversion->borrowing_id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-alt-danger" title="Reject Return">
                                            <i class="fa fa-times"></i> Reject
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
