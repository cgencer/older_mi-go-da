(function ($) {

    $.fn.filemanager = function (type, options) {
        type = type || 'file';

        this.on('click', function (e) {
            var route_prefix = (options && options.prefix) ? options.prefix : '/filemanager';
            var hotel = (options && options.hotelId) ? '&hotelId=' + options.hotelId : '';
            var rq = (options && options.rq) ? '&rq=' + options.rq : '';
            var target_input = $('#' + $(this).data('input'));
            var target_preview = $('#' + $(this).data('preview'));
            window.open(route_prefix + '?type=' + type + hotel + rq, 'FileManager', 'toolbar=no,directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=900,height=600');
            window.SetUrl = function (items) {
                var file_path = items.map(function (item) {
                    return item.url;
                }).join(',');

                // set the value of the desired input to image url
                target_input.val('').val(file_path).trigger('change');

                // clear previous preview
                target_preview.html('');

                // set or change the preview image src
                items.forEach(function (item) {
                    target_preview.append(
                        $('<img>').css('height', '5rem').attr('src', item.thumb_url)
                    );
                });

                // trigger change event
                target_preview.trigger('change');
            };
            return false;
        });
    };

    $.fn.filemanagerGalery = function (type, options) {
        this.bind('click', function () {
            var route_prefix = (options && options.prefix) ? options.prefix : '/filemanager';
            var hotel = (options && options.hotelId) ? '&hotelId=' + options.hotelId : '';
            var rq = (options && options.rq) ? '&rq=' + options.rq : '';
            var target_preview = $('#images-sortable');
            window.open(route_prefix + '?type=' + type + hotel + rq, 'FileManager', 'toolbar=no,directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=900,height=600');
            window.SetUrl = function (items) {
                var file_path = items.map(function (item) {
                    return item.url;
                }).join(',');
                // set or change the preview image src
                items.forEach(function (item) {
                    target_preview.append('<div class="image-item"><input type="hidden" name="galeryItems[]" value="' + file_path + '"><img src="' + item.thumb_url + '" alt=""><a href="javascript:void(0);" class="remove-item btn btn-icon btn-rounded btn-default"><i class="mdi mdi-delete"></i></a></div>');
                });
                // trigger change event
                target_preview.trigger('change');
            };
            return false;
        });
    };

})(jQuery);
