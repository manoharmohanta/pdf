$(function(){
    var class_email = '#exampleInputEmail1'; var class_password = '#exampleInputPassword1';
    var class_username = '#exampleInputUsername1'; var class_country = '#exampleFormControlSelect2';
    // console.log(window.location.origin);
    $('form[id="register"]').validate({ 
        rules: {
            email: {
                required: true,
                email: true
            },
            username: {
                required: true,
                minlength: 8,
                maxlength: 12,
            },
            country: {
                required: true,
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
            },
            username: {  
                required: 'Please enter username',
                minlength: 'Username must be at least 8 characters long' ,
                maxlength: 'Maximum 12 characters accepted',
            },
            country: {
                required: 'Please seect Country',
            },
        },  
        submitHandler: function(form) {  
            var email = $(class_email).val();    var password = $(class_password).val(); 
            var username = $(class_username).val();    var country = $(class_country).val(); 

            $.ajax({
                type: 'POST',
                url: window.location.origin+'/pdf/api/register',
                data: {
                    email: email,
                    password: password,
                    username: username,
                    country: country,
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
        }  
    });
})
