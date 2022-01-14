$(function(){
    var class_email = '#exampleInputEmail1'; var class_password = '#exampleInputPassword1';
    console.log(window.location.origin);
    $('form[id="login"]').validate({ 
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 8,
                maxlength: 12,
            }
        },
        messages: {  
            email: {
                required: 'This field is required',
                email: 'This is not a valid email',
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
                url: window.location.origin+'/pdf/api/login',
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
                                $('#login').trigger("reset");
                                window.location.replace(result.url);
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
