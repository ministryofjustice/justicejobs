jQuery(document).ready(function ($) {
    // Injecting svg sprite in the beginning of document
    var ajax = new XMLHttpRequest();
    ajax.open('GET', justice.root_url + '/dist/img/sprite.svg', true);
    ajax.responseType = 'document';
    ajax.onload = function (e) {
        if (!ajax.responseXML) {
            // nothing for us here
        } else {
            document.body.insertBefore(
                ajax.responseXML.documentElement,
                document.body.childNodes[0]
            );
        }

    };
    ajax.send();

    $('.page-header__menu').click(function () {
        var target = $(this);

        if (target.hasClass('closed')) {
            $('body').addClass('disable-scrolling');
            target.removeClass('closed');
            target.addClass('open');
            target.attr('aria-expanded', 'true');

            if ($('#ccfw-page-banner-container').css('display') == 'block') {
                $('#main-nav-hook').removeClass('page-header__FixToCookieBanner container').addClass('page-header container')
            }
        } else {
            $('body').removeClass('disable-scrolling');
            target.removeClass('open');
            target.addClass('closed');
            target.attr('aria-expanded', 'false');

            if ($('#ccfw-page-banner-container').css('display') == 'block') {
                $('#main-nav-hook').removeClass('page-header container').addClass('page-header__FixToCookieBanner container')
            }
        }
    });

    $('.dropdown__current').on('click', e => {
        e.stopPropagation();
        var $target = $(e.target);
        var dropdown = $target.closest('.dropdown');

        if (dropdown.hasClass('is-opened')) {
            $target.closest('.dropdown').removeClass('is-opened');
        } else {
            $('.dropdown').removeClass('is-opened');
            $target.closest('.dropdown').addClass('is-opened');
        }
    });

    $('.dropdown__list li').on('click', function (e) {
        e.stopPropagation();
        var target = $(e.target);
        var val = e.target.innerHTML;
        var dropdown = target.closest('.dropdown');

        dropdown.find('.dropdown__current').val(val);
        dropdown.removeClass('is-opened');
    });

    $(document).on('click', function () {
        $('.dropdown').removeClass('is-opened');
    });

    /* Accordion controls */
    $('.accordion__btn').on('click', function () {
        $('.inner_accordion__block').removeClass('inner_is-opened');
        $('.inner_accordion__content-wrap').slideUp();
        var btn = $(this);
        var block = btn.closest('.accordion__block');

        if (block.hasClass('is-opened')) {
            block
                .removeClass('is-opened')
                .attr("aria-expanded", "false")
                .find('.accordion__content-wrap')
                .slideUp();
            $('.accordion__btn')
                .attr("aria-expanded", "false")
        } else {
            $('.accordion__block')
                .removeClass('is-opened')
                .attr("aria-expanded", "false")
                .find('.accordion__content-wrap')
                .slideUp();
            $('.accordion__btn')
                .attr("aria-expanded", "true")
            block
                .addClass('is-opened')
                .attr("aria-expanded", "true")
                .find('.accordion__content-wrap')
                .slideDown();
        }
    });

    // Inner Accordion controls
    $('.inner_accordion__btn').on('click', function () {
        var btn = $(this);
        var block = btn.closest('.inner_accordion__block');
        if (block.hasClass('inner_is-opened')) {
            block
                .removeClass('inner_is-opened')
                .attr("aria-expanded", "false")
                .find('.inner_accordion__content-wrap')
                .slideUp();
        } else {
            // $('.accordion__block')
            //   .removeClass('is-opened')
            //   .find('.accordion__content-wrap')
            //   .slideUp();
            block
                .addClass('inner_is-opened')
                .attr("aria-expanded", "true")
                .find('.inner_accordion__content-wrap')
                .slideDown();
        }
    });

    $('.accordion__btn').on('keydown', function (event) {
        var target = event.target;
        var key = event.which.toString();

        // 33 = Page Up, 34 = Page Down
        var ctrlModifier = (event.ctrlKey && key.match(/33|34/));

        // Collects where current focus is in relation to other accordions
        var triggers = $('.accordion__btn');
        var current = triggers.filter(target);
        var position = triggers.index(current);

        // 38 = Up, 40 = Down
        if (key.match(/38|40/) || ctrlModifier) {
            var direction = (key.match(/34|40/)) ? 1 : -1;
            var length = triggers.length;
            var newIndex = (position + length + direction) % length;
            triggers[newIndex].focus();
            event.preventDefault();
        } else if (key.match(/35|36/)) {
            // 35 = End, 36 = Home keyboard operations
            switch (key) {
                case '36':
                    triggers[0].focus();
                    break;
                case '35':
                    triggers[triggers.length - 1].focus();
                    break;
            }
            event.preventDefault();
        }
    });


    // Remove default inline styles from MCE tables
    $('td,th,table').removeAttr('style');
    $('td,th,table').removeAttr('width');
    $('td,th,table').removeAttr('border');

    // Change background colour of nav menu when scrolling down
    var position = $(window).scrollTop();
    $(document).scroll(function () {
        var scroll = $(window).scrollTop();
        var nav = $('.page-header__nav');
        var page_header = $('.page-header');

        page_header.toggleClass('scroll-down', $(this).scrollTop() > 0.6 * nav.height());
        // if (scroll > 2*nav.height() && scroll>position){
        //   console.log('scrolldown');
        //   page_header.addClass('scroll-down');
        // } else if (scroll < 2*nav.height() && scroll<position) {
        //   console.log('scrollup');
        //   page_header.addClass('scroll-up');
        // }
        // position = scroll;

    });

    if ($('.back-to-search').length) {

        var back_url = '/search-page/';
        var referrer = document.referrer;

        if(referrer.length > 0 && referrer.indexOf(document.domain) >= 0) {
            back_url = referrer;
        }

        $('.back-to-search').attr("href", back_url);

    }

    if ($('.job__text').length) {
        $('.job__text').children('p').each(function (e) {
            if (isEmpty($(this))) {
                $(this).remove();
            }
        });
    }

    var utilities = {
        init: function () {
            this.storageAvailable()
        },
        // Run a small test to determine if the browser can use local storage functionality
        // if not use browser cookies
        storageAvailable: function (type) {
            try {
                var storage = window[type]
                var x = '__storage_test__'
                storage.setItem(x, x)
                storage.removeItem(x)
                return true
            } catch (e) {
                return false
            }
        },
        getCookie: function (name) {
            var value = '; ' + document.cookie
            var parts = value.split('; ' + name + '=')
            if (parts.length === 2) {
                return parts.pop().split(';').shift()
            }
        }
    };

    var mainNavModify = {

        init: function () {
            this.cacheDom()
            this.replaceClass()
        },

        cacheDom: function () {
            if (utilities.storageAvailable('localStorage')) {
                this.localStorage = window.localStorage
            }
            this.$el = $('#main-nav-hook')
            this.headerWrapClass = this.$el.find('#menu-header-menu')
        },

        replaceClass: function () {
            var lStorage = this.localStorage.getItem('ccfwCookiePolicy') ? 'true' : 'false'

            if (lStorage === 'false') {
                this.$el.removeClass('page-header container').addClass('page-header__FixToCookieBanner container')
                this.headerWrapClass.removeClass('page-header__nav').addClass('page-header__navFixCookieBanner')
            }
        }
    };

    utilities.init();
    mainNavModify.init();

    function isEmpty(el) {
        return !$.trim(el.html());
    }


    $('.agency__carousel--full .accessible-carousel__arrow').each(function () {
        var color = $(this).closest('.agency__carousel').css('background-color');
        $(this).css('background-color', color);
    });

});
