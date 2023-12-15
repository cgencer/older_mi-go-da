$(".mobile-menu-toggle").click(function (event) {
    event.preventDefault();
    $('body').toggleClass('menu-active');
    $('html').toggleClass('menu-active');
});

$(".signup-login_close").click(function (event) {
    event.preventDefault();
    $('body').removeClass('login-active');
    $('html').removeClass('login-active');
    $('body').removeClass('signup-active');
    $('html').removeClass('signup-active');
    $('body').removeClass('forgotten-active');
    $('html').removeClass('forgotten-active');

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

function formattedDate(date) {
    var mnt = date.getMonth() + 1;
    var day = date.getDate();
    var yer = date.getFullYear();
    if (mnt < 10) mnt = '0' + mnt;
    if (day < 10) day = '0' + day;

    return yer + '-' + mnt + '-' + day;
}

function printFormattedDate(date, elemClass, lang) {
    if (typeof(lang) === 'undefined') lang = 'en';
    $('a.' + elemClass).html($('#date-picker').datepicker().data('datepicker').formatDate('D,M d', new Date(date)));
}

function calculateRoomTotal() {
    var total = parseInt($('#guests_adult').val()) + parseInt($('#guests_child').val());
    var pricePerPerson = $('#total_price').data('price-per-person');

    var date_checkin = new Date($('#date_checkin').val());
    var date_checkout = new Date($('#date_checkout').val());
    var timeDiff = Math.abs(date_checkout.getTime() - date_checkin.getTime());
    var calculated_days = Math.ceil(timeDiff / (1000 * 3600 * 24));

    $('#calculated_price').html(pricePerPerson * calculated_days * total);
    $('#calculated_days').html((Math.ceil(total / 2) * calculated_days));
}

function checkDates() {
    if ($('#date_checkin').val() == $('#date_checkout').val()) {

        var startDay = new Date($('#date_checkin').val());
        var nextDay = new Date();
        nextDay.setDate(startDay.getDate() + 1);

        $('#date_checkout').val(formattedDate(nextDay));
        //$('#date_checkout').datepicker('update', formattedDate(nextDay));
    }
}

var today = new Date();

$('#date-picker').datepicker({
    language: "en",
    range: true,
    dateFormat: 'yyyy-mm-dd',
    inline: true,
    startDate: today,
    onRenderCell: function (date, cellType) {
        if (cellType == 'day') {
            isDisabled = (today > date) ? true : false;

            return {
                disabled: isDisabled
            }
        }
    },
    onSelect: function(selectedDate, date, inst){

        var dates = selectedDate.split(',');

        if(typeof(dates[0]) !== 'undefined') {
            //first date
            printFormattedDate(dates[0], 'checkin');
            $('#date_checkin').val(dates[0]);
        }

        if(typeof(dates[1]) !== 'undefined') {
            //second date
            printFormattedDate(dates[1], 'checkout');
            $('#date_checkout').val(dates[1]);

            $('.dates-wrapper-outer').removeClass('picker-visible');
            //$('#date-picker').datepicker().data('datepicker').hide();
        } else {
            var startDay = new Date($('#date_checkin').val());
            var nextDay = new Date();
            nextDay.setDate(startDay.getDate() + 1);

            printFormattedDate(formattedDate(nextDay), 'checkout');
            $('#date_checkout').val(formattedDate(nextDay));
        }

        checkDates();
        calculateRoomTotal();

    }
});

$('#date-picker').css('display', 'none');

$('.dates-wrapper h4 a.checkin').on('click', function (event) {
    event.preventDefault();

    $('.dates-wrapper-outer').addClass('picker-visible');
    //$('#date-picker').datepicker().data('datepicker').show();

})

$('.dates-wrapper h4 a.checkout').on('click', function (event) {
    event.preventDefault();

    $('.dates-wrapper-outer').addClass('picker-visible');
    //$('#date-picker').datepicker().data('datepicker').show();
});

$('.more-filter').on('click', function (event) {
    event.preventDefault();
    $(this).siblings('.hidden-filter').removeClass('hidden-filter');
    $(this).addClass('hidden-filter');
});

$('#guests_child').on('change', function (event) {
    calculateRoomTotal();
});

$('#guests_adult').on('change', function (event) {
    calculateRoomTotal();
});

var filtersForm = $('#filters-form');
if (filtersForm.length > 0) {
    filtersForm.find('input[type=checkbox]').on('change', function (event) {
//        filtersForm.submit();
    });

    $('.filter-query').keydown(function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
//            filtersForm.submit();
        }
    })
}

