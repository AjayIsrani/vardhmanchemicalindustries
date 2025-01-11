;(function($) {
    'use strict';

    var AddGridVC = function() {
        if ( $('body').hasClass('is-page') ) {
            var vcGrid = $('.wpb_row');

            if ( vcGrid.length == 0 ) {
                $('#content-wrap').addClass('bauer-container');
            }

        	if ( $('body.is-page').hasClass('sidebar-right') || $('body.is-page').hasClass('sidebar-left')  ) {
            	$('#content-wrap').addClass('bauer-container');
        	}            
        }
    };

	 $('#spanYear').html(new Date().getFullYear()); 
    // Mega Menu
    var megaMenu = function() {
        $(window).on('load resize', function() {
            var 
            du = $('#main-nav .megamenu > ul'),
            siteNav = $('#main-nav'),
            siteHeader = $( '#site-header' );

            if ( du.length ) {
                var
                o = siteHeader.find(".bauer-container").outerWidth(),
                a = siteNav.outerWidth(),
                n = siteNav.css("right"),
                n = parseInt(n,10),
                d = o-a-n; 
                if ( $('.site-navigation-wrap').length ) d = 0;
                du.css({ width: o, "margin-left": -d })
            }
        });
    };

    // PreLoader
    var preLoader = function() {
        if ( $().animsition ) {
            $('.animsition').animsition({
                inClass: 'fade-in',
                outClass: 'fade-out',
                inDuration: 1500,
                outDuration: 800,
                loading: true,
                loadingParentElement: 'body',
                loadingClass: 'animsition-loading',
                timeout: false,
                timeoutCountdown: 5000,
                onLoadEvent: true,
                browser: [
                    '-webkit-animation-duration',
                    '-moz-animation-duration',
                    'animation-duration'
                    ],
                overlay: false,
                overlayClass: 'animsition-overlay-slide',
                overlayParentElement: 'body',
                transition: function(url){ window.location.href = url; }
            });
        }
    };

    // Menu Search Icon
    var searchIcon = function() {
        var search_wrap = $('.search-style-fullscreen');
        var search_trigger = $('.header-search-trigger');
        var search_field = search_wrap.find('.search-field');

        search_trigger.on('click', function(e) {
            if ( ! search_wrap.hasClass('search-opened') ) {
                search_wrap.addClass('search-opened');
                search_field.get(0).focus();

            } else if (search_field.val() == '') {
                if ( search_wrap.hasClass('search-opened') )
                    search_wrap.removeClass('search-opened');
                else search_field.get(0).focus();

            } else {
                 search_wrap.find('form').get(0).submit();
            }

            $('html').addClass( 'disable-scroll' );
            e.preventDefault();
            return false;
        });

        search_wrap.find('.search-close').on('click', function(e) {
            search_wrap.removeClass('search-opened');
            $('html').removeClass( 'disable-scroll' );
            e.preventDefault();
            return false;
        });
    };

    // Mobile Navigation
    var mobileNav = function() {

        var menuType = 'desktop';

        $(window).on('load resize', function() {
            var
            mode = 'desktop',
            wrapMenu = $('#site-header-inner .wrap-inner'),
            navExtw = $('.nav-extend'),
            navExt = $('.nav-extend').children('.ext').filter(':not(".menu-logo")'),
            navLogo = $('.nav-extend').children('.menu-logo');

            if ( matchMedia( 'only screen and (max-width: 991px)' ).matches )
                mode = 'mobile';

            if ( mode != menuType ) {
                menuType = mode;

                if ( mode == 'mobile' ) {

                    if ( $('#main-nav').length ) {
                        $('.mobile-button').show();

                        $('#main-nav').attr('id', 'main-nav-mobi')
                            .appendTo('body')
                            .children('.menu').prepend(navLogo).append(navExt)
                                .find('li:has(ul)')
                                .children('ul')
                                    .removeAttr('style')
                                    .hide()
                                    .before('<span class="arrow"></span>');
                    }

                } else {

                    $('.mobile-button').removeClass('hide');
                    $('html').removeClass( 'disable-scroll' );
                    $( '.mobi-overlay' ).removeClass('show');
                    $('.mobile-button').hide();

                    if ( $('body').is('.header-style-5, .header-style-6') )
                        wrapMenu = $('.site-navigation-wrap > .inner');

                    $('#main-nav-mobi').attr('id', 'main-nav')
                        .removeAttr('style')
                        .appendTo(wrapMenu)
                            .find('.ext').appendTo(navExtw)
                        .parent().siblings('#main-nav')
                            .find('.sub-menu')
                                .removeAttr('style')
                            .prev().remove();
                }
            }
        });

        // Close mobi-menu when clicking on overlay
        $('.mobi-overlay').on('click', function() {
            $('.mobile-button').removeClass('hide');
            $(this).removeClass('show');
            $("#main-nav-mobi").animate({ left: "-300px" }, 300, 'easeInOutExpo');
            $('html').removeClass( 'disable-scroll' );

        } );

        // Show mobi-menu when clicking on mobi-button
        $(document).on('click', '.mobile-button', function() {
            $('.mobile-button').addClass('hide');
            $( '.mobi-overlay' ).addClass('show');
            $("#main-nav-mobi").animate({ left: "0"}, 300, 'easeInOutExpo');
            $('html').addClass( 'disable-scroll' );
        })

        $(document).on('click', '#main-nav-mobi .arrow', function() {
            $(this).toggleClass('active').next().stop().slideToggle();
        })
    };

    // Fix Navigation
    var fixNav = function() {
        var
        nav = $('#main-nav'),
        wNav = $('.widget_nav_menu'),
        docW = $(window).width(),
        c = $('#site-header-inner'),
        cl = c.offset().left,
        cw = c.width();

        if ( nav )
            nav.find('.sub-menu').each(function() {
            var
            off = $(this).offset(),
            l = off.left,
            w = $(this).width(),
            il = l - cl,
            over = ( il + w >= cw );

            if ( over )
                $(this).addClass('left');

            })

        if ( wNav.length != 0 )
            wNav.find('a:empty')
                .closest('li').remove();
    };

    // One Page
    var onePage = function() {
        $('#menu-one-page li').filter(':first').addClass('current-menu-item');

        $('#menu-one-page li a').on('click',function() {
            var anchor = $(this).attr('href').split('#')[1];

            if ( anchor ) {
                if ( $('#'+anchor).length > 0 ) {
                    var headerHeight = 0;

                    if ( $('body').hasClass('header-sticky') )
                        headerHeight = $('#site-header').height();

                    var target = $('#' + anchor).offset().top - headerHeight;

                    $('html,body').animate({scrollTop: target}, 1000, 'easeInOutExpo');
               }
            }
            return false;
        });
    };

    // Responsive Videos
    var responsiveVideos = function() {
        if ( $().fitVids ) {
            $('.bauer-container').fitVids();
        }
    };

    // Header Fixed
    var headerFixed = function() {
        if ( $('body').hasClass('header-fixed') ) {
            var nav = $('#site-header');

            if ( $('body').is('.header-style-5, .header-style-6') )
                nav = $('.site-navigation-wrap');

            if ( nav.length ) {
                var
                offsetTop = nav.offset().top,
                headerHeight = nav.height(),
                injectSpace = $('<div />', {
                    height: headerHeight
                }).insertAfter(nav);

                $(window).on('load scroll', function(){
                    if ( $(window).scrollTop() > offsetTop ) {
                        nav.addClass('fixed-hide');
                        injectSpace.show();
                    } else {
                        nav.removeClass('fixed-hide');
                        injectSpace.hide();
                    }

                    if ( $(window).scrollTop() > 500 ) {
                        nav.addClass('fixed-show');
                    } else {
                        nav.removeClass('fixed-show');
                    }
                })
            }
        }     
    };

    // Scroll to Top
    var scrollToTop = function() {
        $(window).scroll(function() {
            if ( $(this).scrollTop() > 800 ) {
                $('#scroll-top').addClass('show');
            } else {
                $('#scroll-top').removeClass('show');
            }
        });

        $('#scroll-top').on('click', function() {
            $('html, body').animate({ scrollTop: 0 }, 1000 , 'easeInOutExpo');
        return false;
        });
    };

    // Featured Media
    var featuredMedia = function() {
        if ( $().slick ) {
            $('.blog-gallery').slick({
                dots: true,
                infinite: true,
                speed: 300,
                fade: true,
                cssEase: 'linear'
            });
        }
    };

    // Related Post
    var relatedPost = function() {
        if ( $().slick ) {
            $('.related-post').slick({
                dots: false,
                arrows: false,
                infinite: false,
                speed: 300,
                slidesToShow: 3,
                slidesToScroll: 3,
                responsive: [
                {
                  breakpoint: 1024,
                  settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3
                  }
                },
                {
                  breakpoint: 600,
                  settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                  }
                },
                {
                  breakpoint: 480,
                  settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                  }
                }
                ]
            });
        }
    };

    // Widget Spacer
    var widgetSpacer = function() {
        $(window).on('load resize', function() {
            var mode = 'desktop';

            if ( matchMedia( 'only screen and (max-width: 991px)' ).matches )
                mode = 'mobile';

            $('.spacer').each(function(){
                if ( mode == 'mobile' ) {
                    $(this).attr('style', 'height:' + $(this).data('mobi') + 'px')
                } else {
                    $(this).attr('style', 'height:' + $(this).data('desktop') + 'px')
                }
            })
        });
    };

    var categoryChange = function() {
        const products = {
            "Waterproofing": [
                { "pro_id": "1", "pro_name": "Zentex Pum-100" },
                { "pro_id": "2", "pro_name": "Zentex BM-606" },
                { "pro_id": "5", "pro_name": "Zentex WM-608" },
                { "pro_id": "6", "pro_name": "Zentex CEM-2K" },
                { "pro_id": "7", "pro_name": "Zentex Crete" },
                { "pro_id": "8", "pro_name": "Zentex MW+" },
                { "pro_id": "9", "pro_name": "Zentex SBR-50" },
                { "pro_id": "10", "pro_name": "Zentex SG-101" },
                { "pro_id": "11", "pro_name": "Zentex BS-Sealer" },
                { "pro_id": "12", "pro_name": "Zentex FGW" },
                { "pro_id": "13", "pro_name": "Zentex PP-105" },
                { "pro_id": "14", "pro_name": "Zentex CRACK FILL" },
                { "pro_id": "41", "pro_name": "Zentex Damp B Poxy" },
                { "pro_id": "44", "pro_name": "Zentex EPL" },
                { "pro_id": "59", "pro_name": "Zentex CRETE Cool-E-Cool" },
                { "pro_id": "60", "pro_name": "Zentex Damproof Xtreme" },
                { "pro_id": "61", "pro_name": "Zentex Readyplast E2" },
                { "pro_id": "55", "pro_name": "Zentex Cote EP-405" },
                { "pro_id": "64", "pro_name": "Zentex Crystalline Waterproofing" },
                { "pro_id": "65", "pro_name": "Zentex Black Japan" },
                { "pro_id": "66", "pro_name": "Zentex Lacquer Hardener" },
                { "pro_id": "67", "pro_name": "Zentex Road Fiber" },
                { "pro_id": "68", "pro_name": "Zentex PU Plus" },
                { "pro_id": "69", "pro_name": "Zentex Water Based Epoxy" }
            ],
            "Flooring Systems": [
                { "pro_id": "3", "pro_name": "Zentex EP -SL 100" },
                { "pro_id": "4", "pro_name": "Zentex EP-500 MC" },
                { "pro_id": "17", "pro_name": "Zentex PU-CRETE" },
                { "pro_id": "18", "pro_name": "Zentex PU-500 MC" },
                { "pro_id": "19", "pro_name": "Zentex CEM-SL" },
                { "pro_id": "20", "pro_name": "Zentex CRC" },
                { "pro_id": "21", "pro_name": "Zentex ACC" },
                { "pro_id": "22", "pro_name": "Zentex ESD-SL" },
                { "pro_id": "62", "pro_name": "Zentex clear CS" }
            ],
            "Tiles Fixing Adhesives": [
                { "pro_id": "24", "pro_name": "Zentex TA-WL" },
                { "pro_id": "25", "pro_name": "Zentex HT-N" },
                { "pro_id": "26", "pro_name": "Zentex NL-H" },
                { "pro_id": "27", "pro_name": "Zentex B-Flex" },
                { "pro_id": "28", "pro_name": "Zentex Epoxy" },
                { "pro_id": "29", "pro_name": "Zentex WC-Putty" },
                { "pro_id": "35", "pro_name": "Zentex Tile-Cleaner" },
                { "pro_id": "43", "pro_name": "Zentex Anchor Grout" },
                { "pro_id": "47", "pro_name": "Zentex Floor hardener metallic" },
                { "pro_id": "49", "pro_name": "Zentex Micro Concrete" },
                { "pro_id": "63", "pro_name": "Zentex Tile Adhesive-FL" },
                { "pro_id": "54", "pro_name": "Zentax Coal Tar Epoxy" },
                { "pro_id": "56", "pro_name": "Zentex GP 1- MERGE" },
                { "pro_id": "57", "pro_name": "Zentex GP 2 -MERGE" }
            ],
            "Curing & Admixtures": [
                { "pro_id": "38", "pro_name": "Zentex AMN-120" },
                { "pro_id": "39", "pro_name": "Zentex APC-220" },
                { "pro_id": "37", "pro_name": "Zentex Cure WXB" },
                { "pro_id": "36", "pro_name": "Zentex Cure WT" },
                { "pro_id": "48", "pro_name": "Zentex CC-W" }
            ]
        };
    
        $('#category').change(function () {
            const selectedCategory = $(this).val();
            const productDropdown = $('#product');
            productDropdown.empty().append('<option value="" selected disabled hidden>Select Product</option>');
            if (selectedCategory && products[selectedCategory]) {
                products[selectedCategory].forEach(product => {
                    productDropdown.append(
                        `<option value="${product.pro_name}">${product.pro_name}</option>`
                    );
                });
            }
        });
     };

    mobileNav();
    onePage();
    headerFixed();
    scrollToTop();
    widgetSpacer();
    megaMenu();
    categoryChange();
    // Dom Ready
    $(function() {
        
        preLoader();
        searchIcon();
        fixNav();
        featuredMedia();
        relatedPost();
        responsiveVideos();
        AddGridVC();
    });
})(jQuery);
