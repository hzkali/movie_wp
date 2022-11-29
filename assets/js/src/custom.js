/**
 * File custom.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

/*----------------------------------------------
Index Of Script
------------------------------------------------

1. Page Loader
2. Back To Top
3. Header
4. Wow Animation
5. Back to Top
6. Header Menu Dropdown
7. Mobile Menu Overlay
8. Inner-Slider
9. Select 2 Dropdown
10. Video popup
11. Flatpicker
12. Custom File Uploader
13. Vertical Menu
14. Add to cart with plus minus
15. Cart Btn


------------------------------------------------
Index Of Script
----------------------------------------------*/
(function (jQuery) {

    "use strict";

    jQuery(window).on('load', function (e) {
        jQuery('ul.page-numbers').addClass('justify-content-center');

        /*------------------------
        Page Loader
        --------------------------*/
        jQuery("#load").fadeOut();
        jQuery("#loading").delay(0).fadeOut("slow");

        jQuery('.widget .fa.fa-angle-down, #main .fa.fa-angle-down').on('click', function () {
            jQuery(this).next('.children, .sub-menu').slideToggle();
        });

        /*---------------------------
        Vertical Menu
        ---------------------------*/

        if (jQuery('.menu-style-one.streamit-mobile-menu').length > 0) {
            getDefaultMenu();
            jQuery(window).on('resize', function () {
                getDefaultMenu();
            });
        }




        /*------------------------
        Back To Top
        --------------------------*/
        jQuery('#back-to-top').fadeOut();
        jQuery(window).on("scroll", function () {
            if (jQuery(this).scrollTop() > 250) {
                jQuery('#back-to-top').fadeIn(1400);
            } else {
                jQuery('#back-to-top').fadeOut(400);
            }
        });

        // scroll body to 0px on click
        jQuery('#top').on('click', function () {
            jQuery('top').tooltip('hide');
            jQuery('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });


        /*------------------------
        Header
        --------------------------*/
        function headerHeight() {
            var height = jQuery("#main-header").height();
            jQuery('.iq-height').css('height', height + 'px');
        }

        jQuery(function () {
            var header = jQuery("#main-header"),
                yOffset = 0,
                triggerPoint = 80;

            headerHeight();

            jQuery(window).resize(headerHeight);
            var position = jQuery(window).scrollTop();

            jQuery(window).on('scroll', function () {

                yOffset = jQuery(window).scrollTop();
                if (yOffset >= 300) {
                    header.addClass("menu-sticky animated slideInDown");
                } else {
                    header.removeClass("menu-sticky animated slideInDown");
                }


                if (jQuery('.has-sticky').length > 0) {
                    var scroll = jQuery(window).scrollTop();
                    if (scroll < position) {
                        jQuery('.has-sticky').addClass('header-up');
                        jQuery('body').addClass('header--is-sticky');
                        jQuery('.has-sticky').removeClass('header-down');
                    } else {
                        jQuery('.has-sticky').addClass('header-down');
                        jQuery('.has-sticky').removeClass('header-up ');
                        jQuery('body').removeClass('header--is-sticky');
                    }
                    if (scroll == 0) {
                        jQuery('.has-sticky').removeClass('header-up');
                        jQuery('.has-sticky').removeClass('header-down');
                        jQuery('body').removeClass('header--is-sticky');
                    }
                    position = scroll;
                }

            });
        });

        if (jQuery('header').hasClass('has-sticky')) {
            jQuery(window).on('scroll', function () {
                if (jQuery(this).scrollTop() > 300) {
                    jQuery('header').addClass('menu-sticky animated slideInDown');
                    jQuery('.has-sticky .logo').addClass('logo-display');
                } else if (jQuery(this).scrollTop() < 20) {
                    jQuery('header').removeClass('menu-sticky animated slideInDown');
                    jQuery('.has-sticky .logo').removeClass('logo-display');
                }
            });
        }

    });


    jQuery(document).ready(function () {
        window.onscroll = function () {
            jQuery(document).find('.nav-link[aria-selected="true"]').addClass("active");
        };
        /*------------------------
        Header
        --------------------------*/
        function headerHeight() {
            var height = jQuery("#default-header").height();
            jQuery('.iq-height').css('height', height + 'px');
        }

        jQuery(function () {
            var header = jQuery("#main-header"),
                yOffset = 0,
                triggerPoint = 80;

            headerHeight();

            jQuery(window).resize(headerHeight);
        });



        /*------------------------
        Wow Animation
        --------------------------*/
        var wow = new WOW({
            boxClass: 'wow',
            animateClass: 'animated',
            offset: 0,
            mobile: false,
            live: true
        });
        wow.init();

        /*---------------------------------------------------------------------
            Back to Top
        ---------------------------------------------------------------------*/
        var btn = jQuery('#back-to-top');
        jQuery(window).scroll(function () {
            if (jQuery(window).scrollTop() > 50) {
                btn.addClass('show');
            } else {
                btn.removeClass('show');
            }
        });
        btn.on('click', function (e) {
            e.preventDefault();
            jQuery('html, body').animate({ scrollTop: 0 }, '300');
        });


        /*---------------------------------------------------------------------
            Header Menu Dropdown
        ---------------------------------------------------------------------*/
        jQuery('[data-toggle=more-toggle]').on('click', function () {
            jQuery(this).next().toggleClass('show');
        });

        /*---------------------------------------------------------------------
       search bar toggle
       ----------------------------------------------------------------------- */
        if (jQuery("header .search__input").length > 0 && jQuery("header .search-box").length > 0) {
            jQuery(document).on('click', '#btn-search', function () {
                jQuery('li.header-search-right').toggleClass('iq-show');
                jQuery(this).parent('.search_form_wrap').toggleClass('iq-show');
                jQuery('header .search-box').toggleClass('active');

                jQuery('.iq-usermenu-dropdown li.header-user-rights ,.iq-usermenu-dropdown .header-user-rights').removeClass('iq-show');
                jQuery('header .iq-sub-dropdown.iq-user-dropdown').removeClass('active');
            });
        }
        jQuery(document).on(' click', '#btn-user-list', function () {
            jQuery(this).parent().toggleClass('iq-show');
            jQuery(this).next('.iq-user-dropdown').toggleClass('active');


            jQuery('.iq-usermenu-dropdown li.header-search-right , .iq-usermenu-dropdown .header-search-right, .search_form_wrap').removeClass('iq-show');
            jQuery('header .search-box, .search-box').removeClass('active');
        });
        jQuery(document).on('mouseover', '#btn-user-list', function () {

            jQuery('.iq-usermenu-dropdown li.header-search-right , .iq-usermenu-dropdown .header-search-right, .search_form_wrap').removeClass('iq-show');
            jQuery('header .search-box, .search-box').removeClass('active');
        });
        jQuery(window).on('click', function (e) {
            if (!jQuery(e.target).closest(".header-search-right").length) {
                jQuery('.header-search-right').removeClass('iq-show');
            }
        });

        /*------------------------
            Search Bar Layout
        --------------------------*/
        if (jQuery(".btn-search").length > 0) {
            jQuery(document).on('click', '.btn-search', function () {
                jQuery(this).parent().find('.streamit-search').toggleClass('search--open');
            });
            jQuery(document).on('click', '.btn-search-close', function () {
                jQuery(this).closest('.streamit-search').toggleClass('search--open');
            });

        }

        /*------------------------
           shop sidebar toggle button
       --------------------------*/
        if (jQuery('.shop-filter-sidebar').length > 0) {
            jQuery(document).on('click', '.shop-filter-sidebar', function () {
                jQuery('body').find('.streamit-woo-sidebar').toggleClass('woo-sidebar-open');
                jQuery('body').addClass('woof-overlay');

            });
        }

        /*------------------------
            Close Panel And Menu When Click Outside
        --------------------------*/

        jQuery(window).on('click', function (e) {
            let target = jQuery(e.target);
            if (!target.closest(".search_form_wrap.iq-show").length) {
                jQuery('.search_form_wrap.iq-show').removeClass('iq-show');
            }

            if (!target.closest(".header-user-rights.iq-show").length) {
                jQuery('.header-user-rights.iq-show').removeClass('iq-show');
            }
            if (!target.closest(".iqonic-custom-layouts.open").length) {
                jQuery('.iqonic-custom-layouts.open').removeClass('open');
            }
            if (!target.closest(".streamit-woo-sidebar.woo-sidebar-open").length && !target.hasClass('streamit-filter-button') && !target.parent().hasClass('streamit-filter-button')) {
                jQuery('.streamit-woo-sidebar.woo-sidebar-open').removeClass('woo-sidebar-open');
                jQuery('body').removeClass('woof-overlay');
            }

        });
        jQuery('.iqonic-custom-layouts').each(function () {
            let id = '#' + jQuery(this).attr('id');
            let clickId = 'a[href=' + id + ']';
            jQuery(clickId).on('click', function (e) {
                jQuery('.search_form_wrap.iq-show').removeClass('iq-show');
                jQuery('.header-user-rights.iq-show').removeClass('iq-show');
                e.stopPropagation();
            });
        });

        jQuery(window).on('click', function (e) {
            if (!jQuery(e.target).closest(".iqonic-custom-layouts.open").length) {
                jQuery('.iqonic-custom-layouts.open').removeClass('open');
            }
        });

        /*---------------------------------------------------------------------
        Mobile Menu Overlay
        ----------------------------------------------------------------------- */
        jQuery(document).on("click", function (event) {
            var jQuerytrigger = jQuery(".main-header .navbar");
            if (jQuerytrigger !== event.target && !jQuerytrigger.has(event.target).length) {
                jQuery(".main-header .navbar-collapse").collapse('hide');
                jQuery('body').removeClass('nav-open');
            }
        });
        jQuery('.c-toggler').on("click", function () {
            jQuery('body').addClass('nav-open');
        });


        watchlist_last_item();



        /*------------------------
            Inner-Slider
        --------------------------*/

        if (jQuery('.inner-slider').length > 0) {
            jQuery('.inner-slider').slick({
                dots: false,
                arrows: true,
                infinite: true,
                speed: 300,
                autoplay: false,
                slidesToShow: 4,
                slidesToScroll: 1,
                nextArrow: '<a href="#" class="slick-arrow slick-next"><i class= "fas fa-chevron-right"></i></a>',
                prevArrow: '<a href="#" class="slick-arrow slick-prev"><i class= "fas fa-chevron-left"></i></a>',
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1,
                            infinite: true,
                            dots: true
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                            arrows: false,
                        }
                    }
                ]
            });
        }

        jQuery('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            jQuery('.inner-slider').slick('setPosition');
        })

        /*---------------------------------------------------------------------
            Select 2 Dropdown
        -----------------------------------------------------------------------*/
        if (jQuery('select').hasClass('season-select')) {
            jQuery('select').select2({
                theme: 'bootstrap4',
                allowClear: false,
                width: 'resolve',
                minimumResultsForSearch: -1
            });
        }
        if (jQuery('select').hasClass('pro-dropdown')) {
            jQuery('.pro-dropdown').select2({
                theme: 'bootstrap4',
                minimumResultsForSearch: Infinity,
                width: 'resolve'
            });
            jQuery('#lang').select2({
                theme: 'bootstrap4',
                placeholder: 'Language Preference',
                allowClear: true,
                width: 'resolve'
            });
        }

        if (jQuery('select:not(.select2-hidden-accessible)').length > 0) {

            jQuery('select').each(function () {
                let select_config = {
                    width: '100%',
                    dropdownParent: jQuery(this).parent()
                }
                if (jQuery(this).parent().closest(".checkout").length > 0) {
                    select_config = {
                        width: '100%',
                    }
                }
                jQuery(this).select2(select_config);
            });

            jQuery('.select2-container').addClass('wide');

        }

        /*---------------------------------------------------------------------
            Video popup
        -----------------------------------------------------------------------*/
        if (jQuery('.video-open').length > 0) {
            jQuery('.video-open').magnificPopup({
                type: 'iframe',
                mainClass: 'mfp-fade',
                removalDelay: 160,
                preloader: false,
                fixedContentPos: false,
                iframe: {
                    markup: '<div class="mfp-iframe-scaler">' +
                        '<div class="mfp-close"></div>' +
                        '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>' +
                        '</div>',

                    srcAction: 'iframe_src',
                }
            });
        }


        /*---------------------------------------------------------------------
            Flatpicker
        -----------------------------------------------------------------------*/
        if (jQuery('.date-input').hasClass('basicFlatpickr')) {
            jQuery('.basicFlatpickr').flatpickr();
        }
        /*---------------------------------------------------------------------
            Custom File Uploader
        -----------------------------------------------------------------------*/
        jQuery(".file-upload").on("change", function () {
            ! function (e) {
                if (e.files && e.files[0]) {
                    var t = new FileReader;
                    t.onload = function (e) {
                        jQuery(".profile-pic").attr("src", e.target.result)
                    }, t.readAsDataURL(e.files[0])
                }
            }(this)
        }), jQuery(".upload-button").on("click", function () {
            jQuery(".file-upload").click();
        });


        /*------------------------
            Comment Form validation
        --------------------------*/
        if (jQuery('.validate-form').length > 0) {
            jQuery('.validate-form #commentform').submit(function () {
                jQuery('.error-msg').hide();
                var cmnt = jQuery.trim(jQuery(".validate-form #comment").val());
                var error = '';
                if (jQuery(".validate-form #author").length > 0) {
                    var author = jQuery.trim(jQuery(".validate-form #email").val());
                    var email = jQuery.trim(jQuery(".validate-form #author").val());
                    var url = jQuery.trim(jQuery(".validate-form #url").val());
                    jQuery(".validate-form #comment,.validate-form #author,.validate-form #email,.validate-form #url").removeClass('iq-warning');

                    if (cmnt === "") {
                        jQuery(".validate-form #comment").addClass('iq-warning');
                        error = '1';
                    }
                    if (author === "") {
                        jQuery(".validate-form #author").addClass('iq-warning');
                        error = '1';
                    }
                    if (email === "") {
                        jQuery(".validate-form #email").addClass('iq-warning');
                        error = '1';
                    }
                    if (url === "") {
                        jQuery(".validate-form #url").addClass('iq-warning');
                        error = '1';
                    }

                }
                else {
                    jQuery(".validate-form #comment").removeClass('iq-warning');
                    if (cmnt === "") {
                        jQuery(".validate-form #comment").addClass('iq-warning');
                        error = '1';
                    }
                }
                if (error !== '' && error === '1') {
                    jQuery('.error-msg').html('One or more fields have an error. Please check and try again.');
                    jQuery('.error-msg').slideDown();
                    return false;
                }


            });
        }

        /*------------------------
           Description Tab
       --------------------------*/
        jQuery('.streamit-content-details .nav-link:first').addClass('active');
        jQuery('.streamit-content-details .tab-pane:first').addClass('active show');

        /*------------------------
            Read More content
        --------------------------*/
        var content_count = jQuery(".streamit-content-details .show-more a,.iq-tvshows-slider .shows-content .show-more a").attr('data-count');
        if (content_count > 50) {
            jQuery(".streamit-content-details .show-more a, .iq-tvshows-slider .shows-content .show-more a").on("click", function () {
                var $this = jQuery(this);
                var content = $this.parent().prev(".description-content");
                var moretext = $this.attr('data-showmore');
                var lesstext = $this.attr('data-showless');
                var linkText = $this.text();
                if (linkText === moretext) {
                    var linkText_less = lesstext;
                    linkText = linkText_less;
                } else {
                    var linkText_more = moretext;
                    linkText = linkText_more;
                }
                content.toggleClass('showContent hideContent');

                $this.text(linkText);
            });
        }
        /*---------------------------------------------------------------------
            Slick Slider
        ----------------------------------------------------------------------- */

        jQuery('.season-select.iq-single').on('change', function () { //For Single Page Season Select Only
            jQuery('.single-season-data').each(function () {
                jQuery(this).removeClass('active show');
            });
            jQuery('[data-display=' + jQuery(this).val() + ']').addClass('active show');
        });


        /*---------------------------
        Vertical Menu
        ---------------------------*/
        jQuery('nav.mobile-menu .widget i,nav.mobile-menu .top-menu i').click(function () {
            jQuery(this).next('.children, .sub-menu').slideToggle();
        });

        /*---------------------------
           Persons Circle Chart
           ---------------------------*/
        circle_chart();

        /*------------------------
   main menu toggle
  --------------------------*/
        jQuery(document).on("click", '.custom-toggler', function () {
            if (jQuery('.streamit-mobile-menu ').hasClass('menu-open')) {
                jQuery('.streamit-mobile-menu ').toggleClass('open-delay');
                setTimeout(function () {
                    jQuery('.streamit-mobile-menu ').toggleClass('menu-open');
                    jQuery('.streamit-mobile-menu ').toggleClass('open-delay');
                });
            } else {
                jQuery('.streamit-mobile-menu ').toggleClass('menu-open');
            }
            jQuery('.opn-menu').toggleClass('streamit-open');
        });
        jQuery(document).on("click", '.ham-toggle', function () {
            jQuery('.ham-toggle .menu-btn').toggleClass('is-active');
        });
        jQuery(document).on("click", '.mob-toggle', function () {
            jQuery('body').toggleClass('overflow-hidden');
        });


        /*------------------------
        Add to cart with plus minus
        --------------------------*/
        jQuery(document).on('click', 'button.plus, button.minus', function () {

            jQuery('button[name="update_cart"]').removeAttr('disabled');

            var qty = jQuery(this).closest('.quantity').find('.qty');


            if (qty.val() == '') {
                qty.val(0);
            }
            var val = parseFloat(qty.val());

            var max = parseFloat(qty.attr('max'));
            var min = parseFloat(qty.attr('min'));
            var step = parseFloat(qty.attr('step'));

            // Change the value if plus or minus
            if (jQuery(this).is('.plus')) {
                if (max && (max <= val)) {
                    qty.val(max);
                } else {
                    qty.val(val + step);
                }
            } else {
                if (min && (min >= val)) {

                    qty.val(min);
                } else if (val >= 1) {

                    qty.val(val - step);
                }
            }
            set_quanity(jQuery(this));
        });




        /*------------------------
        Cart btn 
        --------------------------*/

        if (jQuery(document).find('.dropdown-hover').length > 0) {
            jQuery(document).on('click', ".dropdown-hover a.dropdown-cart", function () {
                jQuery(".dropdown-menu-mini-cart").addClass('cart-show');
            });
            jQuery(document).on('click', ".dropdown-close", function () {
                jQuery(".dropdown-menu-mini-cart").removeClass('cart-show');
            });
            jQuery('body').mouseup(function (e) {
                if (jQuery(e.target).parents('.dropdown-menu-mini-cart').length === 0) {
                    jQuery(".dropdown-menu-mini-cart").removeClass('cart-show');
                }
            });
            jQuery(".streamit-users-settings .dropdown-hover").hover(function () {
                var isHovered = jQuery(this).is(":hover");
                if (isHovered) {
                    jQuery(this).find(".dropdown-menu").stop().fadeIn(300);
                } else {
                    jQuery(this).find(".dropdown-menu").stop().fadeOut(300);
                }
            });
        }

        jQuery('.streamit-count-box').prev('.wp_ulike_counter_up').hide();

        let tabs = document.querySelector('.trending-pills li:first-child a');
        if (tabs !== null) {
            var firstTab = new bootstrap.Tab(document.querySelector('.trending-pills li:first-child a'))
            firstTab?.show()
        }

    });
    jQuery(document).on('change input', 'input.qty', function () {
        set_quanity(jQuery(this));
    });

    jQuery('.show-more-btn').click(function () {
        let id = jQuery(this).attr('data-target');
        jQuery('a[href=' + id + ']').tab('show');


        jQuery('html, body').stop().animate({
            'scrollTop': jQuery('a[href=' + id + ']').offset().top - 200
        }, 800, 'swing');
    });
    jQuery(document).on('added_to_cart', function (a, b, c, d) {
        jQuery('*[title]').tooltip('disable');
    });
    jQuery(document).on('removed_from_cart added_to_cart', function (e) {
        jQuery('.streamit-cart-count').text(jQuery('#mini-cart-count').text().trim());
    });
    jQuery(document.body).on('woosq_loaded woosq_close', function () {
        jQuery('#woosq-popup select').select2({
            theme: 'bootstrap4',
            allowClear: false,
        });
    });
})(jQuery);

