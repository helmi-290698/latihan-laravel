@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
@endpush

@section('content')
    <h5 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home</span> / {{ $title }}</h5>
    <div class="row d-flex justify-content-center">
        <div class="col-5 ">
            <div class="card ">
                <div class="card-header d-flex align-items-center justify-content-center">
                    <h5 class="h5 text-center"> Detail {{ $title }}</h5>
                </div>
                <div class="card-body" id="data">
                    <dl class="row mb-4">
                        <dt class="col-4">Nama</dt>
                        <dd class="col-8">: {{ $purchase_detail->purchase->user->name }}</dd>

                        <dt class="col-4">Tanggal</dt>
                        <dd class="col-8">: {{ $purchase_detail->purchase->date }}</dd>
                        <hr>
                        <dt class="col-4">Barang</dt>
                        <dd class="col-8">: </dd>
                        <dd class="col-12 mt-2">
                            <div class="row">
                                <div class="col-4">{{ $purchase_detail->inventory->name }}</div>
                                <div class="col-2 d-flex justify-content-center">{{ $purchase_detail->qty }}</div>
                                <div class="col-6 d-flex justify-content-end">Rp. {{ $purchase_detail->price }}</div>
                            </div>
                        </dd>
                        <hr>
                        <dt class="col-4">Total</dt>
                        <dd class="col-8 d-flex justify-content-end"> Rp. {{ $purchase_detail->price }}</dd>
                    </dl>

                </div>
                <div class="card-footer">
                    <button class="btn btn-primary float-end" id="cetak">Cetak</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script>
        let url = `{{ url('/') }}`;
    </script>
    <script src="{{ asset('plugins/printarea/demo/jquery.PrintArea.js') }}"></script>
    <script>
        (function($) {
            // fungsi dijalankan setelah seluruh dokumen ditampilkan
            $(document).ready(function(e) {

                // aksi ketika tombol cetak ditekan
                $("#cetak").bind("click", function(event) {
                    // cetak data pada area <div id="#data-mahasiswa"></div>
                    $('#data').printArea();
                });
            });
        })(jQuery);
    </script>
@endpush