var categoriesBoxes = $('.category-content');
if(categoriesBoxes.length > 0) {
    categoriesBoxes.on('click', function(event){
        var url = $(this).data('category-url');
//        location.href = url;
    });
}

var addToWishlist = $('.add-to-wishlist');
if(addToWishlist.length > 0) {
    addToWishlist.on('click', function(event){
        event.preventDefault();
        var url = $(this).attr('href');
        var btn = $(this);

        $.ajax({
            dataType: "json",
            url: url,
            success: function (returnData) {
                if(returnData.result) {
                    if(returnData.added) {
                        btn.removeClass('mg-secondary-button').addClass('mg-primary-button');
                    } else {
                        btn.removeClass('mg-primary-button').addClass('mg-secondary-button');
                    }
                }
            }
        });

    });
}

/*
var paginationLink = $('.paginiaton-link');
if(paginationLink.length > 0) {
    paginationLink.on('click', function(event){
        event.preventDefault();
        var pageId = $(this).data('page-id');

        var filtersForm = $('#filters-form');
        filtersForm.find('[name="page"]').val(pageId);
        filtersForm.submit();
    });
}
*/


$("#addCouponsModalCenter .coupon_field").on('input', function () {
    if ($(this).val().length == $(this).attr('maxlength')) {
        $(this).next().focus();
    }
    checkIfAllValid();
});

function checkIfAllValid() {
    var allValid = true;
    $('#addCouponsModalCenter .coupon_field').each(function () {
        if ($(this).val() === '') allValid = false;
    });

    if (allValid) {
        $('#addCouponsModalCenter .addCouponsModalButton').removeAttr('disabled').removeClass('mg-primary-button__disabled').addClass('mg-primary-button');
        $('#addCouponsModalCenter .coupon_fields .validate_coupon').addClass('valid_coupon').removeClass('invalid_coupon');
    } else {
        $('#addCouponsModalCenter .addCouponsModalButton').attr('disabled', 'disabled').removeClass('mg-primary-button').addClass('mg-primary-button__disabled');
        $('#addCouponsModalCenter .coupon_fields .validate_coupon').addClass('invalid_coupon').removeClass('valid_coupon');
    }
}

function generateCouponTextDiv(coupon) {

    //coupon = coupon.replace(/(.{4})/g,"$1\-").slice(0, -1);

    var couponTextdiv = $('<div/>');

    for (i = 0; i < coupon.length; i++) {
        couponTextdiv.append('<input type="text" value="' + coupon[i] + '" disabled="disabled" /> ');
    }

    couponTextdiv.append('<span class="validate_coupon valid_coupon"><i class="fas fa-check"></i></span>');

    return couponTextdiv;
}

function getValidBookingCoupons() {

    var coupons_needed = $('#coupons_needed').val();

    $.ajax({
        dataType: "json",
        url: urlGetCoupons,
        success: function (returnData) {
            var validCoupons = returnData.valid.length;
            $('#coupons_valid').html(validCoupons);

            if(validCoupons >= coupons_needed) {
                $('#bookingRequestButton').addClass('mg-primary-button').removeClass('mg-primary-button__disabled').removeAttr('disabled', 'disabled');
                $('#book-bottom-passive').addClass('hidden');
                $('#book-bottom-active').removeClass('hidden');

            } else {
                $('#bookingRequestButton').removeClass('mg-primary-button').addClass('mg-primary-button__disabled').attr('disabled', 'disabled');
                $('#book-bottom-active').addClass('hidden');
                $('#book-bottom-passive').removeClass('hidden');
            }

        }
    });
}

function getValidBookingCouponsProfile() {

    $.ajax({
        dataType: "json",
        url: urlGetCoupons,
        success: function (returnData) {
            var validCoupons = returnData.valid.length;
            var usedCoupons = returnData.used;

            if(parseInt(validCoupons) < 10) {
                validCoupons = '0' + validCoupons;
            }
            if(parseInt(usedCoupons) < 10) {
                usedCoupons = '0' + usedCoupons;
            }
            $('.coupons_valid').html(validCoupons);
            $('.coupons_used').html(usedCoupons);
        }
    });
}

if($('.coupons_valid').length > 0) {
    getValidBookingCouponsProfile();
}

