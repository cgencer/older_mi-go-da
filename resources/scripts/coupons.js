function checkIfAllValid(element) {
    var allValid = true;

    if (!element) {
        element = '#addCouponsModalCenter';
    }

    $(element + ' .coupon_field').each(function () {
        if ($(this).val() === '') allValid = false;
    });

    if (allValid) {
        $(element + ' .addCouponsModalButton').prop('disabled', false).removeClass('mg-primary-button__disabled').addClass('mg-primary-button');
        $(element + ' .coupon_fields .validate_coupon').addClass('valid_coupon').removeClass('invalid_coupon');
        $(element + ' .addCouponsModalButton').addClass('handButton');
        $(element + ' #coupon_status').attr('src', active_tick_img);
    } else {
        $(element + ' .addCouponsModalButton').prop('disabled', true).removeClass('mg-primary-button').addClass('mg-primary-button__disabled');
        $(element + ' .coupon_fields .validate_coupon').addClass('invalid_coupon').removeClass('valid_coupon');
        $(element + ' .addCouponsModalButton').removeClass('handButton');
        $(element + ' #coupon_status').attr('src', pasive_tick_img);
    }
}

function closeProfileMenu() {
    $('header .header-links_wrapper ul.header-links > li.menu-profile div.arrow_box').removeClass('active');
}

function openNewCouponBox() {
    $('.coupon-area').css({'display': 'block'});
    closeProfileMenu();
}

function getValidBookingCoupons() {

    var coupons_needed = $('#coupons_needed').val();

    $.ajax({
        dataType: "json",
        url: urlGetCoupons,
        success: function (returnData) {
            var validCoupons = returnData.valid.length;
            $('#coupons_valid').html(validCoupons);

            if (validCoupons >= coupons_needed) {
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

            if (parseInt(validCoupons) < 10) {
                validCoupons = '0' + validCoupons;
            }
            if (parseInt(usedCoupons) < 10) {
                usedCoupons = '0' + usedCoupons;
            }
            $('.coupons_valid').html(validCoupons);
            $('.coupons_used').html(usedCoupons);
        }
    });
}

function generateCouponTextDiv(coupon) {

    var couponTextdiv = $('<div/>');

    for (i = 0; i < coupon.length; i++) {
        couponTextdiv.append('<input class="coupon_field2" type="text" value="' + coupon[i] + '" disabled="disabled" /> ');
    }

    couponTextdiv.append('<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB0AAAAVBAMAAABI7vhRAAAAAXNSR0IB2cksfwAAACRQTFRFAAAARc8bRs8cR88bRs8cRs8cSM8cRs8cQM8gRc8cRs8bRs8d4vJctQAAAAx0Uk5TADCvn+//QNAQv9+gmoITSwAAAE9JREFUeJxjYEACjMoMKEAkNAFF2jW8AVW6gv7SnQtRpVNDBFB0s4c6oujmKAUqQDa8HagA2XCgAkEUu9tDXVDs5igNRXVaO6rTGDh2I6QBNWobmSup1mQAAAAASUVORK5CYII=" />');

    return couponTextdiv;
}

function checkBookingCoupons() {


    event.preventDefault();

    var coupon_code = '';
    $('#addCouponsModalCenter .coupon_field').each(function () {
        coupon_code += $(this).val();
    });
    var data = {'coupon_code': coupon_code}

    $.ajax({
        dataType: "json",
        url: urlChkCoupons,
        data: data,
        success: function (returnData) {
            if (returnData.result == false) {
                $('#addCouponsModalCenter .coupons_error').css('display', 'block');

            } else {
                $('#addCouponsModalCenter .coupons_error').css('display', 'none');
                $('#addCouponsModalCenter .coupons_notice').css('display', 'block');
                $('#addCouponsModalCenter .coupon_field').val('');
                $('#addCouponsModalCenter .coupon_field').addClass('coupon_checked');
                $('#addCouponsModalCenter .coupons_added').css('display', 'block');
                $('#addCouponsModalCenter .coupons_added').append(generateCouponTextDiv(coupon_code));

                $('#addCouponsModalCenter .addCouponsModalButton').attr('disabled', 'disabled').removeClass('mg-primary-button').addClass('mg-primary-button__disabled');
                $('#addCouponsModalCenter .coupon_fields .validate_coupon').addClass('invalid_coupon').removeClass('valid_coupon');

                if ($('.booking-details').length > 0) {
                    getValidBookingCoupons();
                }

                if ($('.profile-menu-bottom').length > 0) {
                    getValidBookingCouponsProfile();
                }
            }
        }
    });


}


$('.delete_coupon_codes').on('click', function (event) {
    event.preventDefault();
    $('.coupon_field').val('');
    $('.coupons_error').css('display', 'none');
    $('.addCouponsModalButton').addClass('mg-primary-button__disabled').removeClass('mg-primary-button').attr('disabled', 'disabled');
    $('.addCouponsModalButton').addClass('handButton');
    $('.coupon_fields .validate_coupon').addClass('invalid_coupon').removeClass('valid_coupon');
});

$("#addCouponsModalCenter .coupon_field").focus(function () {
    var field = $(this);
    document.addEventListener("keydown", function (event) {
        if (event.keyCode === 8) {
            $(field).val('');
            $("#addCouponsModalCenter .coupon_field").first().focus();
        }
    });
});

$("#addCouponsModalCenter .coupon_field").on('input', function () {
    if ($(this).val().length == $(this).attr('maxlength')) {
        $(this).next().focus();
    }
    checkIfAllValid();
});

$(window).on('shown.bs.modal', function () {
    $('#addCouponsModalCenter .coupons_notice').css('display', 'none');
    $('#addCouponsModalCenter .coupons_error').css('display', 'none');
});
$(window).on('hidden.bs.modal', function () {
    $('#addCouponsModalCenter .coupons_notice').css('display', 'none');
    $('#addCouponsModalCenter .coupons_error').css('display', 'none');
});


if ($('.coupons_valid').length > 0) {
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
                    $('#validation-icons-valid').css('display', 'none');
                    $('#validation-icons-invalid').css('display', 'inline-block');


                } else {
                    $('#addCouponsModalCenter .coupons_error').css('display', 'none');
                    $('#addCouponsModalCenter .coupons_notice').css('display', 'block');
                    $('#addCouponsModalCenter .coupon_field').val('');
                    $('#addCouponsModalCenter .coupons_added').css('display', 'block');
                    $('#addCouponsModalCenter .coupons_added').append(generateCouponTextDiv(coupon_code));
                    $('#addCouponsModalCenter .addCouponsModalButton').attr('disabled', 'disabled').removeClass('mg-primary-button').addClass('mg-primary-button__disabled');
                    $('#addCouponsModalCenter .coupon_fields .validate_coupon').addClass('invalid_coupon').removeClass('valid_coupon');

                    $('#validation-icons-valid').css('display', 'inline-block');
                    $('#validation-icons-invalid').css('display', 'none');

                    if ($('.booking-details').length > 0) {
                        getValidBookingCoupons();
                    }

                    if ($('.profile-menu-bottom').length > 0) {
                        getValidBookingCouponsProfile();
                    }
                }
            }
        });
    })
}


