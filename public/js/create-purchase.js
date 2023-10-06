const show_inventory = ()=>{
    $.ajax({
        type: 'GET', 
        url:url+'/inventory/show', 
        dataType: 'json',
        success: function (data) { 
        data.inventory.forEach(hasil => {
            $('.select_inventory').append('<option value="'+hasil.id+'">'+hasil.name+'</option>')
        });
        }
        
    });
}

show_inventory();
let loop = 0;
$('.tambah-input').on('click',function(){
    tambahInput();
});

const tambahInput = () => {
    loop++;
    let dataCetak =  ` <div class="row control-group"><div class="col-4">
    <div class="form-floating form-floating-outline mb-3">
        <select name="inventory_id[]"  class="form-control select_inventory`+loop+`" data-input-id="`+loop+`">
            <option value="">--pilih--</option>
        </select>
        <label for="Inventory">Inventory</label>
        <span class="text-danger inventory_id_error" data-span-id="`+loop+`"></span>
    </div>
</div>
<div class="col-2">
    <div class="form-floating form-floating-outline mb-3">
        <input class="form-control" id="qty" type="number" min="0" name="qty[]"
            placeholder="qty" data-input-id="`+loop+`" autofocus />
        <label for="qty">qty</label>
        <span class="text-danger qty_error" data-span-id="`+loop+`"></span>
    </div>
</div>
<div class="col-4">
    <div class="form-floating form-floating-outline mb-3">
        <input class="form-control" id="price" type="text" name="price[]"
            placeholder="price" data-input-id="`+loop+`" autofocus />
        <label for="price">Price</label>
        <span class="text-danger price_error" data-span-id="`+loop+`"></span>
    </div>
</div>
<div class="col-2 d-flex justify-content-center">
    <button type="button" class="btn btn-icon btn-lg me-2 btn-danger remove">
        <span class="tf-icons mdi mdi-trash-can-outline"></span>
    </button>
</div></div>`;

$('#tambah').append(dataCetak);
$('.select_inventory'+loop).select2();
show_inventory_select($(".select_inventory"+loop).last());
}

const show_inventory_select = (selectElement)=>{
    $.ajax({
        type: 'GET', 
        url:url+'/inventory/show', 
        dataType: 'json',
        success: function (data) { 
        data.inventory.forEach(hasil => {
            selectElement.append(`<option value='${hasil.id}'>${hasil.name}</option>`)
        });
        }
        
    });
}
$("body").on("click",".remove",function(){ 
    $(this).parents(".control-group").remove();
});

$("#form-input-purchase").on("submit", function(e) {
    
    e.preventDefault();
    $.ajax({
        url: $(this).attr("action"),
        method: $(this).attr("method"),
        data: new FormData(this),
        processData: false,
        dataType: "json",
        contentType: false,
        beforeSend: function () {
            $(document).find("span.text-danger").text("");
            $(".is-invalid").removeClass("is-invalid");
        },
        success: function (data) {
           console.log(data);
            if (data.status == 0) {
                
                $.each(data.error, function (prefix, val) {
                    let hasilString = prefix.replace(/\.\d+$/, '[]');
                    let hasilhilang = prefix.replace(/\.\d+$/, '');
                    let inventoryId = prefix.charAt(prefix.length - 1);
                    $("input[type='date'][name='"+prefix+"']").addClass("is-invalid");
                    $("input[name='"+hasilString+"'][data-input-id='" + inventoryId + "']").addClass("is-invalid");
                    $("select[name='"+hasilString+"'][data-input-id='" + inventoryId + "']").addClass("is-invalid");
                    $("span." + hasilhilang + "_error[data-span-id='" + inventoryId + "']").text(val[0]);
                    $("span." + prefix + "_error").text(val[0]);
                });
            } else {
                
                toastr.success(data.message);
                $('#inventory-table').DataTable().ajax.reload();
                
            }
        },
    });
});