if ($(".addCouponsModalButton").length > 0) {
    $(".addCouponsModalButton").on('click', function (event) {

        event.preventDefault();

        var coupon_code = '';
        $('#addCouponsModalCenter .coupon_field').each(function () {
            coupon_code += $(this).val();
        });
        var data = {'coupon_code': coupon_code}

        $.ajax({
            dataType: "json",
            url: urlAddCoupon,
            data: data,
            success: function (returnData) {
                if (returnData.result == false) {
                    $('#addCouponsModalCenter .coupons_error').css('display', 'block');

                } else {
                    $('#addCouponsModalCenter .coupons_error').css('display', 'none');
                    $('#addCouponsModalCenter .coupon_field').val('');
                    $('#addCouponsModalCenter .coupons_added').css('display', 'block');
                    $('#addCouponsModalCenter .coupons_added').append(generateCouponTextDiv(coupon_code));
                    $('#addCouponsModalCenter .addCouponsModalButton').attr('disabled', 'disabled').removeClass('mg-primary-button').addClass('mg-primary-button__disabled');
                    $('#addCouponsModalCenter .coupon_fields .validate_coupon').addClass('invalid_coupon').removeClass('valid_coupon');

                    if($('.booking-details').length > 0) {
                        getValidBookingCoupons();
                    }

                    if($('.profile-menu-bottom').length > 0) {
                        getValidBookingCouponsProfile();
                    }
                }
            }
        });
    })
}

$('.backButton').on('click', function(event){
    event.preventDefault();
    var backUrl = $(this).data('previous-url');
    location.href = backUrl;
});

var sliderDelay = 1000;
var sliderTimer = null;
if($(".price-slider").length > 0) {

    $(".price-slider").slider({});

    $(".price-slider").on("slide", function(slideEvt) {

        if(sliderTimer !== null) {
            clearTimeout(sliderTimer);
        }

        $('#start-price').val(slideEvt.value[0]);
        $('#end-price').val(slideEvt.value[1]);
        $('#start-price-text').html(parseInt(slideEvt.value[0] * parseFloat($(this).data('slider-rate'))));
        $('#end-price-text').html(parseInt(slideEvt.value[1] * parseFloat($(this).data('slider-rate'))));

        sliderTimer = setTimeout(function(){
            // filtersForm.submit();
        }, sliderDelay);
    });

}

function cycleBackgrounds() {
    var index = 0;

    $imageEls = $('.middle-banner_wrapper .slide'); // Get the images to be cycled.

    setInterval(function () {
        // Get the next index.  If at end, restart to the beginning.
        index = index + 1 < $imageEls.length ? index + 1 : 0;

        // Show the next
        $imageEls.eq(index).addClass('show');

        // Hide the previous
        $imageEls.eq(index - 1).removeClass('show');
    }, 5000);
};

function createCookie(name, value, days) {
    var expires;

    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    } else {
        expires = "";
    }
    document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
};

$('.notice-button').on('click', function(event){
    event.preventDefault();
    var cookieId = $(this).data('cookie-id');
    createCookie(cookieId, 1);
    $('#' + cookieId).hide();
});

$('.select-replacement__line1').on('click', function(){
    $(this).parent().toggleClass('active');
});

$('.select-replacement .num_up').on('click', function(event){
    event.preventDefault();
    var currentVal = $(this).siblings('.num_val').html();

    if(currentVal < 8) currentVal++;
    $(this).parents('.select-replacement').find('.num_val').html(currentVal);
    $('#' + $(this).parents('.select-replacement').data('target-field')).val(currentVal).trigger('change');
    return false;
});

$('.select-replacement .num_down').on('click', function(event){
    event.preventDefault();
    var currentVal = $(this).siblings('.num_val').html();

    var limit = 0;
    if($(this).parents('.select-replacement').data('target-field') == 'guests_adult') limit = 1;
    if(currentVal > limit) currentVal--;
    $(this).parents('.select-replacement.active').find('.num_val').html(currentVal);
    $('#' + $(this).parents('.select-replacement').data('target-field')).val(currentVal).trigger('change');
    return false;
});

// Document Ready.
$(function () {
    if($('.middle-banner_wrapper .slide').length > 0) {
        cycleBackgrounds();
    }

    jQuery('.add-another-coupon').click(function (e) {
        var list = jQuery(jQuery(this).attr('data-list'));
        // Try to find the counter of the list or use the length of the list
        var counter = list.data('widget-counter') | list.children().length;

        // grab the prototype template
        var newWidget = list.attr('data-prototype');
        // replace the "__name__" used in the id and name of the prototype
        // with a number that's unique to your emails
        // end name attribute looks like name="contact[emails][2]"
        newWidget = newWidget.replace(/__name__/g, counter);
        // Increase the counter
        counter++;
        // And store it, the length cannot be used if deleting widgets is allowed
        list.data('widget-counter', counter);

        // create a new list element and add it to the list
        var newElem = jQuery(list.attr('data-widget-tags')).html(newWidget);
        newElem.appendTo(list);
    });

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