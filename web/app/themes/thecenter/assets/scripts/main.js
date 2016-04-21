// FBSage - Firebelly 2015
/*jshint latedef:false*/

// Good Design for Good Reason for Good Namespace
var FBSage = (function($) {

  var screen_width = 0,
      breakpoint_small = false,
      breakpoint_medium = false,
      breakpoint_large = false,
      breakpoint_array = [768,768,1092],
      $document,
      $sidebar,
      loadingTimer,
      page_at;

  function _init() {
    // touch-friendly fast clicks
    FastClick.attach(document.body);

    // Cache some common DOM queries
    $document = $(document);
    $('body').addClass('loaded');

    //inject user agent into data attr in html so we can grab it in css and target ie10/11
    _ieDetect(); 

    // Set screen size vars
    _resize();

    //initialize sliders
    _initSliders();

    //fix the center to the top of the screen after it's scrolled 36px
    _initStickies();

    //allow nav to push in on click of .nav-toggle
    _initNav();

    //remove duotone headline on mouseover, follow link on click
    _headlineMouseEvents();

    //put the svg icons inline to grab with use
    _injectSvgSprite();

    //replace date with svg numbers
    _replaceDate();

    //staff modals
    _staffModals(); 

    //handle sort dropdown menu in archive listing
    _sortDropDown();

    //make search bar appear
    _initSearch();

    //position/resize staff modals (too hard with css)
    _styleStaff(); 

    //push down recessed page content if headline-title overlaps 
    //-- wish I could think of a way to do this with css
    _pushPageRecess();

    //crazy hack to get the gray highlight to be the size of inputted text, not the input itself
    _searchHighlightInit();

    // Fit them vids!
    $('main').fitVids();
 
    // _initNav();
    // _initSearch();
    // _initLoadMore();

    // Esc handlers
    $(document).keyup(function(e) {
      if (e.keyCode === 27) {
        _closeNav();
      }
    });

    // Smoothscroll links
    $('a.smoothscroll').click(function(e) {
      e.preventDefault();
      var href = $(this).attr('href');
      _scrollBody($(href));
    });

    // Scroll down to hash afer page load
    $(window).load(function() {
      if (window.location.hash) {
        _scrollBody($(window.location.hash)); 
      }
    });

  } // end init()

  //inject user agent into data attr in html so we can grab it in css and target ie10/11
  function _ieDetect() {  //http://stackoverflow.com/a/19868056
    if( "ActiveXObject" in window ) {
      $('html').addClass('ie');
    }
  }


  //replace date with svg numbers
  function _replaceDate() {
    $('.time-big .day').each(function() {
      var numbers = $(this).text().split(''),
          replacement = '';
      replacement += '<svg class="icon-number" role="img"><use xlink:href="#icon-number-'+numbers[0]+'"></use></svg>';
      replacement += '<svg class="icon-number" role="img"><use xlink:href="#icon-number-'+numbers[1]+'"></use></svg>';
      $(this).html(replacement);
    });
  }

  //crazy hack to get the gray highlight to be the size of inputted text, not the input itself
  function _replaceSearchHighlightText() {
    window.setTimeout(function() {
      var inputSoFar = $('.search-field').val();
      if (!inputSoFar) { inputSoFar = 'Search'; }
      inputSoFar = inputSoFar.replace(/ /g, '&nbsp;'); //replace spaces so they are preserved like they will be in the textarea
      $('.search-highlight .gradient-highlight').html(inputSoFar);
    }, 0);
  }
  function _searchHighlightInit() {
    _replaceSearchHighlightText();
    $('.search-field').keydown(_replaceSearchHighlightText);
    $('.search-field').keypress(_replaceSearchHighlightText);
    $('.search-field').keyup(_replaceSearchHighlightText);
  }


  //position/resize staff modals (too hard with css)
  function _styleStaff() {

    //reposition viewport, x icon
    $('.staff .viewport').each(function() {
      var currentTop = $(this).offset().top;
      var $person = $(this).closest('.person');
      var newTop = 0;
      if(breakpoint_medium) {
        newTop = $person.offset().top + $person.height() - 144; //+102;
        $(this).offset({top: newTop, left: 0 });
        $(this).find('.icon-x').offset({ top: $person.offset().top, left: 69});
      }else{
        newTop = $person.offset().top + $person.height() - 124;
        $(this).offset({top: newTop, left: 0 });
        $(this).find('.icon-x').offset({ top: $person.offset().top, left: 10});
      }
    });

    $person = $('.person').first(); //match to size of person element (take #0, they're all the same)
    var persW = $person.width();

    //adjust size of title margin for large breakpoint
    if(screenWidth >= 850) {
      $('.modal-titles').css('max-width',persW);
      $('.staff .person-li:nth-child(2n+1) .modal-titles').css('margin-left',24+persW);
    }else{ 
      $('.modal-titles').css('max-width','');
      $('.staff .person-li:nth-child(2n+1) .modal-titles').css('margin-left','');
    }

    //adjust size of person image
    $('.staff .modal .wp-post-image').width(persW);
    // if(breakpoint_medium) {
    //   $('.staff .modal .wp-post-image').width(persW);
    // }else{ 
    //   $('.staff .modal .wp-post-image').css('width',$(window).width()-72);
    // }

      $('.staff .no-thumb').height( persW * (246/372) );

  }

  //push down recessed page content if headline-title overlaps 
  //-- wish I could think of a way to do this with css
  function _pushPageRecess() {
    var $block = $('.content-block.recess');
    var $content = $('.content-block.recess .content');
    if(breakpoint_medium) {
      var headerHeight = $('.page-header').height();
      var headlineHeight = $('.headline-title').height();
      var headlineOffset = $('.headline-title').offset().top;
      var margin = -(headerHeight-(headlineOffset+headlineHeight))+36;
      var minHeight = -margin;
      $block.css('margin-top',margin+'px');
      $content.css('min-height',minHeight+'px');
    } else {
      $block.css('margin-top','');
      $content.css('min-height','');
    }
  }


  function _scrollBody(element, duration, delay) {
    if ($('#wpadminbar').length) {
      wpOffset = $('#wpadminbar').height();
    } else {
      wpOffset = 0;
    } 
    element.velocity("scroll", {
      duration: duration,
      delay: delay,
      offset: -wpOffset
    }, "easeOutSine");
  }

  function _initSearch() {
    $('.search-toggle').on('click', function() {
      if($('.search-form').hasClass('searching')){
        $('.search-form').submit();
      }else{
        $('.search-form').addClass('searching');
        $('.headline-title').addClass('searching');
        $('.nav-forms').addClass('searching');
        $('.search-field').focus();
      }
    });
  }

  function _hideSearch() {
    $('.search-form').removeClass('active');
  }

  // // Handles main nav
  // function _initNav() {
  //   // SEO-useless nav toggler
  //   $('<div class="menu-toggle"><div class="menu-bar"><span class="sr-only">Menu</span></div></div>')
  //     .prependTo('header.banner')
  //     .on('click', function(e) {
  //       _showMobileNav();
  //     });
  //   var mobileSearch = $('.search-form').clone().addClass('mobile-search');
  //   mobileSearch.prependTo('.site-nav');
  // }

  // function _showMobileNav() {
  //   $('.menu-toggle').addClass('menu-open');
  //   $('.site-nav').addClass('active');
  // }

  // function _hideMobileNav() {
  //   $('.menu-toggle').removeClass('menu-open');
  //   $('.site-nav').removeClass('active');
  // }

  function _initLoadMore() {
    $document.on('click', '.load-more a', function(e) {
      e.preventDefault();
      var $load_more = $(this).closest('.load-more');
      var post_type = $load_more.attr('data-post-type') ? $load_more.attr('data-post-type') : 'news';
      var page = parseInt($load_more.attr('data-page-at'));
      var per_page = parseInt($load_more.attr('data-per-page'));
      var category = $load_more.attr('data-category');
      var more_container = $load_more.parents('section,main').find('.load-more-container');
      loadingTimer = setTimeout(function() { more_container.addClass('loading'); }, 500);

      $.ajax({
          url: wp_ajax_url,
          method: 'post',
          data: {
              action: 'load_more_posts',
              post_type: post_type,
              page: page+1,
              per_page: per_page,
              category: category
          },
          success: function(data) {
            var $data = $(data);
            if (loadingTimer) { clearTimeout(loadingTimer); }
            more_container.append($data).removeClass('loading');
            if (breakpoint_medium) {
              more_container.masonry('appended', $data, true);
            }
            $load_more.attr('data-page-at', page+1);

            // Hide load more if last page
            if ($load_more.attr('data-total-pages') <= page + 1) {
                $load_more.addClass('hide');
            }
          }
      });
    });
  }

  //handle sort dropdown menu in archive listing
  function _sortDropDown() {
    $('#sort-select').on('change',function() {
      window.location.href = $(this).attr('value');
    });
  }

  // Track ajax pages in Analytics
  function _trackPage() {
    if (typeof ga !== 'undefined') { ga('send', 'pageview', document.location.href); }
  }

  // Track events in Analytics
  function _trackEvent(category, action) {
    if (typeof ga !== 'undefined') { ga('send', 'event', category, action); }
  } 

  //opening/closing modals for people;
  function _openPerson($person) {
    _styleStaff();
    _closePeople();
    _preventNav();
    $person.addClass('open');
    $('html, body').animate({
        scrollTop: $person.offset().top-64
      }, 500);
  }
  function _closePeople() {
    $('.person').removeClass('open');
    _allowNav();
  }
  function _numPeople() {
    return $('.person').length;
  }
  function _advancePerson(n) {
      var i = Number($('.person.open').attr('data-person-num'));
      var tot = _numPeople();
      i = (i+n) % tot;
      var selector = '.person[data-person-num="'+i+'"]';
      var $newPerson = $(selector);
      _openPerson($newPerson);
  }

  function _staffModals() {
    $('.close-people').on('click', function () {
      _closePeople();
    });

    $('.open-person').on('click', function () {
      _closePeople();
      var $person = $(this).closest('.person');
      _openPerson($person);
    });

    $('.next-person').on('click', function () {
      _advancePerson(1);
    });
    $('.prev-person').on('click', function () {
      var tot = _numPeople();
      _advancePerson(tot-1);
    });
  }


  
  function _resizeSliders() {

  //make sure inactive slides are well hidden
    $inactive = $('.headline-slider.slider .slide-fg:not(.active)');
    $inactive.css('transition','transform 0s');
    $inactive.css('transform','translateX(-3000px)');


  //make sure that bg slider is at least tall enough to contain fg content
    //grab fg and bg sliders
    var $bgs = $('.headline-slider.slider .slide-bg');
    var $fgs = $('.headline-slider.slider .slide-fg');

    //get height of tallest slide fg (+36 pix margin at bottom)
    var tallest = 0;
    $fgs.each(function() {
      var height = $(this).height()+36;
      tallest = Math.max(tallest,height);
    });

    //don't make this shorter than designs default height
    var defaultHeight = breakpoint_medium ? 600 : 312;

    //set the minHeight
    var minHeight = Math.max(tallest,defaultHeight);
    $bgs.css('min-height',minHeight);
  }




  //Initialize Slick Sliders
  function _initSliders(){

    //little MDN doo-hicky to get parameter lists in setTimeout to work for ie9 -- fuck you ie9
    //http://stackoverflow.com/questions/12404528/ie-parameters-get-undefined-when-using-them-in-settimeout
    if (document.all && !window.setTimeout.isPolyfill) {
      var __nativeST__ = window.setTimeout;
      window.setTimeout = function (vCallback, nDelay /*, argumentToPass1, argumentToPass2, etc. */) {
        var aArgs = Array.prototype.slice.call(arguments, 2);
        return __nativeST__(vCallback instanceof Function ? function () {
          vCallback.apply(null, aArgs);
        } : vCallback, nDelay);
      };
      window.setTimeout.isPolyfill = true;
    }

    if (document.all && !window.setInterval.isPolyfill) {
      var __nativeSI__ = window.setInterval;
      window.setInterval = function (vCallback, nDelay /*, argumentToPass1, argumentToPass2, etc. */) {
        var aArgs = Array.prototype.slice.call(arguments, 2);
        return __nativeSI__(vCallback instanceof Function ? function () {
          vCallback.apply(null, aArgs);
        } : vCallback, nDelay);
      };
      window.setInterval.isPolyfill = true;
    }

    $('.headline-slider.slider').slick({
      slide: '.slide-item',
      autoplay: true,
      autoplaySpeed: 5000,
      speed: 500,
      draggable: false,
      touchMove: false,
      prevArrow: '<svg class="slider-nav-left icon-arrow-left" role="img"><use xlink:href="#icon-arrow-left"></use></svg>',
      nextArrow: '<svg class="slider-nav-right icon-arrow-right" role="img"><use xlink:href="#icon-arrow-right"></use></svg>',   
    }).on('beforeChange', function(event, slick, currentSlide, nextSlide){  //handle animations of foreground text on slide change

      //what direction are we going, prev or next?
      var last = $(this).find('.slide-fg').length - 1;
      var dir = '';
      if( currentSlide === last && nextSlide === 0) {
        dir = 'next';
      }
      if( currentSlide === 0 && nextSlide === last) {
        dir = 'prev';
      }
      if (!dir ) { //neither of the above cases
        dir = nextSlide > currentSlide ? 'next' : 'prev';
      }

      //ok so what position should the entering and exiting slides go to?
      var width = $(this).width();
      var exitPos = 0;
      if (dir === 'next') { exitPos = -width; }
      if (dir === 'prev') { exitPos = width; }
      var enterPos = -width;

      //grab our slides
      var $current = $(this).find('.slide-fg[data-slick-index="'+currentSlide+'"]');
      var $next = $(this).find('.slide-fg[data-slick-index="'+nextSlide+'"]');

      //label w/ classes
      $current.removeClass('active');
      $next.addClass('active');

      //exit current slide
      $current.css('transition','transform .5s');
      $current.css('transform','translateX('+exitPos+'px)');

      //reset next slide
      $next.css('transition','transform 0s');
      $next.css('transform','translateX(-100%)');

      //slide in next slide
      setTimeout(function($next) {
        //transition in
        $next.css('transition','transform 0.35s');
        $next.css('transform','translateX(0px)');
      }, 500, $next);
       
    }).find('.slide-fg[data-slick-index="0"]').addClass('active').css('transition','transform .35s 0.5s').css('transform','translateX(0px)'); //tell first slide to slide in





    $('.post-slider.slider').slick({
      slide: '.slide-item',
      speed: 500,
      draggable: false,
      touchMove: false,
      prevArrow: '<svg class="slider-nav-left icon-arrow-left" role="img"><use xlink:href="#icon-arrow-left"></use></svg>',
      nextArrow: '<svg class="slider-nav-right icon-arrow-right" role="img"><use xlink:href="#icon-arrow-right"></use></svg>',   
    }).on('beforeChange', function(event, slick, currentSlide, nextSlide){  //handle animations of foreground text on slide change

      //grab our slides
      var $current = $(this).find('.slide-fg[data-slick-index="'+currentSlide+'"]');
      var $next = $(this).find('.slide-fg[data-slick-index="'+nextSlide+'"]');

      //ok so what position should the entering and exiting slides go to?
      var exitPos = -$(this).width();
      var enterPos = -300; //$current.width();

      //label w/ classes
      $current.removeClass('active');
      $next.addClass('active');

      //exit current slide
      $current.css('transition','transform .5s');
      $current.css('transform','translateX('+exitPos+'px)');

      //reset next slide
      $next.css('transition','transform 0s');
      $next.css('transform','translateX('+enterPos+'px)');

      //slide in next slide
      setTimeout(function($next) {
        //transition in
        $next.css('transition','transform 0.35s');
        $next.css('transform','translateX(0px)');
      }, 500, $next);
       
    });

    $('.news .post-slider.slider').find('.slide-fg[data-slick-index="0"]').addClass('active').css('transition','transform .35s 0.8s').css('transform','translateX(0px)'); //tell first slide to slide in
    $('.radar .post-slider.slider').find('.slide-fg[data-slick-index="0"]').addClass('active').css('transition','transform .35s 1.1s').css('transform','translateX(0px)'); //tell first slide to slide in


    //make sure that bg slider is at least tall enough to contain fg content
    _resizeSliders();
  }


  // function _initFgSliders(){
  //   $('.slider').each(function() {

  //   });
  // }

  function _handleStickies() {
    var scrollTop = $(window).scrollTop();
    if(breakpoint_medium) {    
      if(scrollTop>=36) {
        $('.sticky-abs').removeClass('sticky-active');
        $('.sticky-fix').addClass('sticky-active');
      }
      if (scrollTop<36) {
        $('.sticky-fix').removeClass('sticky-active');
        $('.sticky-abs').addClass('sticky-active');
      }
    } 
  }
  //fix the center to the top of the screen after it's scrolled 36px
  function _initStickies () {

    //clone stickies
    $abs = $('.sticky');
    $abs.each(function() {
      $(this).after( $(this).clone().removeClass('sticky').addClass('sticky-fix') );
    }).removeClass('sticky').addClass('sticky-abs');

    _handleStickies();

    $( window ).scroll(_handleStickies);
    $( window ).resize(_handleStickies);
  }


  //functions to handle nav
  function _toggleNav () {
    if( $('.site-nav.active').length ) { 
      _closeNav();
    }else{
      _openNav();
    }
  }
  function _openNav () {
    if( !$('.site-nav.prevent-open').length ){
      $('.nav-toggle, .site-nav, .nav-mask, .nav-backup-bg').addClass('active');
      $('.nav-push-wrap, .site-header').addClass('pushed');
      console.log($('.nav-push-wrap, .brand, .icon-ijr'));
    }
  }
  function _closeNav () {
    $('.nav-toggle, .site-nav, .nav-mask, .nav-backup-bg').removeClass('active');
    $('.nav-push-wrap, .site-header').removeClass('pushed');
  }
  function _preventNav() {
    $('.site-nav').addClass('prevent-open');
  }
  function _allowNav() {
    $('.site-nav').removeClass('prevent-open');
  }
  function _initNav() {
    $('.nav-toggle').on('click', _toggleNav );
    $('.nav-mask').on('click', _closeNav );
  }

  //remove duotone headline on mouseover, follow link on click
  function _headlineMouseEvents() {
    $('.overflow-wrapper').mouseover(function() {
      $('.headline-duo').css('opacity',0);
        $(this).css('cursor','pointer');
    });

    $('.overflow-wrapper').mouseout(function() {
      $('.headline-duo').css('opacity',1);
    });

    $('.headline-article').on('click',function() {
      var url = $(this).attr('data-links-to');
      window.location.href = url;
    });
  }

  function _injectSvgSprite() {
    boomsvgloader.load('/app/themes/thecenter/assets/svgs/build/svgs-defs.svg'); 
  }

  // Called in quick succession as window is resized
  function _resize() {
    screenWidth = document.documentElement.clientWidth;
    breakpoint_small = (screenWidth > breakpoint_array[0]);
    breakpoint_medium = (screenWidth > breakpoint_array[1]);
    breakpoint_large = (screenWidth > breakpoint_array[2]);

    //push down recessed page content if headline-title overlaps 
    //-- wish I couls think of a way to do this with css
    _pushPageRecess();
    
    //position/resize staff modals (too hard with css)
    _styleStaff(); 

    //make sure that bg slider is at least tall enough to contain fg content
    _resizeSliders();

  }

  //Called on scroll
  //  function _scroll(dir) {
  //    var wintop = $(window).scrollTop();
  // }

  // Public functions
  return {
    init: _init,
    resize: _resize,
    scrollBody: function(section, duration, delay) {
      _scrollBody(section, duration, delay);
    }
  };

})(jQuery);

// Fire up the mothership
jQuery(document).ready(FBSage.init);

// Zig-zag the mothership
jQuery(window).resize(FBSage.resize);
