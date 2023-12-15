

var filtersForm = $('#filters-form');
if (filtersForm.length > 0) {
/*
    filtersForm.find('input[type=checkbox]').on('change', function (event) {
        filtersForm.submit();
    });

    $('.filter-query').keydown(function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            filtersForm.submit();
        }
    })
*/
}




var categoriesBoxes = $('.category-content');
if(categoriesBoxes.length > 0) {
    categoriesBoxes.on('click', function(event){
        var url = $(this).data('category-url');
//        location.href = url;
    });
}

$( "body" ).delegate( "a.add-to-wishlist", "click", function(event) {
    event.preventDefault();
    var btn = $(this);
    var url = btn.attr('href');
    btn.attr('disabled','disabled');

    btn.find('.wish_image_empty').css('display', 'none');
    btn.find('.wish_image').css('display', 'none');
    btn.find('.wish-spinner').css('display', 'inline-block');


    $.ajax({
        dataType: "json",
        url: url,
        success: function (returnData) {
              btn.removeAttr("disabled");
              btn.find('.wish-spinner').css('display', 'none');

            if(returnData.result) {
                if(returnData.added) {
                    if (btn.hasClass("destinations-wish")) {
                        btn.find('.wishlist-icon-desc').attr('src', 'http://beta.migoda.com/front/assets/images/svg/heart-white.png');
                        btn.removeClass('destinations-heart-no-color');
                        btn.addClass('destinations-heart-color');

                    }else{
                        // btn.removeClass('mg-secondary-button').addClass('mg-primary-button');
                        btn.find('.wish_image_empty').css('display', 'none');
                        btn.find('.wish_image').css('display', 'inline-block');

                    }
                } else {
                    if (btn.hasClass("destinations-wish")) {
                        btn.find('.wishlist-icon-desc').attr('src', 'http://beta.migoda.com/front/assets/images/svg/heart-white-empty.png');
                        btn.removeClass('destinations-heart-color');
                        btn.addClass('destinations-heart-no-color');
                   }else{
                       // btn.removeClass('mg-secondary-button').addClass('mg-primary-button');
                       btn.find('.wish_image').css('display', 'none');
                       btn.find('.wish_image_empty').css('display', 'inline-block');
                   }

                }
            }
        }
    });
    return false;
});


$('.backButton').on('click', function(event){
    event.preventDefault();
    var backUrl = $(this).data('previous-url');
    location.href = backUrl;
});


$('.menu-language > a').on('click', function(event){
    event.preventDefault();
    $('.profile_box').removeClass('active');
});

$('.menu-profile > a').on('click', function(event){
    event.preventDefault();
    $('.language_box').removeClass('active');
});


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
    localStorage.setItem($(this).parents('.select-replacement').data('target-field'), currentVal)
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
    localStorage.setItem($(this).parents('.select-replacement').data('target-field'), currentVal)
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

