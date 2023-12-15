var sliderDelay = 1000;
var sliderTimer = null;

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

