@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
@endpush

@section('content')
    <h5 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home</span> / {{ $title }}</h5>
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="h5"> Input Data {{ $title }}</h5>
                </div>
                <div class="card-body">
                    <form action="">
                        @csrf
                        <div class="form-floating form-floating-outline mb-3">
                            <input class="form-control" id="code" type="text" name="code" placeholder="Code"
                                autofocus />
                            <label for="code">Code</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input class="form-control" id="name" type="text" name="name" placeholder="Name"
                                autofocus />
                            <label for="name">Name</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input class="form-control" id="price" type="text" name="price" placeholder="Price"
                                autofocus />
                            <label for="Price">Price</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-3">
                            <input class="form-control" id="stock" type="text" name="stock" placeholder="Stock"
                                autofocus />
                            <label for="stock">Stock</label>
                        </div>
                        <div class="float-end">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-header  d-flex align-items-center justify-content-between">
                    <h5 class="h5">Data {{ $title }}</h5>
                </div>
                <div class="card-body">
                    {{-- {{ $dataTable->table() }} --}}
                </div>
            </div>
        </div>
    </div>


    {{-- Start modal tambah jabatan --}}
    {{-- @include('pages.jabatan.modals.tambah-jabatan') --}}
    {{-- End modal tambah jabatan --}}
    {{-- Start modal ubah jabatan --}}
    {{-- @include('pages.jabatan.modals.ubah-jabatan') --}}
    {{-- End modal ubah jabatan --}}
@endsection

@push('script')
    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    {{-- {{ $dataTable->scripts() }} --}}

    <script src="{{ asset('js/inventory.js') }}"></script>
@endpush
