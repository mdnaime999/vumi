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
function categorysubmit(){
    // $('.alert').setTimeout(function() {
    // }, 1000);

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
            mobile:{
                required:true,
                digit: true
            },
            date_of_birth:{
                required:true,
                maxlength: 10
            },
            gender:{
                required:true,
            },
            religion:{
                required:true,
            },
            address:{
                required:true,
                maxlength: 255
            },
            nid:{
                required:true,
                maxlength: 17
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
            date_of_birth: {
                required: "Please Select your Date of Birth",
                maxlength: "Invalid Date Format"
            },
            mobile:{
                required: "Enter your Contact number",
                digit: "contact number cannot be string"
            },
            gender: {
                required: "Select your gender"
            },
            religion: {
                required: "Select your religion"
            },
            address: {
                required: "Enter your Address",
                maxlength: "Address cannot be more than 255 characters"
            },
            nid: {
                required: "Enter your Nid no",
                maxlength: "Nid cannot be more than 17 characters",
                digit: "invalid nid number"
            }
        },
    });
}
//preview image before upload
function imageUpload(input) {
    var img_preview_id = input.id + '_preview';
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
