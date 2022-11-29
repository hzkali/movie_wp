(function (jQuery) {
    "use strict";
    jQuery(document).ready(() => {
        let desc = jQuery('.description-content');
        desc.toggleClass('showContent hideContent');
        let desc_panel_height = countLines(desc);
        desc.toggleClass('showContent hideContent');
        if (desc_panel_height > 10) {
            desc.addClass('hideContent').next('.show-more').show();
            desc.next('.show-more').on('click', () => {
                desc.toggleClass('showContent hideContent');
            });
        } else {
            desc.removeClass('showContent ').next('.show-more').hide();
        }
    });
}(jQuery));
var countLines = (el) => Math.round(Number(el.outerHeight() / parseInt(el.css('lineHeight').slice(0, -2))));