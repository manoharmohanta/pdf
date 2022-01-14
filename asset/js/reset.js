$(function(){
    var class_email = '#exampleInputEmail1'; var class_password = '#exampleInputPassword1';
    
    // console.log(window.location.origin);
    $('form[id="reset"]').validate({ 
        rules: {
            c_password: {
                required: true,
                minlength: 8,
                maxlength: 12,
                equalTo : class_password,
            },
            password: {
                required: true,
                minlength: 8,
                maxlength: 12,
            }
        },
        messages: {  
            c_password: {
                required: 'This field is required',
                minlength: 'Password must be at least 8 characters long' ,
                maxlength: 'Maximum 12 characters accepted',
                equalTo : 'Make shure your password and conform password are same'
            },
            password: {  
                required: 'Please enter password',
                minlength: 'Password must be at least 8 characters long' ,
                maxlength: 'Maximum 12 characters accepted'
            }  
        },  
        submitHandler: function(form) {  
            var email = $(class_email).val();    var password = $(class_password).val(); 

            $.ajax({
                type: 'POST',
                url: 'api/reset',
                data: {
                    username: email,
                    password: password,
                },
                dataType: 'json',
                error:function(error){
                    swal(error);
                },
                success: function(result){
                    
                    if(result.status == 1){
                        swal({
                            title: "Success!!!", 
                            text: result.msg, 
                            icon: "success",
                        }).then((willDelete) => {
                            if(willDelete){
                                $('#reset').trigger("reset");
                                window.location.replace(window.location.origin);
                            }
                        });
                    }else if(result.status == 0){
                        swal("Error!!", result.msg, "error");
                    }
                }
            });
        }  
    });
})
