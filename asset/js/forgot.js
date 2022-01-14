$(function(){
    var class_email = '#exampleInputEmail1';
    console.log(window.location.origin);
    $('form[id="login"]').validate({ 
        rules: {
            email: {
                required: true,
                email: true
            }
        },
        messages: {  
            email: {
                required: 'This field is required',
                email: 'This is not a valid email',
            }, 
        },  
        submitHandler: function(form) {  
            var email = $(class_email).val();

            $.ajax({
                type: 'POST',
                url: window.location.origin+'/pdf/api/forgot',
                data: {
                    email: email,
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
