$(function(){
    var class_title = '.title'; var class_name = '.name'; var class_location = '.location'; var class_cell = '.cell';
    var class_ref = '.ref'; var class_add1 = '.add1'; var class_add2 = '.add2'; var class_city = '.city';
    var class_state = '.state'; var class_zipcode = '.zipcode'; var class_country = '.country'; var class_email = '.email';
    var class_position = '.position'; var class_salary = '.salary'; var class_from_date = '.from_date'; var class_branch = '.branch';
    var class_to_date = '.to_date';

    $('form[id="offer"]').validate({
        rules: {
            title: {
                required: true,
            },
            name: {
                required: true,
                minlength: 6,
            },
            location: {
                required: true,
            },
            cell: {
                required: true,
                digits: true,
                maxlength: 10,
                minlength: 10,
            },
            //address
            add1: {
                required: true,
                minlength: 16,
                maxlength: 26,
            },
            add2: {
                minlength: 6,
                maxlength: 16,
            },
            city: {
                required: true,
                maxlength: 16,
            },
            state: {
                required: true,
                maxlength: 16,
            },
            zipcode: {
                required: true,
                digits: true,
                maxlength: 6,
            },
            country: {
                required: true,
            },
            email: {
                required: true,
                email: true
            },
            //position
            position: {
                required: true,
            },
            salary: {
                required: true,
                digits: true,
                maxlength: 6,
            },
            from_date: {
                required: true,
            },
            branch: {
                required: true,
            },
            // to_date: {
            //     required: true,
            // },
        },
        messages: {  
            title: {  
                required: 'Please select title',
            },
            name: {  
                required: 'Please enter your full name',
                minlength: 'Minimum 6 charecters needed',
            },
            cell: {  
                required: 'Please enter your mobile number',
                minlength: 'Minimum 10 charecters needed',
                maxlength: 'Maximum 10 charecters needed',
            },
            add1: {  
                required: 'Please enter your mobile number',
                minlength: 'Minimum 16 charecters needed',
                maxlength: 'Maximum 26 charecters needed',
            },
            city: {  
                required: 'Please enter your city',
                maxlength: 'Minimum 16 charecters needed',
            },
            state: {  
                required: 'Please enter your state',
                maxlength: 'Minimum 16 charecters needed',
            },
            zipcode: {  
                required: 'Please enter your state',
                digits : 'Enter only numbers',
                maxlength: 'Minimum 6 charecters needed',
            },
            email: {
                required: 'This field is required',
                email: 'This is not a valid email',
            },
            country: {
                required: 'Please select Country',
            },
            location: {
                required: 'Please enter Location',
            },
            //position
            position:{
                required: 'Please select Position',
            },
            salary:{
                required: 'Please select Position',
                digits : 'Enter only numbers',
                maxlength: 'Minimum 6 charecters needed',
            },
            from_date:{
                required: 'Please select From Date',
            },
            branch:{
                required: 'Please select Position',
            },
            // to_date:{
            //     required: 'Please select to Date',
            // },
        },  
        submitHandler: function(form) {  
            activeInternet();
            var email = $(class_email).val(); var title = $(class_title).val(); var name = $(class_name).val();    
            var cell = $(class_cell).val();  var add1 = $(class_add1).val(); var add2 = $(class_add2).val(); 
            var city = $(class_city).val();  var state = $(class_state).val(); var zipcode = $(class_zipcode).val(); 
            var country = $(class_country).val(); var location = $(class_location).val(); var position = $(class_position).val();  
            var salary = $(class_salary).val(); var from_date = $(class_from_date).val(); var branch = $(class_branch).val();  
            var to_date = $(class_to_date).val(); var ref =$(class_ref).val();
            //Calculation for Days
            if($.trim(to_date).length >= 0){
                var d = new Date();
                var month = d.getMonth()+1;
                var day = d.getDate();
                var to_date = d.getFullYear() + '-' +
                    ((''+month).length<2 ? '0' : '') + month + '-' +
                    ((''+day).length<2 ? '0' : '') + day;
            }
            var startDay = new Date(from_date);  
            var endDay = new Date(to_date);  
            var millisBetween = startDay.getTime() - endDay.getTime();  
            var days = Math.round(Math.abs(millisBetween / (1000 * 3600 * 24)));  
            //Razorpay Start
            $.ajax({
                type: 'POST',
                url: 'get_curl_handle',
                data: {
                    payment_id: 'offer_letter_'+to_date,
                    amount: (days*26)*100,
                    email: email,
                },
                dataType: 'json',
                error:function(error){
                    alert(error);
                },
                success: function(result){
                    if(result[0].status == 1){
                      var options = {
                        "key": 'rzp_test_p5aZKuSA2SV6T4', // Enter the Key ID generated from the Dashboard 
                        "amount": (days*26)*100, 
                        "currency": "INR",
                        "name": "Sunglade Digital ",
                        "description": "Overseas CRM",
                        "image": "https://sunglade.in/assets/img/favicon.png",
                        "handler": function (response){
                            $.ajax({
                              type: 'POST',
                              url: 'payment',
                              data: {
                                  payment_amount: days*26,
                                  razorpay_payment_id: response.razorpay_payment_id,
                                  razorpay_order_id: response.razorpay_order_id,
                                  razorpay_signature: response.razorpay_signature,
                                  payment_status: 'success',
                              },
                              dataType: 'json',
                              error:function(error){
                                  console.log(error);
                              },
                              success: function(result){
                                  if(result[0].status == 1){

                                    // Thing to do after success of the payment

                                    $.ajax({
                                        type: 'POST',
                                        url: 'create_offer',
                                        data: {
                                            email: email, title: title, name: name,
                                            cell: cell, add1: add1, add2: add2,
                                            city: city, state: state, zipcode: zipcode,
                                            country: country, location: location, position: position,
                                            salary: salary, from_date: from_date, branch: branch,
                                            to_date: to_date, ref: ref, offer_letter_id: result[0].id,
                                        },
                                        dataType: 'json',
                                        error:function(error){
                                            swal(error);
                                        },
                                        success: function(result){
                                            if(result.status == 1){                        
                                                swal({
                                                    title: "Good job!!!", 
                                                    text: result.msg, 
                                                    icon: "success",
                                                }).then((willDelete) => {
                                                    if(willDelete){
                                                        $('#register').trigger("reset");
                                                        window.location.replace(result.url);
                                                    }
                                                });
                                            }else if(result.status == 0){
                                                console.log(result.errors);
                                                swal(result.msg, $(result.errors).text(), "error");
                                            }
                                        }
                                    });
                                      
                                    // end of the success
                                  }else{
                                    swal(result[0].msg, $(result[0].msg).text(), "error");
                                  }
                              }
                            });
                        },
                        "prefill": {
                            "name": name,
                            "email": email,
                            "contact": cell
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
                      rzp1.on('payment.failed', function (response){
                        alert(response.error.code);
                        alert(response.error.description);
                      });
                    }else{
                        swal(result[0].msg, $(result[0].errors).text(), "error");
                    }
                }
            });
            //PaymentEnd  
        }  
    });

    $('.edit').on('click', function(){
        var id = $('.edit').attr('id');
        $.ajax({
            type: 'POST',
            url: 'get_add',
            data: {
                id: id,
            },
            dataType: 'json',
            error:function(error){
                swal(error);
            },
            success: function(result){
                if(result.status == 1){    
                    $('#edit').prepend(`<input type="text" class="form-control id" name="id" value="${id}" hidden>`);                   
                    $('.add1_u').val(result.msg.add_1); $('.add2_u').val(result.msg.add_2);
                    $('.city_u').val(result.msg.city); $('.state_u').val(result.msg.state);
                    $('.zipcode_u').val(result.msg.pincode);
                    $('#exampleModal').modal('show');
                }else if(result.status == 0){
                    swal(result.msg, $(result.errors).text(), "error");
                }
            }
        });
        
        // alert();
    });
    $('form[id="edit"]').validate({
        rules: {
            add1: {
                required: true,
                minlength: 16,
                maxlength: 26,
            },
            add2: {
                minlength: 6,
                maxlength: 16,
            },
            city: {
                required: true,
                maxlength: 16,
            },
            state: {
                required: true,
                maxlength: 16,
            },
            zipcode: {
                required: true,
                digits: true,
                maxlength: 6,
            },
        },
        messages: {  
            add1: {  
                required: 'Please enter your mobile number',
                minlength: 'Minimum 16 charecters needed',
                maxlength: 'Maximum 26 charecters needed',
            },
            city: {  
                required: 'Please enter your city',
                maxlength: 'Minimum 16 charecters needed',
            },
            state: {  
                required: 'Please enter your state',
                maxlength: 'Minimum 16 charecters needed',
            },
            zipcode: {  
                required: 'Please enter your state',
                digits : 'Enter only numbers',
                maxlength: 'Minimum 6 charecters needed',
            },
        },
        submitHandler: function(form) {  
            var add1 = $(".add1_u").val(); var add2 = $(".add2_u").val(); var city = $(".city_u").val();  
            var state = $(".state_u").val(); var zipcode = $(".zipcode_u").val(); var id= $(".id").val();
            $.ajax({
                type: 'POST',
                url: 'update_add',
                data: {
                    id: id, add1: add1, add2: add2,
                    city: city, state: state, zipcode: zipcode,
                },
                dataType: 'json',
                error:function(error){
                    swal(error);
                },
                success: function(result){
                    if(result.status == 1){                        
                        swal({
                            title: "Good job!!!", 
                            text: result.msg, 
                            icon: "success",
                        }).then((willDelete) => {
                            if(willDelete){
                                $('#edit').trigger("reset");
                                $('#exampleModal').modal('hide');
                                window.open(result.url);
                            }
                        });
                    }else if(result.status == 0){
                        console.log(result.errors);
                        swal(result.msg, $(result.errors).text(), "error");
                    }
                }
            });
        }
    })
    

    function activeInternet(){
        let xhr = new XMLHttpRequest();
        xhr.open("GET", "https://jsonplaceholder.typicode.com/posts", true);
        xhr.onload = (event)=>{
            //Online
        }
        xhr.onerror = (event)=>{
            //Offline
            swal("You're offline now", "Opps! Internet is disconnected", "error");
        }
        xhr.send();
    }
})