// Yeni slider kupon

$("#coupon_close").on('click', function (event) {
    $('.coupon-area').css('display', 'none');
});
$(".add-more-coupons").on('click', function (event) {
    $('.coupon-area .forms .coupon_fields').css('display', 'block');
    $('.coupon-area .forms .coupons_added').css('display', 'none');
    $('.coupon-area .forms .coupons_added').empty();

    $('#coupon_status').attr('src', pasive_tick_img);
    $('.coupon-area .forms .coupon_fields').removeClass('warning');

    $('.coupon-area .save-coupon').css('display', 'block');
    $('.coupon-area .forms .buttons').css('display', 'none');
});

let coupon_total = 0;

$('body').delegate('.save-coupon', 'click', function (event) {
    event.preventDefault();

    var coupon_code = '';
    $('.coupon-area .coupon_field').each(function () {

        if ($(this).val().length == 0) {
            $('#coupon_status').attr('src', warning_img);
            $('.coupon-area .forms .coupon_fields').addClass('warning');
            $('.coupon-area .coupons_error').css({'display': 'block'});
            $('.coupon-area .coupons_error').html(empty_msg);
            return false;
        } else {
            coupon_code += $(this).val();
        }
    });

    if (coupon_code.length >= 12) {
        var data = {'coupon_code': coupon_code}

        $.ajax({
            dataType: "json",
            url: urlAddCoupon,
            data: data,
            success: function (returnData) {
                if (returnData.result == false) {
                    $('.coupon-area .coupons_error').css('display', 'block');
                    $('.coupon-area .coupons_error').html(error_msg);
                    $('#coupon_status').attr('src', warning_img);
                    $('.coupon-area .forms .coupon_fields').addClass('warning');

                } else {
                    $('.coupon-area .coupons_error').css('display', 'none');
                    $('.coupon-area .coupons_notice').css('display', 'block');
                    $('.coupon-area .coupon_field').val('');
                    if (coupon_total >= 3) {
                        $('.use-coupon-list li:eq(0)').remove();
                    }
                    $('.coupon-area .use-coupon-list').css('display', 'block');
                    $('.use-coupon-list').append('<li>' + coupon_code + '</li>');
                    coupon_total++;

                    $('.coupon-area .forms .coupon_fields').css('display', 'none');
                    $('.coupon-area .forms .coupons_added').css('display', 'block');
                    $('.coupon-area .forms .coupons_added').append(generateCouponTextDiv(coupon_code));

                    $('.coupon-area .save-coupon').css('display', 'none');
                    $('.coupon-area .forms .buttons').css('display', 'flex');
                    $('.coupon-area .coupon_fields .validate_coupon').addClass('invalid_coupon').removeClass('valid_coupon');

                    $('#coupon_status').attr('src', active_tick_img);

                }
            }
        });
    }
});


$(".coupon-area .coupon_field").focus(function () {
    var field = $(this);
    document.addEventListener("keydown", function (event) {
        if (event.keyCode === 8) {
            $(field).val('');
            $(".coupon-area .coupon_field").first().focus();
        }
    });
});

$(".coupon-area .coupon_field").on('input', function () {
    if ($(this).val().length == $(this).attr('maxlength')) {
        $(this).next().focus();
    }
    checkIfAllValid('.coupon-area');
});
// yeni slider kupon


/*
 * Auto Complete Coupon Inputs
 */
var $inputs = $(".coupon_fields input.coupon_field");
var intRegex = /^\d+$/;
$inputs.bind("paste", function (e) {
    var originalValue = e.originalEvent.clipboardData.getData('text');
    var $this = $(this);
    $this.val("");
    var values = originalValue.split("");
    $(values).each(function (index) {
        var $inputBox = $('.coupon_fields input.coupon_field').eq(index);
        $inputBox.val(values[index]).focus();
    });
});
