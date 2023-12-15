function formattedDate(date) {
    var mnt = date.getMonth() + 1;
    var day = date.getDate();
    var yer = date.getFullYear();
    if (mnt < 10) mnt = '0' + mnt;
    if (day < 10) day = '0' + day;

    return yer + '-' + mnt + '-' + day;
}

function printFormattedDate(date, elemClass, lang) {
    if (typeof (lang) === 'undefined') lang = 'en';
    $('a.' + elemClass).html($('#date-picker').datepicker({
        language: lang,
        locale: lang,
    }).data('datepicker').formatDate('D,M d', new Date(date)));
}

function calculateRoomTotal() {

   
   
    var storedAdult = localStorage.getItem("guests_adult") ? localStorage.getItem("guests_adult") : 1;
    var storedChild = localStorage.getItem("guests_child") ? localStorage.getItem("guests_child") : 0;

    if (localStorage.getItem("guests_adult") || localStorage.getItem("guests_child")) {
            var total = parseInt(storedAdult) + parseInt(storedChild);
    } 
   
    var total = parseInt($('#guests_adult').val()) + parseInt($('#guests_child').val());
    var pricePerPerson = $('#total_price').data('price-per-person');
    var priceSymbol = $('#total_price').data('price-symbol');
    var date_checkin = new Date($('#date_checkin').val());
    var date_checkout = new Date($('#date_checkout').val());
    var timeDiff = Math.abs(date_checkout.getTime() - date_checkin.getTime());
    var calculated_days = Math.ceil(timeDiff / (1000 * 3600 * 24));
    
    $('#calculated_price').html(number_format((pricePerPerson * calculated_days * total)-(total), 2, ',', '.') + ' ' + priceSymbol);
    
    
    $('#calculated_days').html(Math.round((total * calculated_days) / 2));
}

// $('.more-filter').on('click', function (event) {
//     event.preventDefault();
//     $(this).siblings('.hidden-filter').removeClass('hidden-filter');
//     $(this).addClass('hidden-filter');
// });

$('#guests_child').on('change', function (event) {
    calculateRoomTotal();
});

$('#guests_adult').on('change', function (event) {
    calculateRoomTotal();
});

function number_format(number, decimals, dec_point, thousands_sep) {
    number = number.toFixed(decimals);

    var nstr = number.toString();
    nstr += '';
    x = nstr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? dec_point + x[1] : '';
    var rgx = /(\d+)(\d{3})/;

    while (rgx.test(x1))
        x1 = x1.replace(rgx, '$1' + thousands_sep + '$2');

    return x1 + x2;
}
