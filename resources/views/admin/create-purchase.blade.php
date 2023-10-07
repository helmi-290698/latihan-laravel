@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }} " />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endpush

@section('content')
    <h5 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home</span> / {{ $title }}</h5>
    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="h5"> Input {{ $title }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('purchase.store') }}" method="post" id="form-input-purchase">
                        @csrf
                        <div class="row">
                            <div class="col-4">
                                <div class="form-floating form-floating-outline mb-3">
                                    <select name="inventory_id[]" id="inventory_id"
                                        class="form-control select_inventory select2" data-input-id="0">
                                        <option value="">--pilih--</option>
                                    </select>
                                    <label for="Inventory">Inventory</label>
                                    <span class="text-danger inventory_id_error" data-span-id="0"></span>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-floating form-floating-outline mb-3">
                                    <input class="form-control" id="qty" type="number" min="0" name="qty[]"
                                        placeholder="qty" data-input-id="0" autofocus />
                                    <label for="qty">qty</label>
                                    <span class="text-danger qty_error" data-span-id="0"></span>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-floating form-floating-outline mb-3">
                                    <input class="form-control" id="price" type="text" name="price[]"
                                        placeholder="price" data-input-id="0" autofocus readonly />
                                    <label for="price">Price</label>
                                    <span class="text-danger price_error" data-span-id="0"></span>
                                </div>
                            </div>
                            <div class="col-2 d-flex justify-content-center">
                                <button type="button" class="btn btn-icon btn-lg me-2 btn-primary tambah-input">
                                    <span class="tf-icons mdi mdi-plus"></span>
                                </button>
                            </div>

                        </div>
                        <div id="tambah"></div>
                        <hr>
                        <div class="float-start">
                            <div class="form-floating form-floating-outline mb-3">
                                <input class="form-control" id="date" type="date" min="0" name="date"
                                    placeholder="date" autofocus />
                                <label for="date">date</label>
                                <span class="text-danger date_error"></span>
                            </div>
                        </div>
                        <div class="float-end">
                            <button type="submit" class="btn btn-primary btn-lg">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-header  d-flex align-items-center justify-content-between">
                    <h5 class="h5">Riwayat {{ $title }}</h5>
                </div>
                <div class="card-body">
                    <div id="header"></div>
                    <dl class="row mb-2" id="content">
                    </dl>
                    <div id="footer"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script>
        let url = `{{ url('/') }}`;
    </script>
    <script>
        $(".select2").select2();
    </script>
    <script src="{{ asset('js/create-purchase.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
@endpush
