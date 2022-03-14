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
  "hideDuration": "100",
  "timeOut": "10000",
  "extendedTimeOut": "10000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
    }
    function notifyorder() { 
        // console.log(public_url);
        // toastr.info('Are you the 6 fingered man?')
        $.ajax({
            type: "get",
            url: public_url+"/admin/CheckNewOrders",
            dataType: "json",
            success: function (response) {
                if(response != '')
                {
                    $.each(response, function(key,value) {
                        // toastr.info('<a href="'+public_url+'/admin/orders">New Order Placed</a>')
                        $('#exampleModal').modal('show');
                        setTimeout(function(){ $("#exampleModal").modal("hide"); }, 10000);
                        var audio = new Audio(public_url+'/assets/admin/mp3/lovingly-618.mp3');
                        audio.play();
                        $('.stop-sound').click(function(){
                            audio.pause();
                            audio.currentTime = 0;
                        });
                      }); 
                }
                
            }
        });
        setTimeout(function () { notifyorder(); }, 3000);
    }
    setTimeout(function () { notifyorder(); }, 3000);

    
});