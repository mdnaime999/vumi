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

function usersubmit(){
    $("#frmCheckout").validate({
        rules: {
            name: {
                required: true,
                minlength: 3
            },
            email:{
                required:true,
                email: true
            },
            type:{
                required: true,
            },
            password:{
                required:true,
                minlength: 8,
            },
            confirm_password:{
                required:true,
                minlength: 8,
                equalTo: "#password"
            },

        },
        onfocusout: function(element) {
            this.element(element); // triggers validation
        },
        onkeyup: function(element, event) {
            this.element(element); // triggers validation
        },
        messages: {
            name: {
                required: "Please enter your Name",
                minlength: "Name requires at least 3 characters"
            },
            email: {
                required: "Please enter your Email",
                email: "Enter Valid Email"
            },
            password:{
                required: "Enter your Password",
                minlength: "password must contain at least 8 characters"
            },
            confirm_password:{
                required: "Enter your Confirm Password",
                minlength: "confirm password must contain at least 8 characters",
                equalTo: "Confirm password must be same as password"
            },
            type:{
                required: "Select User Type"
            }
        },
    });
}
function imageUpload(input) {

    var img_preview_id = input.id + '_preview';
    console.log(img_preview_id);
    if (input.files && input.files[0]) {
        //image type validation
        var mime_type = input.files[0].type;
        if (!(mime_type == 'image/jpeg' || mime_type == 'image/jpg' || mime_type == 'image/png')) {
            input.value = '';
            Swal.fire({
                title: 'Oops...',
                text: 'Invalid image format! Only JPEG or JPG or PNG image types are allowed.',
                icon: 'warning'
            })
            return false;
        }
        //image size validation
        var max_size = .3;
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
            $('#' + "show_photo").attr('src', e.target.result);
            $('#' + img_preview_id).attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}
