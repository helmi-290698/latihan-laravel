<div class="modal fade" id="modalEditSales" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered1 modal-md modal-add-new-cc">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body p-md-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center">
                    <h3>Edit {{ $title }}</h3>
                </div>
                <hr>
                <form action="{{ route('sales.update') }}" method="post" id="form-update-sales">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="id" id="sales_id">
                    <div class="form-floating form-floating-outline mb-3">
                        <select name="inventory_id" id="inventory_id" class="form-control select2">

                        </select>
                        <label for="Inventory">Inventory</label>
                        <span class="text-danger inventory_id_error"></span>
                    </div>

                    <div class="form-floating form-floating-outline mb-3">
                        <input class="form-control" id="qty" type="text" name="qty" placeholder="qty"
                            autofocus />
                        <label for="qty">Qty</label>
                        <span class="text-danger qty_error"></span>
                    </div>
                    <div class="form-floating form-floating-outline mb-3">
                        <input class="form-control" id="price" type="text" name="price" placeholder="Price"
                            autofocus readonly />
                        <label for="Price">Price</label>
                        <span class="text-danger price_error"></span>
                    </div>
                    <div class="form-floating form-floating-outline mb-3">
                        <input class="form-control" id="date" type="date" name="date" placeholder="date"
                            autofocus />
                        <label for="date">Date</label>
                        <span class="text-danger date_error"></span>
                    </div>
                    <div class="float-end">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