/*------------------------
         watchlist last item
--------------------------*/
function watchlist_last_item() {
    if (jQuery('.wl-child').length) {
        jQuery('.iq_genres-contents ,.iq_archive_items,.watchlist-contens').each(function () {


            let count;
            let in_count;
            let width = jQuery(window).width();
            if (width > 991) {
                count = 3; in_count = 4;
            }
            else if (width > 767 && width < 991) {
                count = 2; in_count = 3;
            }
            else if (width < 768) {
                count = 1; in_count = 2;
            }
            else {
                count = 3;
                in_count = 4;
            }
            let k = 0;
            let j = count;
            let len = jQuery(this).find('.wl-child').length;

            jQuery(this).find('.wl-child').each(function () {
                if (k === 0) {
                    jQuery(this).find('.watchlist-img,.archive-media').addClass('watchlist-first');
                }
                if (j == k || k === count || (len.length - 1) === k) {
                    j += in_count;
                    jQuery(this).find('.watchlist-img,.archive-media').addClass('watchlist-last');
                    jQuery(this).next().find('.watchlist-img,.archive-media').addClass('watchlist-first');
                }
                k++;
            });
        });

        jQuery('.iq_tags-contents').each(function () {
            let count;
            let in_count;
            let width = jQuery(window).width();

            if (width > 991) {
                count = 5; in_count = 6;
            }
            else if (width > 767 && width < 991) {
                count = 3; in_count = 4;
            }
            else if (width < 768) {
                count = 2; in_count = 3;
            }
            else {
                count = 3;
                in_count = 4;
            }
            let k = 0;
            let j = count;
            let len = jQuery(this).find('.wl-child').length;
            jQuery(this).find('.wl-child').each(function () {
                if (k === 0) {
                    jQuery(this).find('.iq-tag-box').addClass('watchlist-first');
                }
                if (j == k || k === count || (len.length - 1) === k) {
                    j += in_count;
                    jQuery(this).find('.iq-tag-box').addClass('watchlist-last');
                    jQuery(this).next().find('.iq-tag-box').addClass('watchlist-first');
                }
                k++;
            });
        });
    }
}
function circle_chart() {
    jQuery('.progress').each(function () {
        let deg = jQuery(this).data('deg');
        if (deg > 180) {
            jQuery(this).css('--secound', deg + 'deg');
        }
        else {
            jQuery(this).css({
                '--first': deg + 'deg',
                '--secound': 0 + 'deg'
            });
            jQuery(this).children('.right').hide();
        }
    });

}

