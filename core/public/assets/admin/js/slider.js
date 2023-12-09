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
function formatState(state) {
    if (!state.id) {
        return state.text;
    }
    var $state = $(
        '<span><span class="size-15px d-inline-block mr-2 rounded border" style="background-color: ' + state.element.value + ';height:15px;width:20px;">' + "" + '</span>' + state.element.id.split('#')[1] + '</span>'
    );
    return $state;
};

$(".color_select2").select2({
    templateResult: formatState,
    templateSelection: formatState
});
function slidersubmit(){
    // $('.alert').setTimeout(function() {
    // }, 1000);

    $("#frmCheckout").validate({
        rules: {
            title: {
                required: true,
                minlength: 3
            },
            
            description:{
                required:true,
            },
            btn_color:{
                required:true,
            },
            btn_background_color:{
                required:true,
            },
            background_color:{
                required:true,
            }
        },
        onfocusout: function(element) {
            this.element(element); // triggers validation
        },
        onkeyup: function(element, event) {
            this.element(element); // triggers validation
        },
        messages: {
            title: {
                required: "Enter title",
                minlength: "Title requires at least 3 characters"
            },
            description: {
                required: "Enter sub_title",
            },
            btn_color: {
                required: "Select Btn Color",
            },
            btn_background_color: {
                required: "Select Btn Background Color",
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
            $('#' + "show_photo").attr('src', e.target.result);
            $('#' + img_preview_id).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}
