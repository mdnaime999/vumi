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
    $(".image-uploader").on("dragleave", function (event) {
        event.preventDefault();
        console.log("drag peyechi");
        event.originalEvent.dataTransfer.dropEffect = "none"; // Shows the "forbidden" image
    });
})
function productsubmit(){
    // $('.alert').setTimeout(function() {
    // }, 1000);

    $("#frmCheckout").validate({
        rules: {
            name: {
                required: true,
                minlength: 3
            },
            short_description:{
                required:true,
            },
            description:{
                required:true,
            },
            price:{
                required:true,
            },
            previous_price:{
                required:true,
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
                required: "Enter Product Name",
                minlength: "Name requires at least 3 characters"
            },
            short_description: {
                required: "Enter product short_description",
            },
            description: {
                required: "Enter product description",
            },
            price: {
                required: "Enter product price"
            },
            previous_price: {
                required: "Enter product previous price"
            },
        },
    });
}
function imageUpload(input) {
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
            $('#' + "show_photo").attr('src', e.target.result);
            $('#' + img_preview_id).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}

function getEpisodeform(data){
    if(data == "yes"){
        $("#default_episode").css("display","block");
    }
    else{
        $("#default_episode").css("display","none");
    }
}

function GetEpisodeRow(data){
    console.log("for episode row")
    var html_data = $("#episode_row").html();
    $(data).parent().parent().children(".row").last().after(html_data);
}
function DeleteEpisodeRow(data){
    $(data).parent().parent().remove();
}

