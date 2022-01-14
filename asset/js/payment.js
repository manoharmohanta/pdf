$('.pay').click(function(e){
    var amount = $(this).data("price");
    $.ajax({
        type: 'POST',
        url: '<?= base_url() ?>welcome/get_curl_handle',
        data: {
            payment_id: 'offer_letter_'.$.now(),
            amount: amount*100,
        },
        dataType: 'json',
        error:function(error){
            alert(error);
        },
        success: function(result){
            // csrfName = result[0].csrfName;
            // csrfHash = result[0].csrfHash;
            if(result[0].status == 1){
              var options = {
                "key": '<?= key_id ?>', // Enter the Key ID generated from the Dashboard 
                "amount": amount*100, 
                "currency": "INR",
                "name": "Sunglade Digital ",
                "description": "Overseas CRM",
                "image": "<?= base_url()?>assets/img/favicon.png",
                //"order_id": result[0].msg.id,
                "handler": function (response){
                    $.ajax({
                      type: 'POST',
                      url: '<?= base_url() ?>crm/payment',
                      data: {
                          payment_amount: amount,
                          razorpay_payment_id: response.razorpay_payment_id,
                          razorpay_order_id: response.razorpay_order_id,
                          razorpay_signature: response.razorpay_signature,
                          payment_status: 'success',
                      },
                      dataType: 'json',
                      error:function(error){
                          alert(error);
                      },
                      success: function(result){
                        //   csrfName = result[0].csrfName;
                        //   csrfHash = result[0].csrfHash;
                          if(result[0].status == 1){
                              toastr["success"](result[0].msg, "Success!!")

                              toastr.options = {
                              "closeButton": true,
                              "debug": false,
                              "newestOnTop": false,
                              "progressBar": true,
                              "positionClass": "toast-top-right",
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
                          }else{
                              toastr["error"](result[0].msg, "Error!!")

                              toastr.options = {
                              "closeButton": true,
                              "debug": false,
                              "newestOnTop": false,
                              "progressBar": true,
                              "positionClass": "toast-top-right",
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
                          }
                      }
                    });
                },
                "prefill": {
                    "name": "<?= ucwords($this->session->userdata('org_name')) ?>",
                    "email": "<?= ($this->session->userdata('email')) ?>",
                    "contact": "9999999999"
                },
                "notes": {
                    "address": "Sunglade Digital Solutions Corporate Office"
                },
                "theme": {
                    "color": "#5bc0de"
                }
            };
              var rzp1 = new Razorpay(options);
              rzp1.open();
              e.preventDefault();
            }else{
                toastr["error"](result[0].msg, "Error!!")

                toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
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
            }
        }
    });
  });