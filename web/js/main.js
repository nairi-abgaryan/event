
/*Navigation bar*/

$(window).scroll(function() {
    if ($(".navbar").offset().top > 50) {
        $(".navbar-fixed-top").addClass("top-nav-collapse");
    } else {
        $(".navbar-fixed-top").removeClass("top-nav-collapse");
    }
    var wScroll = $(this).scrollTop();

    $('.head').css({
        'transform':'translate(0px, '+ wScroll /2 +'%)'
    });
});

$(function() {
    $('a.page-scroll').bind('click', function(event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top
        }, 1500, 'easeInOutExpo');
        event.preventDefault();
    });
});

/***************************** Add new product row *****************/

$(document).ready(function () {
    $('#add-row').on('click', function() {
        $('#add-row').before("<div class='added'><form class='form-inline'><div class='form-group'><input type='text' id='product' /></div><div class='form-group'><input style='margin-left: 4px;' type='text' id='qty'/></div> <div class='form-group'> <select name='sizes' class='choose-size' style='margin-top: 0;'> <option disabled selected >Չ․միավոր</option> <option value=''>հատ</option> <option value=''>ք/մ</option> <option value=''>կգ</option> </select> </div><div class='form-group'><a href='#'><button style='margin-bottom: 23px; margin-left: 4px;' class='upload-image'>Նկար</button></a> </div><div class='form-group'><button type='button' style='margin-left: 4px;' class='remove-row'>X</button></div></form></div>");

    });
    $('.create-tender').on('click', '.remove-row', function() {
        $(this).parents()[2].remove()
    })

});

/************************** Login and Sign up show and hide *******************************/

$(function () {
    $('.reg').on('click', function (e) {
        e.preventDefault();
        $('#login').hide();
        $('#signup').show().addClass('animated fadeIn');
    })
});

$(function () {
    $('.log-in').on('click', function (e) {
        e.preventDefault();
        $('#login').show().addClass('animated fadeIn');
        $('#signup').hide()
    })
});


/************************** Hide uplaod image based on category change *******************************/

$("#select_category").change(function(){
    if($(this).val()=== "աշխատանք" || $(this).val()=== "ծառայություն")
    {
        $(".products").hide();
        $("#add-row").hide()
    }
    else
    {
        $(".products").show();
        $("#add-row").show()
    }
});



/*************************************************************************************/

/*Navbar Collapse*/
$(document).ready(function (){
    $('.nav a').on('click', function() {
        $('.navbar-collapse').collapse('hide');
    });
});
/*************************************************************************************/

/***** On Click navbar toggle change to cross sign***/
$(document).ready(function (){
    $( ".navbar-toggle" )
        .on( "click", function() {
            $(this).toggleClass( "active" );
        });
    $('.nav a').on('click', function() {
        $(".navbar-toggle" ).removeClass("active");
    });
});

/*************************************************************************************/