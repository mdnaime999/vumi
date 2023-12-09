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
function classificationSubmit() {
    $("#frmCheckout").validate({
        rules: {
            name: {
                required: true,
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
            name: {
                required: " নাম লিখুন ",
            },
            status:{
                required: "স্ট্যাটাস নির্বাচন করুন"
            }
        },
    });
}