function getDefaultMenu() {
    jQuery('.menu-style-one nav.mobile-menu .sub-menu').css('display', 'none ');
    jQuery('.menu-style-one nav.mobile-menu .top-menu li .dropdown').hide();
    jQuery('.menu-style-one nav.mobile-menu .sub-menu').prev().prev().addClass('submenu');
    jQuery('.menu-style-one nav.mobile-menu .sub-menu').before('<span class="toggledrop"><i class="fas fa-plus menu-open"></i><i class="fas fa-minus menu-close"></i></span>');

    jQuery('nav.mobile-menu .widget i,nav.mobile-menu .top-menu i').on('click', function () {
        jQuery(this).next('.children, .sub-menu').slideToggle();
    });
    jQuery('.menu-style-one nav.mobile-menu .top-menu .menu-item .toggledrop').off('click');

    jQuery('.menu-style-one nav.mobile-menu .menu-item .toggledrop').on('click', function () {
        if (jQuery(this).closest(".menu-is--open").length == 0) {
            jQuery('.menu-style-one nav.mobile-menu .menu-item').removeClass('menu-is--open');
        }
        if (jQuery(this).parent().find("ul").length > 1) {
            jQuery(this).parent().addClass('menu-is--open');
        }
        jQuery('.menu-style-one nav.mobile-menu .menu-item:not(.menu-is--open) .children,.menu-style-one nav.mobile-menu .menu-item:not(.menu-is--open) .sub-menu').slideUp();
        if (!jQuery(this).next('.children, .sub-menu').is(':visible') || jQuery(this).parent().hasClass("menu-is--open")) {
            jQuery(this).next('.children, .sub-menu').slideToggle();
        }
        jQuery('.menu-style-one nav.mobile-menu .menu-item:not(.menu-is--open) .toggledrop').not(jQuery(this)).removeClass('active');
        jQuery(this).toggleClass('active');

        jQuery('.menu-style-one nav.mobile-menu .menu-item').removeClass('menu-clicked');
        jQuery(this).parent().addClass('menu-clicked');

        jQuery('.menu-style-one nav.mobile-menu .menu-item').removeClass('current-menu-ancestor');
    });
}
// Wocomerce Set Quantiy Input 
function set_quanity(this_) {
    if (!this_.hasClass('qty')) {
        this_ = this_.siblings('input.qty');
    }
    let current = this_.attr('name');

    let item_hash = current ? current.replace(/cart\[([\w]+)\]\[qty\]/g, "$1") : false;
    if (!item_hash)
        return

    let item_quantity = this_.val();
    let currentVal = parseFloat(item_quantity);

    jQuery.ajax({
        type: 'POST',
        url: streamit_loadmore_params.ajaxurl,
        data: {
            action: 'qty_cart',
            hash: item_hash,
            quantity: currentVal
        },
        success: function (res) {
            jQuery(document.body).trigger('wc_fragment_refresh');
            jQuery('.streamit-cart-count').html(res['data']['quantity'])
        }
    });
}
