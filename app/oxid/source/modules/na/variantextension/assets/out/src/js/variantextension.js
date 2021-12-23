!(function (a) {
    'use strict';

    const oxPopOverOnVariantImage = {
        _create: function () {
            a('.variant-image').popover({
                trigger: 'hover',
                html: true
            })
        }
    };
    a.widget('ui.oxPopOverOnVariantImage', oxPopOverOnVariantImage);
})(jQuery);