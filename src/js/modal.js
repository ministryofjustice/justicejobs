jQuery(document).ready(function ($) {
  // OPENS MODALS

  //page-campaign.php / People Stories section / videos inside section carousel
  $('.campaign__carousel').on('click', '.video-campaign', function (e) {
    e.preventDefault();
    var videoSrc = $(this).data('video');
    $('.popup--video').find('iframe').prop('src', videoSrc);
    setTimeout(function () {
      $('.popup--video').addClass('is-opened');
      disableBodyScrolling();
      trapFocus();
    }, 500);
  });

  //page-campaign.php/Intro section & page-about.php/Overview section / single video
  $('.single-video').on('click', function (e) {
    e.preventDefault();
    var videoSrc = $(this).data('video');
    $('.popup--video').find('iframe').prop('src', videoSrc);
    setTimeout(function () {
      $('.popup--video').addClass('is-opened');
      disableBodyScrolling();
      trapFocus();
    }, 300);
  });

  $('.agency__featured').click(function (e) {
    var link = $(this).closest('.agency__featured').find('a').eq(0),
      resolveLink = null;

    // check for popup...
    if (link.attr('href')[0] === '#') {
      resolveLink = $(this).find('a.carousel-popup-open');
      if (resolveLink.length > 0) {
        $('.popup--carousel').eq(resolveLink.data('index')).addClass('is-opened');
        setTimeout(function () {
          trapFocus();
        }, 250);
      }
      return false;
    }
    window.location = link.prop('href');
  });

  $(window).resize(function () {
    maybe_show_close_btn($('.popup.is-opened'));
  });

  // CLOSES MODALS
  $('.popup .btn-close').on('click', () => {
    $('.popup').removeClass('is-opened');
    enableBodyScrolling();
    var firstPopupButton = document.getElementsByClassName("carousel-popup-open")[0];
    console.log(firstPopupButton);
    firstPopupButton.focus();
    var iframe = document.querySelector('iframe');
    if (iframe) {
      var iframeSrc = iframe.src;
      iframe.src = iframeSrc;
    }
  });

  $(document).on('keydown', function (event) {
    if($('.popup.is-opened')) {
      if (event.key == "Escape" || event.keyCode === 27) {
        $('.popup .btn-close').click();
        var firstPopupButton = document.getElementsByClassName("carousel-popup-open")[0];
        firstPopupButton.focus();
      }
    }
  });

  // Closes popup if background is clicked
  $(".popup").click(function (event) {
    if ($(event.target).hasClass('is-opened')) {
      $('.popup').removeClass('is-opened');
      enableBodyScrolling();
      var firstPopupButton = document.getElementsByClassName("carousel-popup-open")[0];
      firstPopupButton.focus();
    }
  });
});


function maybe_show_close_btn(ele) {
  if (ele instanceof jQuery && ele.length > 0) {
    var closeBtn = ele.find('.btn-close'),
      position = closeBtn.position(),
      btnHeight = closeBtn.outerHeight(),
      ii = 100,
      cnt = 0;

    if (!position.top) {
      return false;
    }

    if (closeBtn.is(':offscreen') || (position.top - 5) < btnHeight) {
      var blockToMove = ele.find('.popup__block'),
        distance = 10;

      for (ii; cnt < ii; ii++) {
        distance = distance + 20;
        blockToMove.css({
          top: distance
        });

        if (!closeBtn.is(':offscreen')) {
          blockToMove.css({
            top: distance + btnHeight
          });
          break;
        }
        cnt++;
      }
    }
  }
}

/**
 * Create a new jquery selector - :offscreen
 * obj.is(':offscreen')
 * @param el
 * @returns {boolean}
 */

jQuery.expr.filters.offscreen = function (el) {
  var rect = el.getBoundingClientRect();
  return (
    (rect.x + rect.width) < 0
    || (rect.y + rect.height) < 0
    || (rect.x > window.innerWidth || rect.y > window.innerHeight)
  );
};

function disableBodyScrolling() {
  document.body.style.position = 'fixed';
  document.body.style.top = `-${window.scrollY}px`;
}

function enableBodyScrolling() {
  const scrollY = document.body.style.top;
  document.body.style.position = '';
  document.body.style.top = '';
  window.scrollTo(0, parseInt(scrollY || '0') * -1);
}


// Based on example by Hidde de Vries
// https://hiddedevries.nl/en/blog/2017-01-29-using-javascript-to-trap-focus-in-an-element

function trapFocus() {
  var close = $('.popup.is-opened .btn-close');
  close.focus();
  var element = document.querySelector('.popup.is-opened');
  var focusableEls = element.querySelectorAll('.popup.is-opened a[href]:not([disabled]), button:not([disabled]');
  var firstFocusableEl = focusableEls[0];
  var lastFocusableEl = focusableEls[focusableEls.length - 1];
  var KEYCODE_TAB = 9;

  element.addEventListener('keydown', function (e) {
    var isTabPressed = (e.key === 'Tab' || e.keyCode === KEYCODE_TAB);

    if (!isTabPressed) {
      return;
    }

    if (e.shiftKey) /* shift + tab */ {
      if (document.activeElement === firstFocusableEl) {
        lastFocusableEl.focus();
        e.preventDefault();
      }
    } else /* tab */ {
      if (document.activeElement === lastFocusableEl) {
        firstFocusableEl.focus();
        e.preventDefault();
      }
    }
  });
}
