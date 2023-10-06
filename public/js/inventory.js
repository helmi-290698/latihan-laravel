$("#form-input-inventory").on("submit", function(e) {
    
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
                    $("input[name='"+prefix+"']").addClass("is-invalid");
                    $("span." + prefix + "_error").text(val[0]);
                   
                });
            } else {
                
                toastr.success(data.message);
                $('#inventory-table').DataTable().ajax.reload();
                
            }
        },
    });
});

$(document).on("submit", "#form-delete-inventory", function(e) {
    e.preventDefault();

    var form = $(this);
    var url = form.attr("action");

    $.ajax({
        url: url,
        method: "POST",
        dataType: "json",
        data: form.serialize(),
        success: function(data) {
            if (data.status == 0) {
                // Handle validation errors if applicable
                $.each(data.error, function(prefix, val) {
                    $("input[name='" + prefix + "']").addClass("is-invalid");
                    $("span." + prefix + "_error").text(val[0]);
                });
            } else {
                
                toastr.success('Data Berhasil Dihapus !!');
                $('#inventory-table').DataTable().ajax.reload();
            }
        },
        error: function(xhr, status, error) {
            // Handle error response
            console.log(xhr.responseText);
        }
    });
});

$(document).on('click','.open_edit_inventory',function(){
    const id= $(this).val();
    const code = $(this).data('code');
    const name = $(this).data('name'); 
    const price= $(this).data('price'); 
    const stock= $(this).data('stock'); 
   
    $('#inventory_id').val(id);
    $('#code_update').val(code);   
    $('#stock_update').val(stock);
    $('#name_update').val(name);
    $('#price_update').val(price);
    $('#modalEditInventory').modal('show');
});

$("#form-update-inventory").on("submit", function(e) {
    
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
                    
                    $("input[name='"+prefix+"']").addClass("is-invalid");
                    $("select[name='"+prefix+"']").addClass("is-invalid");
                    $("textarea[name='"+prefix+"']").addClass("is-invalid");
                    $("span." + prefix + "_error").text(val[0]);
                   
                });
            } else {
                
                toastr.success(data.message);
                $('#inventory-table').DataTable().ajax.reload();
                $('#modalEditInventory').modal('hide');

                
            }
        },
    });
});