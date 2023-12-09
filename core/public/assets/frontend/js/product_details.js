$('.slider-for').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    fade: true,
    asNavFor: '.slider-nav'
  });
  $('.slider-nav').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    dots: false,
    nextArrow: '<i class="fas fa-chevron-right slick-next"></i>',
      prevArrow: '<i class="fas fa-chevron-left slick-prev"></i>',
    centerMode: false,
    focusOnSelect: true,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
          infinite: true,
          dots: true
        }
      },
      {
        breakpoint: 700,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }

    ]
  });
  $("#rating_form").submit(function(){
    let user_id = $("#user_id").val();
    if(user_id == '' || user_id == null){
      $("#alert_message").css("display","block");
      $('html, body').animate({ scrollTop: $("#alert_message").offset().top - 50 }, 'slow');
      $("#rating_form")[0].reset();
      return;
    }
    let form_data = $(this).serialize();
    $.ajax({
      url:'/save_user_rating',
      method: 'post',
      data: form_data,
      success:function(response){
        if(response.success == 1){
          $("#rating_form")[0].reset();
          $(".grey-s i").removeClass("fa fa-star");
          $(".grey-s i").addClass("far fa-star");
          toastr.success("Review added successfully");
          $("#review_list").html(response.reviews);
        }
        else{
          $("#alert_message").css("display","block");
          $('html, body').animate({ scrollTop: $("#alert_message").offset().top - 50 }, 'slow');
      $("#rating_form")[0].reset();
        }
      }
    })
  })
  function setStar(data) {
        var id = $(data).attr("name");
        $("#rating").val(id);
        for (var i = 1; i <= 5; i++) {
            if (i <= id) {
                $("#review_icon" + i).removeClass("far fa-star");
                $("#review_icon" + i).removeClass("fa fa-star");
                $("#review_icon" + i).addClass("fa fa-star");
            } else {
                $("#review_icon" + i).removeClass("far fa-star");
                $("#review_icon" + i).removeClass("fa fa-star");
                $("#review_icon" + i).addClass("far fa-star");
            }

        }
    }

  function setvideo(video){
    console.log("amk click kora hoyeche",video);
    $("#video_url").attr("src",video);
    $("#video_main").attr("src",video);
    $("#video_main").load();
    $("#video_main").play();
//     var video = document.getElementById('video_main');
// var source = document.getElementById('video_url');

// source.setAttribute('src', video);

// video.load();
// video.play();

  }
