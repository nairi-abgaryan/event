/*my_product_price page*/
$(document).ready(function () {
    $(".accept-price").on("click", function () {
        $(".accept-price").html("Հաստատել");
        $(".accept-price").css({"background":"#007f00","border":"none"});

        $(this).html("Հաստատված");
        $(this).css({"background":"red","border":"none"});
        var url = $(this).attr("data");
        $(".done").attr("href",url);
    });

    $(".end-price").on("click",function () {
        if(!$(".done").attr("href")){
            $("#cancel").remove();
            return window.location.replace($(this).attr("data-url"));
        }
    });
});

/** Search function **/
$(document).on("ready", function () {
    $(".search_category label").after("<br />");
    $(".search").on("click",function () {
        var $inputs = $('.search-form :input');

        var values = {};
        $inputs.each(function() {
            values[this.name] = $(this).val();
        });
    });
});


$(".delete-property").on("click", function () {
     var url = $(this).attr("data-url");
     $(".accept-tender").attr("data-url",url);
});

$(".cancel-tender").on("click",function () {
    $('.modal').modal('toggle');
})

$(".accept-tender").on("click",function () {
    var url =$(this).attr("data-url");
    window.location.replace(url);
});

$(".delete-my-share-property").on("click", function () {
     var url = $(this).attr("data-url");
     $(".accept-my-list-delete").attr("data-url",url);
});

$(".accept-my-list-delete").on("click",function () {
    var url =$(this).attr("data-url");
    window.location.replace(url);
});

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
    var i = 2;

    $('#add-row').on('click', function() {
        var newaddress = $(".products").eq(0).clone();

        newaddress.find('input').each(function() {
            this.name= this.name.replace('[1]', '['+i+']');
            this.name= this.name.replace('[image]', '[image'+i+']');
        });

        newaddress.find('select').each(function() {
            this.name= this.name.replace('[type]', '['+i+'][type]');
        });

        $('#add-row').before(newaddress);
        i++;
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
    });
});

$(function () {
    $('.log-in').on('click', function (e) {
        e.preventDefault();
        $('#login').show().addClass('animated fadeIn');
        $('#signup').hide()
    })
});


/************************** Hide uplaod image based on category change *******************************/

$("#select_type").change(function(){
    if($(this).val()=== "2" || $(this).val()=== "3")
    {
        $(".products").show();
        $("#add-row").hide();
        $(".added").remove();
    }
    else
    {
        $(".service").hide();
        $(".select_service").val('');
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