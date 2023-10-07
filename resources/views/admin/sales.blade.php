@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }} " />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endpush

@section('content')
    <h5 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home</span> / {{ $title }}</h5>

    <div class="card">
        <div class="card-header  d-flex align-items-center justify-content-between">
            <h5 class="h5 mt-2">Data {{ $title }}</h5>
            <div class="float-end">
                <a href="{{ route('sales.create') }}" class="btn btn-primary"><i class="mdi mdi-plus m-0"></i>
                    {{ $title }}</a>
            </div>
        </div>
        <div class="card-body">
            {{ $dataTable->table() }}
        </div>
    </div>

    {{-- Start modal tambah jabatan --}}
    {{-- @include('pages.jabatan.modals.tambah-jabatan') --}}
    {{-- End modal tambah jabatan --}}
    {{-- Start modal ubah jabatan --}}
    @include('admin.modals.update-sales')
    {{-- End modal ubah jabatan --}}
@endsection

@push('script')
    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('/vendor/datatables/buttons.server-side.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    {{ $dataTable->scripts() }}
    <script>
        let url = `{{ url('/') }}`;
    </script>
    <script src="{{ asset('js/sales.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endpush
