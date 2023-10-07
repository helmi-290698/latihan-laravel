$('#inventory_id').select2({
    dropdownParent: $('#modalEditPurchase')
});

$(document).on("submit", "#form-delete-purchase", function(e) {
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
                Swal.fire({
                    title: 'Success!',
                    text: data.message,
                    icon:'success',
                    customClass: {
                      confirmButton: 'btn btn-primary waves-effect waves-light'
                    },
                    buttonsStyling: false
                  })
                $('#purchase-table').DataTable().ajax.reload();
            }
        },
        error: function(xhr, status, error) {
            // Handle error response
            console.log(xhr.responseText);
        }
    });
});

$(document).on('click','.open_edit_purchase',function(){
    const id= $(this).val();
    const inventory = $(this).data('inventory');
    const qty = $(this).data('qty'); 
    const price= $(this).data('price'); 
    const date= $(this).data('date'); 
   
    $('#purchase_id').val(id);
    $.ajax({
        type: 'GET', 
        url:url+'/inventory/show', 
        dataType: 'json',
        success: function (data) { 
        data.inventory.forEach(hasil => {
            $('#inventory_id').append('<option value="'+hasil.id+'" ' + (hasil.id == inventory ? 'selected' : '') + '>'+hasil.name+'</option>')
        });
        }
        
    });
    $('#qty').val(qty);   
    $('#date').val(date);   
    $('#price').val(price);
    $('#modalEditPurchase').modal('show');
});

$(document).on('change','#inventory_id',function(){
    
    let inventory_id= $('#inventory_id').val();
    $.ajax({
        type: 'GET', 
        url:url+'/inventory/show/'+inventory_id, 
        dataType: 'json',
        success: function (data) { 
        let price = data.inventory.price;
      
        const total_price = price * $('#qty').val();
        console.log(total_price);
        $('#price').val(total_price);
        }
        
    });
});

$(document).on('keyup','#qty',function(){
    
    let inventory_id= $('#inventory_id').val();
    $.ajax({
        type: 'GET', 
        url:url+'/inventory/show/'+inventory_id, 
        dataType: 'json',
        success: function (data) { 
        let price = data.inventory.price;
        const total_price = price * $('#qty').val();
        $('#price').val(total_price);
        }
        
    });
});

$("#form-update-purchase").on("submit", function(e) {
    
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
                
                Swal.fire({
                    title: 'Success!',
                    text: data.message,
                    icon:'success',
                    customClass: {
                      confirmButton: 'btn btn-primary waves-effect waves-light'
                    },
                    buttonsStyling: false
                  })
                $('#purchase-table').DataTable().ajax.reload();
                $('#modalEditPurchase').modal('hide');

                
            }
        },
    });
});
$('#modalEditPurchase').on('hidden.bs.modal', function () {
    $('#inventory_id').empty(); 
});