function filterproduct(){
    let short_by = $("#short").val();
    let category = [];
    let min = $("#lower").val();
    let max = $("#upper").val();
    let all = $('input[name="all_category"]:checked').val();
    $("input[name='category[]']").each(function (index, obj) {
        // loop all checked items
        if($(this).is(":checked")){
            category.push($(this).val());
        }
    });
    console.log("category peyechi",category,all,min,max,short_by);
    
    $.ajax({
        url: '/get_filter_products',
        cache:false,
        method: 'get',
        dataType: 'json',
        data: {short_by:short_by,category:category,all:all,min:min,max:max},
        beforeSend: function(){
            $("#loading").fadeIn(300);
        },
        complete: function(){
            setTimeout(function(){
                $("#loading").fadeOut(300);
            },500);
        },
        success:function(response){
            if(response.success == 1){
                $("#product_list").html("");
                $("#product_list").html(response.products);
            }
        }
    })
}

function setupperval(data){
    let low = $("#lower").val();
    let max = $("#upper").val();
    if (max < low + 4) {
        $("#upper").val(parseInt(max) - 4);
        if (low == $("#lower").attr("min")) {
            $("#upper").val(4);
        }
    }
    $('#two').val($(data).val());
}

function setlowerval(data){
    let low = $("#lower").val();
    let max = $("#upper").val();
    if (low > max - 4) {
        $("#upper").val(parseInt(low) + 4);
        if (max == $("#upper").attr("max")) {
            $("#lower").val(parseInt(max) - 4);
        }
    }
    $('#one').val($(data).val());
}

function searchproduct(value){
    let type = $("#type").val();
    $.ajax({
        url: '/get_search_products',
        method: 'get',
        dataType: 'json',
        data:{value:value,type:type},
        success:function(response){
            if(response.success == 1){
                $("#product_list").html(response.products);
            }
        }
    })
}