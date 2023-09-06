/* Focusin/out event polyfill (for Firefox) by nuxodin
 * Source: https://gist.github.com/nuxodin/9250e56a3ce6c0446efa
 */
jQuery(document).ready(function ($) {
    var w = window,
        d = w.document;

    if (w.onfocusin === undefined) {
        d.addEventListener('focus', addPolyfill, true);
        d.addEventListener('blur', addPolyfill, true);
        d.addEventListener('focusin', removePolyfill, true);
        d.addEventListener('focusout', removePolyfill, true);
    }

    function addPolyfill (e) {
        var type = e.type === 'focus' ? 'focusin' : 'focusout';
        var event = new CustomEvent(type, { bubbles: true, cancelable: false });
        event.c1Generated = true;
        e.target.dispatchEvent(event);
    }

    function removePolyfill (e) {
        if (!e.c1Generated) { // focus after focusin, so chrome will the first time trigger tow times focusin
            d.removeEventListener('focus', addPolyfill, true);
            d.removeEventListener('blur', addPolyfill, true);
            d.removeEventListener('focusin', removePolyfill, true);
            d.removeEventListener('focusout', removePolyfill, true);
        }
        setTimeout(function () {
            d.removeEventListener('focusin', removePolyfill, true);
            d.removeEventListener('focusout', removePolyfill, true);
        });
    }

    /*
       Carousel Prototype
       Eric Eggert for W3C
    */

    var myCarousel = (function () {

        'use strict';

        // Initial variables
        var carousel, carouselCtrls, slides, index, slidenav, settings, timer, setFocus, animationSuspended,
            announceItem, _this;

        // Helper function: Iterates over an array of elements
        function forEachElement (elements, fn) {
            for (var i = 0; i < elements.length; i++)
                fn(elements[i], i);
        }

        // Helper function: Remove Class
        function removeClass (el, className) {
            if (el.classList) {
                el.classList.remove(className);
            } else {
                el.className = el.className.replace(new RegExp('(^|\\b)' + className.split(' ').join('|') + '(\\b|$)', 'gi'), ' ');
            }
        }

        // Helper function: Test if element has a specific class
        function hasClass (el, className) {
            if (el.classList) {
                return el.classList.contains(className);
            } else {
                return new RegExp('(^| )' + className + '( |$)', 'gi').test(el.className);
            }
        }

        // Initialization for the carousel
        // Argument: set = an object of settings
        // Possible settings:
        // id <string> ID of the carousel wrapper element (required).
        // slidenav <bool> If true, a list of slides is shown.
        function init (set) {

            // Make settings available to all functions
            settings = set;

            // Select the element and the individual slides
            carousel = document.getElementById(settings.id);

            if (!carousel) {
                return false;
            }

            carouselCtrls = carousel.querySelectorAll('.accessible-carousel__controls')[0];
            slides = carousel.querySelectorAll('.accessible-carousel__slide');

            carousel.className = 'accessible-carousel';

            // Create unordered list for controls, and attach click events fo previous and next slide
            var ctrls = document.createElement('ul');

            ctrls.className = 'controls';
            ctrls.innerHTML = '<li>' +
                '<button type="button" class="btn-prev accessible-carousel__arrow--prev accessible-carousel__arrow" aria-describedby="previous-carousel-button"><title id="previous-carousel-button">Go to the previous item</title><svg width="16" height="25"><use xlink:href= "#icon-arrow"></use></svg ></button>' +
                '</li>' +
                '<li>' +
                '<button type="button" class="btn-next accessible-carousel__arrow--next accessible-carousel__arrow" aria-describedby="next-carousel-button"><title id="next-carousel-button">Go to the next item</title><svg width="16" height="25"><use xlink:href= "#icon-arrow"></use></svg ></button>' +
                '</li>';

            ctrls.querySelector('.btn-prev')
                .addEventListener('click', function () {
                    prevSlide(true);
                });
            ctrls.querySelector('.btn-next')
                .addEventListener('click', function () {
                    nextSlide(true);
                });

            // If slide navigation is requested in the settings, another unordered list that contains those elements is added.
            if (settings.slidenav) {
                slidenav = document.createElement('ul');
                slidenav.className = 'slidenav';

                if (settings.slidenav) {
                    forEachElement(slides, function (el, i) {
                        var li = document.createElement('li');
                        var klass = (i === 0) ? 'class="slide-nav__button--current" ' : '';
                        var kurrent = (i === 0) ? ' <span class="visually-hidden">(Current item)</span>' : '';
                        li.innerHTML = '<button ' + klass + 'data-slide="' + i + '"><span class="visually-hidden">' + (i !== 0 ? 'View ' : 'Viewing ') + 'item</span> ' + (i + 1) + kurrent + '</button>';
                        slidenav.appendChild(li);
                    });
                }

                slidenav.addEventListener('click', function (event) {
                    var button = event.target;
                    if (button.localName == 'button') {
                        if (button.getAttribute('data-slide')) {
                            setSlides(button.getAttribute('data-slide'), true);
                        }
                    }
                }, true);

                carousel.className = 'accessible-carousel with-slidenav';
                carouselCtrls.appendChild(slidenav);
            }

            carouselCtrls.appendChild(ctrls);

            // Add a live region to announce the slide number when using the previous/next buttons
            var liveregion = document.createElement('div');
            liveregion.setAttribute('aria-live', 'polite');
            liveregion.setAttribute('aria-atomic', 'true');
            liveregion.setAttribute('class', 'liveregion visually-hidden');
            carousel.appendChild(liveregion);

            // After the slide transitioned, remove the in-transition class, if focus should be set, set the tabindex attribute to -1 and focus the slide.
            slides[0].parentNode.addEventListener('transitionend', function (event) {
                var slide = event.target;
                removeClass(slide, 'in-transition');
                if (hasClass(slide, 'current')) {
                    if (setFocus) {
                        slide.setAttribute('tabindex', '-1');
                        slide.focus();
                        setFocus = false;
                    }
                }
            });

            // Set the index (=current slide) to 0 – the first slide
            index = 0;
            setSlides(index);
        }

        // Function to set a slide the current slide
        function setSlides (new_current, setFocusHere, transition, announceItemHere) {
            // Focus, transition and announce Item are optional parameters.
            // focus denotes if the focus should be set after the
            // carousel advanced to slide number new_current.
            // transition denotes if the transition is going into the
            // next or previous direction.
            // If announceItem is set to true, the live region’s text is changed (and announced)
            // Here defaults are set:

            setFocus = typeof setFocusHere !== 'undefined' ? setFocusHere : false;
            transition = typeof transition !== 'undefined' ? transition : 'none';
            announceItem = typeof announceItemHere !== 'undefined' ? announceItemHere : false;
            new_current = parseFloat(new_current);

            var length = slides.length;
            var new_next = new_current + 1;
            var new_prev = new_current - 1;

            // If the next slide number is equal to the length,
            // the next slide should be the first one of the slides.
            // If the previous slide number is less than 0.
            // the previous slide is the last of the slides.
            if (new_next === length) {
                new_next = 0;
            } else if (new_prev < 0) {
                new_prev = length - 1;
            }

            // Reset slide classes
            for (var i = slides.length - 1; i >= 0; i--) {
                slides[i].className = 'accessible-carousel__slide';
            }

            // Add classes to the previous, next and current slide
            slides[new_next].className = 'next accessible-carousel__slide' + ((transition == 'next') ? ' in-transition' : '');
            slides[new_next].setAttribute('aria-hidden', 'true');

            slides[new_prev].className = 'prev accessible-carousel__slide' + ((transition == 'prev') ? ' in-transition' : '');
            slides[new_prev].setAttribute('aria-hidden', 'true');

            slides[new_current].className = 'current accessible-carousel__slide';
            slides[new_current].removeAttribute('aria-hidden');

            // Update the text in the live region which is then announced by screen readers.
            if (announceItem) {
                carousel.querySelector('.liveregion').textContent = 'Slide ' + (new_current + 1) + ' of ' + slides.length;
            }

            // Update the buttons in the slider navigation to match the currently displayed  item
            if (settings.slidenav) {
                var buttons = carousel.querySelectorAll('.slidenav button[data-slide]');
                for (var j = buttons.length - 1; j >= 0; j--) {
                    buttons[j].className = '';
                    buttons[j].innerHTML = '<span class="visually-hidden">View item </span> ' + (j + 1) + '<span class="visually-hidden"> of '+ slides.length + '</span>';
                }
                buttons[new_current].className = 'current';
                buttons[new_current].innerHTML = '<span class="visually-hidden">Viewing item </span> ' + (new_current + 1) + ' <span class="visually-hidden">of ' + slides.length + ' (Current item)</span>';
            }

            // Set the global index to the new current value
            index = new_current;
        }

        // Function to advance to the next slide
        function nextSlide (announceItem) {
            announceItem = typeof announceItem !== 'undefined' ? announceItem : false;

            var length = slides.length,
                new_current = index + 1;

            if (new_current === length) {
                new_current = 0;
            }

            // If we advance to the next slide, the previous needs to be
            // visible to the user, so the third parameter is 'prev', not
            // next.
            setSlides(new_current, false, 'prev', announceItem);
        }

        // Function to advance to the previous slide
        function prevSlide (announceItem) {
            announceItem = typeof announceItem !== 'undefined' ? announceItem : false;

            var length = slides.length,
                new_current = index - 1;

            // If we are already on the first slide, show the last slide instead.
            if (new_current < 0) {
                new_current = length - 1;
            }

            // If we advance to the previous slide, the next needs to be
            // visible to the user, so the third parameter is 'next', not
            // prev.
            setSlides(new_current, false, 'next', announceItem);
        }

        // Making some functions public
        return {
            init: init,
            next: nextSlide,
            prev: prevSlide,
            goto: setSlides
        };
    });

    var carousel = new myCarousel();
    carousel.init({
        id: 'accessible-carousel',
        slidenav: true
    });

    var carouselLatestRoles = new myCarousel();
    carouselLatestRoles.init({
        id: 'accessible-carousel-latest-roles',
        slidenav: true
    });

    var carouselCurrentRoles = new myCarousel();
    carouselCurrentRoles.init({
        id: 'accessible-full-carousel',
        slidenav: true
    });
});
