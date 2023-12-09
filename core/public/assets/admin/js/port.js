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
function portsubmit() {
    $("#frmCheckout").validate({
        rules: {
            port_name: {
                required: true,
            },
            district:{
                required: true,
                number: true,
            },
            district:{
                required:false,
            },
            status:{
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
            port_name: {
                required: "বন্দর এর নাম লিখুন ",
            },
            district: {
                required: "জেলার নাম লিখুন",
            },
            status:{
                required: "স্ট্যাটাস নির্বাচন করুন"
            }
        },
    });
}
