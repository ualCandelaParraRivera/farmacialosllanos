(function ($) {
    "use strict";

    var $window = $(window),
        $body = $('body');

    $('[data-bg-image]').each(function () {
        var $this = $(this),
            $image = $this.data('bg-image');
        $this.css('background-image', 'url(' + $image + ')');
    });
    $('[data-bg-color]').each(function () {
        var $this = $(this),
            $color = $this.data('bg-color');
        $this.css('background-color', $color);
    });

    $window.on('scroll', function () {
        if ($window.scrollTop() > 350) {
            $('.sticky-header').addClass('is-sticky');
        } else {
            $('.sticky-header').removeClass('is-sticky');
        }
    });

    var subMenuMegaMenuAlignment = () => {
        var $this,
            $subMenu,
            $megaMenu,
            $siteMainMenu = $('.site-main-menu');

        $siteMainMenu.each(function () {
            $this = $(this);
            if ($this.is('.site-main-menu-left, .site-main-menu-right') && $this.closest('.section-fluid').length) {
                $megaMenu = $this.find('.mega-menu');
                $this.css("position", "relative");
                if ($this.hasClass('site-main-menu-left')) {
                    $megaMenu.css({
                        "left": "0px",
                        "right": "auto"
                    });
                } else if ($this.hasClass('site-main-menu-left')) {
                    $megaMenu.css({
                        "right": "0px",
                        "left": "auto"
                    });
                }
            }
        });
        $subMenu = $('.sub-menu');
        if ($subMenu.length) {
            $subMenu.each(function () {
                $this = $(this);
                var $elementOffsetLeft = $this.offset().left,
                    $elementWidth = $this.outerWidth(true),
                    $windowWidth = $window.outerWidth(true) - 10,
                    isElementVisible = ($elementOffsetLeft + $elementWidth < $windowWidth);
                if (!isElementVisible) {
                    if ($this.hasClass('mega-menu')) {
                        var $this = $(this),
                            $thisOffsetLeft = $this.parent().offset().left,
                            $widthDiff = $windowWidth - $elementWidth,
                            $left = $thisOffsetLeft - ($widthDiff / 2);
                        $this.attr("style", "left:" + -$left + "px !important").parent().css("position", "relative");
                    } else {
                        $this.parent().addClass('align-left');
                    }
                } else {
                    $this.removeAttr('style').parent().removeClass('align-left');
                }
            });
        }
    }

    (function () {
        var $offCanvasToggle = $('.offcanvas-toggle'),
            $offCanvas = $('.offcanvas'),
            $offCanvasOverlay = $('.offcanvas-overlay'),
            $mobileMenuToggle = $('.mobile-menu-toggle');
        $offCanvasToggle.on('click', function (e) {
            e.preventDefault();
            var $this = $(this),
                $target = $this.attr('href');
            $body.addClass('offcanvas-open');
            $($target).addClass('offcanvas-open');
            $offCanvasOverlay.fadeIn();
            if ($this.parent().hasClass('mobile-menu-toggle')) {
                $this.addClass('close');
            }
        });
        $('.offcanvas-close, .offcanvas-overlay').on('click', function (e) {
            e.preventDefault();
            $body.removeClass('offcanvas-open');
            $offCanvas.removeClass('offcanvas-open');
            $offCanvasOverlay.fadeOut();
            $mobileMenuToggle.find('a').removeClass('close');
        });
    })();

    function mobileOffCanvasMenu() {
        var $offCanvasNav = $('.offcanvas-menu, .overlay-menu'),
            $offCanvasNavSubMenu = $offCanvasNav.find('.sub-menu');

        $offCanvasNavSubMenu.parent().prepend('<span class="menu-expand"></span>');

        $offCanvasNav.on('click', 'li a, .menu-expand', function (e) {
            var $this = $(this);
            if ($this.attr('href') === '#' || $this.hasClass('menu-expand')) {
                e.preventDefault();
                if ($this.siblings('ul:visible').length) {
                    $this.parent('li').removeClass('active');
                    $this.siblings('ul').slideUp();
                    $this.parent('li').find('li').removeClass('active');
                    $this.parent('li').find('ul:visible').slideUp();
                } else {
                    $this.parent('li').addClass('active');
                    $this.closest('li').siblings('li').removeClass('active').find('li').removeClass('active');
                    $this.closest('li').siblings('li').find('ul:visible').slideUp();
                    $this.siblings('ul').slideDown();
                }
            }
        });
    }
    mobileOffCanvasMenu();

    $('.header-categories').on('click', '.category-toggle', function (e) {
        e.preventDefault();
        var $this = $(this);
        if ($this.hasClass('active')) {
            $this.removeClass('active').siblings('.header-category-list').slideUp();
        } else {
            $this.addClass('active').siblings('.header-category-list').slideDown();
        }
    })

    $('.product-filter-toggle').on('click', function (e) {
        e.preventDefault();
        var $this = $(this),
            $target = $this.attr('href');
        $this.toggleClass('active');
        $($target).slideToggle();
        $('.customScroll').perfectScrollbar('update');
    });

    $('.product-column-toggle').on('click', '.toggle', function (e) {
        e.preventDefault();
        var $this = $(this),
            $column = $this.data('column'),
            $prevColumn = $this.siblings('.active').data('column');
        $this.toggleClass('active').siblings().removeClass('active');
        $('.products').removeClass('row-cols-xl-' + $prevColumn).addClass('row-cols-xl-' + $column);
        $.fn.matchHeight._update();
        $('.isotope-grid').isotope('layout');
    });

    $('.customScroll').perfectScrollbar({
        suppressScrollX: !0
    });

    $('.select2-basic').select2();
    $('.select2-noSearch').select2({
        minimumResultsForSearch: Infinity
    });

    $('.nice-select').niceSelect();

    $('.isotope-grid .product').matchHeight();

    $(".range-slider").ionRangeSlider({
        skin: "learts",
        hide_min_max: true,
        type: 'double',
        prefix: "€",
    });

    (function () {
        if (typeof mojs == 'undefined') {
            return;
        }
        var burst = new mojs.Burst({
            left: 0,
            top: 0,
            radius: {
                4: 32
            },
            angle: 45,
            count: 14,
            children: {
                radius: 2.5,
                fill: ['#F8796C'],
                scale: {
                    1: 0,
                    easing: 'quad.in'
                },
                pathScale: [.8, null],
                degreeShift: [13, null],
                duration: [500, 700],
                easing: 'quint.out'
            }
        });
        $('.add-to-wishlist').on('click', function (e) {
            var $this = $(this),
                offset = $this.offset(),
                width = $this.width(),
                height = $this.height(),
                coords = {
                    x: offset.left + width / 2,
                    y: offset.top + height / 2
                };
            if (!$this.hasClass('wishlist-added')) {
                e.preventDefault();
                $this.addClass('wishlist-added').find('i').removeClass('far').addClass('fas');
                burst.tune(coords).replay();
            }
        });
    })();

    $.Scrollax();

    var $home1Slider = new Swiper('.home1-slider', {
        loop: true,
        speed: 750,
        effect: 'fade',
        navigation: {
            nextEl: '.home1-slider-next',
            prevEl: '.home1-slider-prev',
        },
        autoplay: {},
    });

    var $home2Slider = new Swiper('.home2-slider', {
        loop: true,
        speed: 750,
        effect: 'fade',
        navigation: {
            nextEl: '.home2-slider-next',
            prevEl: '.home2-slider-prev',
        },
        autoplay: {},
        on: {
            slideChange: function () {
                this.$el.find('.slide-product').removeClass('active');
            },
        }
    });
    $('.home2-slider').on('click', '.slide-pointer', function (e) {
        e.preventDefault();
        $(this).siblings('.slide-product').toggleClass('active');
    })

    var $home3Slider = new Swiper('.home3-slider', {
        loop: true,
        speed: 750,
        effect: 'fade',
        navigation: {
            nextEl: '.home3-slider-next',
            prevEl: '.home3-slider-prev',
        },
        autoplay: {},
    });

    var $home4Slider = new Swiper('.home4-slider', {
        loop: true,
        loopedSlides: 2,
        speed: 750,
        spaceBetween: 200,
        pagination: {
            el: '.home4-slider-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.home4-slider-next',
            prevEl: '.home4-slider-prev',
        },
        autoplay: {},
    });

    var $home5Slider = new Swiper('.home5-slider', {
        loop: true,
        speed: 750,
        spaceBetween: 30,
        pagination: {
            el: '.home5-slider-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.home5-slider-next',
            prevEl: '.home5-slider-prev',
        },
    });

    var $home7Slider = new Swiper('.home7-slider', {
        loop: true,
        speed: 750,
        spaceBetween: 30,
        effect: 'fade',
        pagination: {
            el: '.home7-slider-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.home7-slider-next',
            prevEl: '.home7-slider-prev',
        },
        autoplay: {},
    });

    var $home8Slider = new Swiper('.home8-slider', {
        loop: true,
        speed: 750,
        spaceBetween: 30,
        effect: 'fade',
        pagination: {
            el: '.home8-slider-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.home8-slider-next',
            prevEl: '.home8-slider-prev',
        },
    });

    var $home12Slider = new Swiper('.home12-slider', {
        loop: true,
        speed: 750,
        spaceBetween: 30,
        effect: 'fade',
        pagination: {
            el: '.home12-slider-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.home12-slider-next',
            prevEl: '.home12-slider-prev',
        },
    });
    $('.product-carousel').slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 1,
        focusOnSelect: true,
        prevArrow: '<button class="slick-prev"><i class="ti-angle-left"></i></button>',
        nextArrow: '<button class="slick-next"><i class="ti-angle-right"></i></button>',
        responsive: [{
                breakpoint: 991,
                settings: {
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 575,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });

    $('.product-list-slider').slick({
        rows: 3,
        prevArrow: '<button class="slick-prev"><i class="ti-angle-left"></i></button>',
        nextArrow: '<button class="slick-next"><i class="ti-angle-right"></i></button>'
    });

    $('.product-gallery-slider').slick({
        dots: true,
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        asNavFor: '.product-thumb-slider, .product-thumb-slider-vertical',
        prevArrow: '<button class="slick-prev"><i class="ti-angle-left"></i></button>',
        nextArrow: '<button class="slick-next"><i class="ti-angle-right"></i></button>'
    });
    $('.product-thumb-slider').slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 1,
        focusOnSelect: true,
        asNavFor: '.product-gallery-slider',
        prevArrow: '<button class="slick-prev"><i class="ti-angle-left"></i></button>',
        nextArrow: '<button class="slick-next"><i class="ti-angle-right"></i></button>'
    });
    $('.product-thumb-slider-vertical').slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        vertical: true,
        focusOnSelect: true,
        asNavFor: '.product-gallery-slider',
        prevArrow: '<button class="slick-prev"><i class="ti-angle-up"></i></button>',
        nextArrow: '<button class="slick-next"><i class="ti-angle-down"></i></button>'
    });

    $('.blog-carousel').slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        focusOnSelect: true,
        prevArrow: '<button class="slick-prev"><i class="ti-angle-left"></i></button>',
        nextArrow: '<button class="slick-next"><i class="ti-angle-right"></i></button>',
        responsive: [{
                breakpoint: 991,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });

    $('.brand-carousel').slick({
        infinite: true,
        slidesToShow: 5,
        slidesToScroll: 1,
        focusOnSelect: true,
        prevArrow: '<button class="slick-prev"><i class="ti-angle-left"></i></button>',
        nextArrow: '<button class="slick-next"><i class="ti-angle-right"></i></button>',
        responsive: [{
            breakpoint: 1199,
            settings: {
                slidesToShow: 4
            }
        }, {
            breakpoint: 991,
            settings: {
                slidesToShow: 3
            }
        }, {
            breakpoint: 767,
            settings: {
                slidesToShow: 2
            }
        }, {
            breakpoint: 575,
            settings: {
                slidesToShow: 1
            }
        }]
    });

    $('.testimonial-slider').slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        prevArrow: '<button class="slick-prev"><i class="ti-angle-left"></i></button>',
        nextArrow: '<button class="slick-next"><i class="ti-angle-right"></i></button>'
    });
    $('.testimonial-carousel').slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        prevArrow: '<button class="slick-prev"><i class="ti-angle-left"></i></button>',
        nextArrow: '<button class="slick-next"><i class="ti-angle-right"></i></button>',
        responsive: [{
                breakpoint: 991,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });

    $('.category-banner1-carousel').slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        prevArrow: '<button class="slick-prev"><i class="fal fa-long-arrow-left"></i></button>',
        nextArrow: '<button class="slick-next"><i class="fal fa-long-arrow-right"></i></button>',
        responsive: [{
                breakpoint: 991,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });

    var $isotopeGrid = $('.isotope-grid');
    var $isotopeFilter = $('.isotope-filter');
    $isotopeGrid.imagesLoaded(function () {
        $isotopeGrid.isotope({
            itemSelector: '.grid-item',
            masonry: {
                columnWidth: '.grid-sizer'
            }
        });
    });
    $isotopeFilter.on('click', 'button', function () {
        var $this = $(this),
            $filterValue = $this.attr('data-filter'),
            $targetIsotop = $this.parent().data('target');
        $this.addClass('active').siblings().removeClass('active');
        $($targetIsotop).isotope({
            filter: $filterValue
        });
    });

    $('#mc-form').ajaxChimp({
        language: 'en',
        callback: mailChimpResponse,
        url: 'http://devitems.us11.list-manage.com/subscribe/post?u=6bbb9b6f5827bd842d9640c82&amp;id=05d85f18ef'

    });

    function mailChimpResponse(resp) {
        if (resp.result === 'success') {
            $('.mailchimp-success').html('' + resp.msg).fadeIn(900);
            $('.mailchimp-error').fadeOut(400);
        } else if (resp.result === 'error') {
            $('.mailchimp-error').html('' + resp.msg).fadeIn(900);
        }
    }

    $.instagramFeed({
        'username': 'hempleafspain',
        'container': ".instagram-feed",
        'display_profile': false,
        'display_biography': false,
        'display_gallery': true,
        'styling': false,
        'items': 12,
        "image_size": "320",
    });
    $('.instagram-feed').on("DOMNodeInserted", function (e) {
        if (e.target.className == 'instagram_gallery') {
            $('.instagram-carousel1 .' + e.target.className).slick({
                infinite: true,
                slidesToShow: 5,
                slidesToScroll: 1,
                prevArrow: '<button class="slick-prev"><i class="ti-angle-left"></i></button>',
                nextArrow: '<button class="slick-next"><i class="ti-angle-right"></i></button>',
                responsive: [{
                    breakpoint: 119,
                    settings: {
                        slidesToShow: 4
                    }
                }, {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 3
                    }
                }, {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 2
                    }
                }, {
                    breakpoint: 575,
                    settings: {
                        slidesToShow: 1
                    }
                }]
            })
            $('.instagram-carousel2 .' + e.target.className).slick({
                infinite: true,
                slidesToShow: 3,
                slidesToScroll: 1,
                prevArrow: '<button class="slick-prev"><i class="ti-angle-left"></i></button>',
                nextArrow: '<button class="slick-next"><i class="ti-angle-right"></i></button>',
                responsive: [{
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 2
                    }
                }, {
                    breakpoint: 575,
                    settings: {
                        slidesToShow: 1
                    }
                }]
            });
        }
    });
    $('[data-countdown]').each(function () {
        var $this = $(this),
            $finalDate = $this.data('countdown');
        $this.countdown($finalDate, function (event) {
            $this.html(event.strftime('<div class="count"><span class="amount">%-D</span><span class="period">Days</span></div><div class="count"><span class="amount">%-H</span><span class="period">Hours</span></div><div class="count"><span class="amount">%-M</span><span class="period">Minutes</span></div><div class="count"><span class="amount">%-S</span><span class="period">Seconds</span></div>'));
        });
    });

    $('.collapse').on('show.bs.collapse', function (e) {
        $(this).closest('.card').addClass('active').siblings().removeClass('active');
    });
    $('.collapse').on('hide.bs.collapse', function (e) {
        $(this).closest('.card').removeClass('active');
    });

    $('#quickViewModal').on('shown.bs.modal', function (e) {
        $('.product-gallery-slider-quickview').slick({
            dots: true,
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            prevArrow: '<button class="slick-prev"><i class="ti-angle-left"></i></button>',
            nextArrow: '<button class="slick-next"><i class="ti-angle-right"></i></button>'
        });
    })

    $("a.addToCart").on("click",function(){
        var id = $(this).attr("data-id");
        console.log(id);
        $.ajax({
            type: "GET",
            url: "controller/cart?id="+id+"&action=add"
        })
        .done(function(data)
        {
            var x = JSON.parse(data);
            $('#alertmodal').html(x.text);
            $('#alertmodal').data('id', id).modal('show');
        });
    });
    $("#modalBtnConfirm").on("click",function(){
        location.reload();
    });

    $("a.removeFromCart").on("click",function(){
        var id = $(this).attr("data-id");
        $.ajax({
            type: "GET",
            url: "controller/cart?id="+id+"&action=remove"
        })
        .done(function(data)
        {
            location.reload();
        });
    });

    $("a.emptyCart").on("click",function(){
        $.ajax({
            type: "GET",
            url: "controller/cart?action=empty"
        })
        .done(function(data)
        {
            location.reload();
        });
    });

    $('.qty-btn').on('click', function () {
        var $this = $(this);
        var oldValue = $this.siblings('input').val();
        var id = $(this).attr("data-id");
        if ($this.hasClass('plus')) {
            var newVal = parseFloat(oldValue) + 1;
            $.ajax({
                type: "GET",
                url: "controller/cart?id="+id+"&action=set&val="+newVal+""
            })
            .done(function()
            {
                location.reload();
            });
        } else if($this.hasClass('minus')) {
            if (oldValue > 1) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 1;
            }
            $.ajax({
                type: "GET",
                url: "controller/cart?id="+id+"&action=set&val="+newVal+""
            })
            .done(function()
            {
                location.reload();
            });
        } else if ($this.hasClass('pluss')) {
            var newVal = parseFloat(oldValue) + 1;
        } else if($this.hasClass('minuss')) {
            if (oldValue > 1) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 1;
            }
        }

        $this.siblings('input').val(newVal);
    });

    $('#addToCartDetails').on('click', function () {
        var $this = $('.input-qty');
        var value = $this.val();
        var id = $(this).attr("data-id");
        $.ajax({
            type: "GET",
            url: "controller/cart?id="+id+"&action=addqty&val="+value+""
        })
        .done(function(data)
        {
            var x = JSON.parse(data);
            $('#alertmodal').html(x.text);
            $('#alertmodal').data('id', id).modal('show');
        });
    });

    $('#submitpromocode').on('click', function () {
        var $this = $('#input-promo');
        var value = $this.val();
        $('.help-block').remove();
        $.ajax({
            type: "GET",
            url: "controller/cart?action=promocart&val="+value+""
        })
        .done(function(data)
        {
            var x = JSON.parse(data);
            console.log(x);
            if (!x.success) {
                $('.cart-coupon').append('<div class="help-block">' + x.message + '</div>');
            }else{
                location.reload();
            }
        });
    });

    $('#billcountry').on('change', function() {
        console.log($(this).val());
        var country = $(this).val();
        if (country) {
            $.ajax({
                type: 'POST',
                url: 'controller/loaddataselect',
                data: {
                    'country': country
                },
                success: function(html) {
                    $('#billdistrict').html(html);
                    $('#billdistrict').niceSelect('update');
                }
            });
        } else {
            $('#billdistrict').html('<option value="">Selecciona un pais...</option>');
            $('#billdistrict').niceSelect('update');
        }
    });

    $('#shipcountry').on('change', function() {
        console.log($(this).val());
        var country = $(this).val();
        if (country) {
            $.ajax({
                type: 'POST',
                url: 'controller/loaddataselect',
                data: {
                    'country': country
                },
                success: function(html) {
                    $('#shipdistrict').html(html);
                    $('#shipdistrict').niceSelect('update');
                }
            });
        } else {
            $('#shipdistrict').html('<option value="">Selecciona un pais...</option>');
            $('#shipdistrict').niceSelect('update');
        }
    });

    $('#shipdistrict').on('change', function() {
        console.log($(this).val());
        var district = $(this).val();
        var weight = $('#weight').val();
        console.log(district);
        if (district != "") {
            $.ajax({
                type: 'POST',
                url: 'controller/loadshipmentselect',
                data: {
                    'district': district, 'weight': weight
                },
                success: function(data) {
                    var x = JSON.parse(data);

                    $("#option1").prop("disabled", x.glsislasdisabled != " disabled");
                    $("#option2").prop("disabled", x.glsislasdisabled != " disabled");
                    $("#option3").prop("disabled", x.glsislasdisabled != " disabled");
                    $("#option4").prop("disabled", x.glsislasdisabled != " disabled");
                    $("#option5").prop("disabled", x.glsislasdisabled == " disabled");
                    $("#option1").val(x.glseco);
                    $("#option2").val(x.gls24);
                    $("#option3").val(x.gls14);
                    $("#option4").val(x.gls10);
                    $("#option5").val(x.glsislas);
                    $('.card-body label').html('<i class="fa fa-truck"></i>');
                    $("#option1").prop('checked', false);
                    $("#option2").prop('checked', false);
                    $("#option3").prop('checked', false);
                    $("#option4").prop('checked', false);
                    $("#option5").prop('checked', false);
                    $('#shipmenttype').val("");
                    $('#shipmentprice').val(-1);
                }
            });
        }else{
            $("#option1").prop("disabled", true);
            $("#option2").prop("disabled", true);
            $("#option3").prop("disabled", true);
            $("#option4").prop("disabled", true);
            $("#option5").prop("disabled", true);
            $("#option1").val(0);
            $("#option2").val(0);
            $("#option3").val(0);
            $("#option4").val(0);
            $("#option5").val(0);
            $('.card-body label').html('<i class="fa fa-truck"></i>');
            $("#option1").prop('checked', false);
            $("#option2").prop('checked', false);
            $("#option3").prop('checked', false);
            $("#option4").prop('checked', false);
            $("#option5").prop('checked', false);
            $('#shipmenttype').val("");
            $('#shipmentprice').val(-1);
            var finalprice = $('#finalprice').val();
            $('#shippingcost').html('<span>-€</span>');
            $('#grandtotal').html('<span>'+parseFloat(finalprice).toFixed(2)+'€</span>');
        }
    });

    $('#billCountry').on('change', function() {
        console.log($(this).val());
        var country = $(this).val();
        if (country) {
            $.ajax({
                type: 'POST',
                url: 'controller/loaddataselect',
                data: {
                    'country': country
                },
                success: function(html) {
                    $('#billDistrict').html(html);
                    $('#billDistrict').niceSelect('update');
                }
            });
        } else {
            $('#billDistrict').html('<option value="">Selecciona un pais...</option>');
            $('#billDistrict').niceSelect('update');
        }
    });

    $('#shipCountry').on('change', function() {
        console.log($(this).val());
        var country = $(this).val();
        if (country) {
            $.ajax({
                type: 'POST',
                url: 'controller/loaddataselect',
                data: {
                    'country': country
                },
                success: function(html) {
                    $('#shipDistrict').html(html);
                    $('#shipDistrict').niceSelect('update');
                }
            });
        } else {
            $('#shipDistrict').html('<option value="">Selecciona un pais...</option>');
            $('#shipDistrict').niceSelect('update');
        }
    });

    $('#accountCheck').on('click', function () {
        if ($(this).prop('checked')) {
            $('#accountInput').fadeIn();
        } else {
            $('#accountInput').hide();
        }
    });

    $('#wirebtn').on('click', function () {
        $('#paymenttype').val('w')
    });

    $('#cardbtn').on('click', function () {
        $('#paymenttype').val('c')
    });

    $('#paypalbtn').on('click', function () {
        $('#paymenttype').val('p')
    });

    $('#option1').on('click', function () {
        $('#shipmenttype').val('eco')
    });

    $('#option2').on('click', function () {
        $('#shipmenttype').val('gls24')
    });

    $('#option3').on('click', function () {
        $('#shipmenttype').val('gls14')
    });

    $('#option4').on('click', function () {
        $('#shipmenttype').val('gls10')
    });

    $('#option5').on('click', function () {
        $('#shipmenttype').val('glsislas')
    });

    $("input[name='options']").click(function() {
        $('.card-body label').html('<i class="fa fa-truck"></i>');
        if(this.checked){
            $(this).next().html('<i class="fa fa-check"></i>');
            $('#shipmentprice').val(this.value);
            var finalprice = $('#finalprice').val();
            var newfinalprice = parseFloat(finalprice)+parseFloat(this.value);
            $('#shippingcost').html('<span>'+parseFloat(this.value).toFixed(2)+'€</span>');
            $('#grandtotal').html('<span>'+parseFloat(newfinalprice).toFixed(2)+'€</span>');
        }
   });

    $('.post-share').on('click', ".toggle", function () {
        var $this = $(this),
            $target = $this.parent();
        $target.hasClass('active') ? $target.removeClass('active') : $target.addClass('active');
    });

    $('.video-popup').magnificPopup({
        type: 'iframe'
    });

    $.scrollUp({
        scrollText: '<i class="fal fa-long-arrow-up"></i>',
    });

    var $productPopupGalleryBtn = $('.product-gallery-popup'),
        $productPopupGallery = $productPopupGalleryBtn.data('images'),
        $openPhotoSwipe = function () {
            var pswpElement = $('.pswp')[0],
                items = $productPopupGallery,
                options = {
                    history: false,
                    focus: false,
                    closeOnScroll: false,
                    showAnimationDuration: 0,
                    hideAnimationDuration: 0
                };
            new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options).init();
        };
    $productPopupGalleryBtn.on('click', $openPhotoSwipe);

    $('.product-zoom').each(function () {
        var $this = $(this),
            $image = $this.data('image');
        $this.zoom({
            url: $image
        });
    });

    $('.sticky-sidebar').stickySidebar({
        topSpacing: 60,
        bottomSpacing: 60,
        containerSelector: '.sticky-sidebar-container',
        innerWrapperSelector: '.sticky-sidebar-inner',
        minWidth: 992
    });

    $(function () {
        var form = $('#contact-form');
        var formMessages = $('.form-messege');
        $(form).submit(function (e) {
            e.preventDefault();
            var formData = $(form).serialize();
            $.ajax({
                    type: 'POST',
                    url: $(form).attr('action'),
                    data: formData
                })
                .done(function (response) {
                    formMessages.removeClass('error text-danger').addClass('success text-success learts-mt-10').text(response);
                    form.find('input:not([type="submit"]), textarea').val('');
                })
                .fail(function (data) {
                    formMessages.removeClass('success text-success').addClass('error text-danger mt-3');
                    if (data.responseText !== '') {
                        formMessages.text(data.responseText);
                    } else {
                        formMessages.text('Oops! An error occured and your message could not be sent.');
                    }
                });
        });
    });

    $window.on('load', function () {
        subMenuMegaMenuAlignment();
    });

    $window.resize(function () {
        subMenuMegaMenuAlignment();
    });

})(jQuery);