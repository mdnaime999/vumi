$(function(){
    getCountCartItem();
})

function getCountCartItem(){
    $.ajax({
        url: '/get_count_cart_items',
        method: 'get',
        dataType: 'json',
        success:function(response){
            if(response.success == 1){
                $(".cart_item_no").html(response.no_items);
            }
            else{

            }
        }
    })
}
function getCarts(type)
{
    $("#empty_data").css("display","none");
    $.ajax({
        url: '/get_cart_items',
        method: 'get',
        dataType: 'json',
        data:{type:type},
        success:function(response){
            if(response.success == 1){
                getCountCartItem();
                if(type == "cart"){
                    $(".cart_data").html(response.cart);
                }
                else{
                    $("#checkout_data").html(response.cart);
                }
            }
            else{
                $("#empty_data").css("display","block");
            }
        }
    })
}

function removeCartItem(id,type)
{
    $.ajax({
        url: '/remove_cart_item',
        method: 'get',
        dataType: 'json',
        data: {id:id},
        success:function(response){
            if(response.success == 1){
                getCarts(type);
                // $("#alert_message").append(response.message).css("display","block");
                // setTimeout(function() {
                //     $("#alert_message").css("display","none");
                // }, 2000);
                toastr.success("Cart Item has been removed successfully");
            }
            else{

            }
        }
    })
}
function Addtocart(id){
    let quantity = 1;
    let price = $("#product_price").val();
    $.ajax({
      url: '/add_to_cart',
      method:'get',
      dataType: 'json',
      data: {product_id:id,price:price,quantity:quantity},
      success:function(response){
        if(response.success == 1){
            getCountCartItem();
            $(".cart_btn").css("display","none");
            toastr.success("Cart Item has been added Successfully");
        }
        else if(response.error == 1){
            $("#alert_message").css("display","block");
            $('html, body').animate({ scrollTop: $("#alert_message").offset().top - 50 }, 'slow');
        }
        else{

        }
      }
    })
  }
