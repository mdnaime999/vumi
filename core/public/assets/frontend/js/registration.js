$(function (){
    jQuery.validator.addMethod(
        "regex",
        function(value, element, regexp) {
            if (regexp.constructor != RegExp)
                regexp = new RegExp(regexp);
            else if (regexp.global)
                regexp.lastIndex = 0;
            return this.optional(element) || regexp.test(value);
        },
    );
})

function registrationsubmit(){
    $("#userRegistration").validate({
        rules: {
            name: {
                required: true,
                minlength: 3
            },
            email: {
                required: true,
                minlength: 3,
                email:true,
            },
            phone: {
                required: true,
                minlength: 10
            },
            gender: {
                required: true,
            },
            password: {
                required: true,
                minlength: 8
            },
            confirm_password:{
                required:true,
                equalTo : "#password"
            }

        },
        onfocusout: function(element) {
            this.element(element); // triggers validation
        },
        onkeyup: function(element, event) {
            this.element(element); // triggers validation
        },
        messages: {
            name: {
                required: "Enter your Name",
                minlength: "Name contains at least 3 characters"
            },
            email: {
                required: "Enter your Email",
                minlength: "Email at least 3 characters",
                email:"Enter valid email"
            },
            phone: {
                required: "Enter your Phone",
                minlength: "phone required at least 10 characters"
            },
            password: {
                required: "Enter your Password",
                minlength: "password must contain at least 8 characters"
            },
            confirm_password: {
                required: "Enter your Confirm Password",
                equalTo: "Confirm password must be same as Password"
            }
        },
        submitHandler: function (form,e) {
            e.preventDefault();
            var data = new FormData($("#userRegistration")[0]);
            $.ajax({
                url: "/user_registration",
                method: "post",
                data: data,
                dataType: "json",
                processData: false,
                  contentType: false,
                  async: false,
                  cache: false,
                beforeSend: function(){
                    $("#overlay").fadeIn(300);　
                    var loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i> loading...';
                        if ($("#user_btn").html() !== loadingText) {
                        $("#user_btn").data('original-text', $("#user_btn").html());
                        $("#user_btn").html(loadingText);
                        }
                  },
                  complete: function(){
                    setTimeout(function(){
                        // $("#overlay").fadeOut(300);
                      },500);
                  },

                success:function (response) {
                    console.log(response);
                    if(response.success == 1){
                        $("#overlay").fadeOut(300);
                        window.location.href = "/login";
                    }

                },
                error: function(response) {
                    $("#user_btn").html('submit');
                    alert(response);
                }
            })
        }
    });
}


function emailCheck(email)
{
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: 'email_check',
        method: "post",
        dataType: "json",
        data: {email,email},
        success:function(response){
            if(response == "success"){
                $("#email").parent().children(".error").remove();
                $("#email").after('<label class="error">Email Already Taken</label>');
                $("#user_btn").attr("disabled",true);
            }
            else{
                $("#user_btn").attr("disabled",false);
                $("#email").parent().children(".error").remove();
            }
        }
    })
}
function phoneCheck(phone)
{
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: 'phone_check',
        method: "post",
        dataType: "json",
        data: {phone,phone},
        success:function(response){
            if(response == "success"){
                $("#phone").parent().children(".error").remove();
                $("#phone").after('<label class="error">Phone Number Already Taken</label>');
                $("#user_btn").attr("disabled",true);
            }
            else{
                $("#user_btn").attr("disabled",false);
                $("#phone").parent().children(".error").remove();
            }
        }
    })
}

// function uploadimage(src){
//     $("#upload_img").attr("src",src);
// }
function uploadimage(input) {
    var img_preview_id = input.id + '_preview';
    if (input.files && input.files[0]) {
        //image type validation
        var mime_type = input.files[0].type;
        if (!(mime_type == 'image/jpeg' || mime_type == 'image/jpg' || mime_type == 'image/png' || mime_type == 'image/webp')) {
            input.value = '';
            Swal.fire({
                title: 'Oops...',
                text: 'Invalid image format! Only JPEG or JPG or PNG image types are allowed.',
                icon: 'warning'
            })
            return false;
        }
        //image size validation
        var max_size = 2;
        var file_size = parseFloat(input.files[0].size / (1024 * 1024)).toFixed(1); // MB calculation
        if (file_size > max_size) {
            input.value = '';
            Swal.fire({
                title: 'Oops...',
                text: 'Max file size ' + max_size + ' MB. You have uploaded ' + file_size + ' MB.',
                icon: 'warning'
            })
            return false;
        }
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#' + "upload_img").attr('src', e.target.result);
            $('#' + img_preview_id).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}

function myPasswordFunction(data) {
    var x = document.getElementById("password");
    if (x.type === "password") {
        x.type = "text";
        $(data).removeClass("fa-eye-slash");
        $(data).addClass("fa-eye");
    } else {
        x.type = "password";
        $(data).addClass("fa-eye-slash");
        $(data).removeClass("fa-eye");
    }
}
function myPasswordFunction2(data) {
    var x = document.getElementById("confirm_password");
    if (x.type === "password") {
        x.type = "text";
        $(data).removeClass("fa-eye-slash");
        $(data).addClass("fa-eye");
    } else {
        x.type = "password";
        $(data).addClass("fa-eye-slash");
        $(data).removeClass("fa-eye");
    }
}