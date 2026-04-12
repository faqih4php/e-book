@extends('layouts.base')
@section('title', 'Dashboard | Books')
@section('css')
  <link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
  <link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
@endsection
@section('js')
  <script src="{{ asset('js/lib/jquery.min.js') }}"></script>

  <!-- Page JS Plugins -->
  <script src="{{ asset('js/plugins/datatables/dataTables.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons-jszip/jszip.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/pdfmake.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/vfs_fonts.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons/buttons.print.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-responsive/js/dataTables.responsive.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('js/plugins/flatpickr/flatpickr.js') }}"></script>
  <script src="{{ asset('js/plugins/sweetalert2/sweetalert2.all.js') }}"></script>
  <script src="{{ asset('js/pages/be_tables_datatables.min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: "{{ session('success') }}",
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: "{{ session('error') }}",
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            // Setup sweet alert for delete confirmation
            const deleteButtons = document.querySelectorAll('.btn-delete');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const formId = this.getAttribute('data-form-id');
                    const form = document.getElementById(formId);

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection
@section('content')
    <div class="content">
        <div
            class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center py-2 text-center text-md-start">
            <div class="flex-grow-1 mb-1 mb-md-0">
                <h1 class="h3 fw-bold mb-2">
                    Search Results
                </h1>
                <h2 class="h6 fw-medium fw-medium text-muted mb-0">
                    Showing results for keyword: <span class="fw-semibold text-primary">"{{ $query }}"</span>
                </h2>
            </div>
            <div class="mt-3 mt-md-0 ms-md-3 space-x-1">
                <a class="btn btn-sm btn-alt-secondary space-x-1" href="{{ route('dashboard.admin') }}">
                    <i class="fa fa-arrow-left opacity-50"></i>
                    <span>Back to Dashboard</span>
                </a>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    Found {{ $books->count() }} Books matching "{{ $query }}"
                </h3>
            </div>
            <div class="block-content block-content-full table-responsive">
                <!-- DataTables init on table by adding .js-dataTable-buttons class, functionality is initialized in js/pages/tables_datatables.js -->
                <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons fs-sm">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 5%;">NO</th>
                            <th style="width: 25%;">Title</th>
                            <th class="d-none d-sm-table-cell" style="width: 15%;">Author</th>
                            <th style="width: 15%;">Published Date</th>
                            <th style="width: 15%;">Pages</th>
                            {{-- <th style="width: 10%;">Image</th> --}}
                            <th style="width: 15%;">Status</th>
                            <th style="width: 15%;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($books as $book)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="fw-semibold">
                                    <span>{{ ucfirst($book->title) }}</span>
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <span class="text-muted">{{ $book->author }}</span>
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <span class="text-muted">{{ $book->publication_year }}</span>
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <span class="text-muted">{{ $book->page }}</span>
                                </td>
                                {{-- <td class="d-none d-sm-table-cell">
                                    <span class="text-muted">{{ $book->image }}</span>
                                </td> --}}
                                <td class="d-none d-sm-table-cell">
                                    @if ($book->status == 'available')
                                        <span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-info-light text-info">Available</span>
                                    @else
                                        <span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-danger-light text-danger">Borrowed</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-alt-primary js-bs-tooltip-enabled"
                                        data-bs-toggle="tooltip" aria-label="View" data-bs-original-title="View">
                                        <a href="{{ route('books.show', $book->id) }}"
                                            class="text-primary text-decoration-none">
                                            <i class="fa fa-fw fa-eye"></i>
                                        </a>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-alt-info js-bs-tooltip-enabled"
                                        data-bs-toggle="tooltip" aria-label="Edit" data-bs-original-title="Edit">
                                        <a href="{{ route('books.edit', $book->id) }}"
                                            class="text-info text-decoration-none">
                                            <i class="fa fa-fw fa-pencil-alt"></i>
                                        </a>
                                    </button>
                                    <button type="button"
                                        class="btn btn-sm btn-alt-danger js-bs-tooltip-enabled btn-delete"
                                        data-bs-toggle="tooltip" aria-label="Delete" data-bs-original-title="Delete"
                                        data-form-id="delete-form-{{ $book->id }}">
                                        <i class="far fa-fw fa-trash-alt"></i>
                                    </button>
                                    <form id="delete-form-{{ $book->id }}"
                                        action="{{ route('books.destroy', $book->id) }}" method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
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
