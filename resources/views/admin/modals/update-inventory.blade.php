<div class="modal fade" id="modalEditInventory" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered1 modal-md modal-add-new-cc">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body p-md-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center">
                    <h3>Edit {{ $title }}</h3>
                </div>
                <hr>
                <form action="{{ route('inventory.update') }}" method="post" id="form-update-inventory">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="id" id="inventory_id">
                    <div class="form-floating form-floating-outline mb-3">
                        <input class="form-control" id="code_update" type="text" name="code_update"
                            placeholder="Code" autofocus />
                        <label for="code">Code</label>
                        <span class="text-danger code_update_error"></span>
                    </div>

                    <div class="form-floating form-floating-outline mb-3">
                        <input class="form-control" id="name_update" type="text" name="name_update"
                            placeholder="Name" autofocus />
                        <label for="name">Name</label>
                        <span class="text-danger name_update_error"></span>
                    </div>
                    <div class="form-floating form-floating-outline mb-3">
                        <input class="form-control" id="price_update" type="text" name="price_update"
                            placeholder="Price" autofocus />
                        <label for="Price">Price</label>
                        <span class="text-danger price_update_error"></span>
                    </div>
                    <div class="form-floating form-floating-outline mb-3">
                        <input class="form-control" id="stock_update" type="text" name="stock_update"
                            placeholder="Stock" autofocus />
                        <label for="stock">Stock</label>
                        <span class="text-danger stock_update_error"></span>
                    </div>
                    <div class="float-end">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
