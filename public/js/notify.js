$(document).ready(function () {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    function notifyorder() { 
        // console.log(public_url);
        $.ajax({
            type: "get",
            url: public_url+"/admin/CheckNewOrders",
            dataType: "json",
            success: function (response) {
                if(response != '')
                {
                    $.each(response, function(key,value) {
                        toastr.info('New Order Placed')
                      }); 
                }
                
            }
        });
        setTimeout(function () { notifyorder(); }, 3000);
    }
    setTimeout(function () { notifyorder(); }, 3000);
});