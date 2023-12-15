$(".mobile-menu-toggle").click(function (event) {
    event.preventDefault();
    $('body').toggleClass('menu-active');
    $('html').toggleClass('menu-active');
});


$(".trigger_signup-login").click(function (event) {
    event.preventDefault();
    if ($(this).parent().hasClass('menu-login')) {
        $('body').toggleClass('login-active');
        $('html').toggleClass('login-active');
    } else {
        $('body').toggleClass('signup-active');
        $('html').toggleClass('signup-active');
    }
});

$(".switch_signup-login").click(function (event) {
    event.preventDefault();
    if ($(this).parent().hasClass('menu-login')) {
        $('body').addClass('login-active');
        $('html').addClass('login-active');
        $('body').removeClass('signup-active');
        $('html').removeClass('signup-active');
    } else {
        $('body').addClass('signup-active');
        $('html').addClass('signup-active');
        $('body').removeClass('login-active');
        $('html').removeClass('login-active');
    }
});

$(".switch_signup").click(function (event) {
    event.preventDefault();
    $('body').addClass('signup-active');
    $('html').addClass('signup-active');
    $('body').removeClass('login-active');
    $('html').removeClass('login-active');
    $('body').removeClass('forgotten-active');
    $('html').removeClass('forgotten-active');
});
$(".switch_login").click(function (event) {
    event.preventDefault();
    $('body').addClass('login-active');
    $('html').addClass('login-active');
    $('body').removeClass('signup-active');
    $('html').removeClass('signup-active');
    $('body').removeClass('forgotten-active');
    $('html').removeClass('forgotten-active');
});
$(".switch_forgotten").click(function (event) {
    event.preventDefault();
    $('body').addClass('forgotten-active');
    $('html').addClass('forgotten-active');
    $('body').removeClass('signup-active');
    $('html').removeClass('signup-active');
    $('body').removeClass('login-active');
    $('html').removeClass('login-active');
});

$(".toggle-filter").on('click', function (event) {
    event.preventDefault();
    var showTitle = $(this).data('title-show');
    var hideTitle = $(this).data('title-hide');
    if ($(".filter_by").length > 0) {
        $(this).html('(' + hideTitle + ')');
        $(".filter_by").removeClass('filter_by');
    } else {
        $(this).html('(' + showTitle + ')');
        $(".two-column-left-filters > form > h3").addClass('filter_by');
        $(".two-column-left-filters > form > div").addClass('filter_by');
    }
});


$(".trigger_registered--close").click(function (event) {
    event.preventDefault();
    if ($('body').hasClass('user_registered')) {
        $('body').removeClass('user_registered');
    }
});

$("a.detail-read-more").click(function (event) {
    event.preventDefault();
    $(this).siblings('.detail-text').removeClass('cropped');
    $(this).hide();
});

if($('.submenu-trigger > a').length > 0) {
    $('.submenu-trigger > a').on('click', function(event){
        event.preventDefault();
        if($(this).parent().children('.arrow_box').hasClass('active')) {
            $(this).parent().children('.arrow_box').removeClass('active');
            $(this).parent().children('.fa-caret-up').hide();
            $(this).parent().children('.fa-caret-down').show();
        } else {
            $(this).parent().children('.arrow_box').addClass('active');
            $(this).parent().children('.fa-caret-down').hide();
            $(this).parent().children('.fa-caret-up').show();
        }
    });
}
