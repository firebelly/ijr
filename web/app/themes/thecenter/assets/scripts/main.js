// FBSage - Firebelly 2015
/*jshint latedef:false*/

// Good Design for Good Reason for Good Namespace
var FBSage = (function($) {

  var screen_width = 0,
      breakpoint_small = false,
      breakpoint_medium = false,
      breakpoint_large = false,
      breakpoint_array = [750,750,1200],
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

    // Set screen size vars
    _resize();

    //initialize sliders
    _initSliders();

    //allow nav to push in on click of .nav-toggle
    _navToggle();

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

    // Fit them vids!
    $('main').fitVids();
 
    // _initNav();
    // _initSearch();
    // _initLoadMore();

    // Esc handlers
    $(document).keyup(function(e) {
      if (e.keyCode === 27) {
        _hideSearch();
        _hideMobileNav();
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

  //position/resize staff modals (too hard with css)
  function _styleStaff() {
    $('.staff .viewport').each(function() {
      var currentTop = $(this).offset().top;
      var $person = $(this).closest('.person');
      var newTop = 0;

      if($(window).width() >= breakpoint_array[1]) {
        newTop = $person.offset().top + $person.height() - 144;
        $(this).offset({top: newTop, left: 0 });
        $(this).find('.icon-x').offset({ top: $person.offset().top, left: 69});
      }else{
        newTop = $person.offset().top + $person.height() - 124;
        $(this).offset({top: newTop, left: 0 });
        $(this).find('.icon-x').offset({ top: $person.offset().top, left: 10});
      }
    });

    
    if($(window).width() >= breakpoint_array[1]) {
      $person = $('.person').first(); //match to size of person element (take #0, they're all the same)
      var persW = $person.width();
      $('.staff .modal .wp-post-image').width(persW);
      $('.modal-titles').css('max-width',persW);
      $('.staff li:nth-child(2n+1) .modal-titles').css('margin-left',24+persW);
    }else{ 
      $('.staff .modal .wp-post-image').css('width',$(window).width()-72);
      $('.modal-titles').css('max-width','');
      $('.staff li:nth-child(2n+1) .modal-titles').css('margin-left','');

    }

  }

  //push down recessed page content if headline-title overlaps 
  //-- wish I could think of a way to do this with css
  function _pushPageRecess() {
    if($(window).width() >= breakpoint_array[1]) {
      var headerHeight = $('.page-header').height();
      var headlineHeight = $('.headline-title').height();
      var headlineOffset = $('.headline-title').offset().top;
      var margin = -(headerHeight-(headlineOffset+headlineHeight))+36;
      $('.content-block.recess').css('margin-top',margin+'px');
    } else {
      $('.content-block.recess').css('margin-top','');
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
        console.log('submit!');
        $('.search-form').submit();
      }else{
        $('.search-form').addClass('searching');
        $('.headline-title').addClass('searching');
        $('.search-field').focus();
      }
    });
  }

  function _hideSearch() {
    $('.search-form').removeClass('active');
  }

  // Handles main nav
  function _initNav() {
    // SEO-useless nav toggler
    $('<div class="menu-toggle"><div class="menu-bar"><span class="sr-only">Menu</span></div></div>')
      .prependTo('header.banner')
      .on('click', function(e) {
        _showMobileNav();
      });
    var mobileSearch = $('.search-form').clone().addClass('mobile-search');
    mobileSearch.prependTo('.site-nav');
  }

  function _showMobileNav() {
    $('.menu-toggle').addClass('menu-open');
    $('.site-nav').addClass('active');
  }

  function _hideMobileNav() {
    $('.menu-toggle').removeClass('menu-open');
    $('.site-nav').removeClass('active');
  }

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
    $person.addClass('open');
    $('html, body').animate({
        scrollTop: $person.offset().top-64
      }, 500);
  }
  function _closePeople() {
    $('.person').removeClass('open');
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


  //Initialize Slick Sliders
  function _initSliders(){
    $('.headline-slider.slider').slick({
      slide: '.slide-item',
      autoplay: true,
      autoplaySpeed: 6000,
      speed: 1200,
      pauseOnHover: true,
      prevArrow: '<svg class="slider-nav-left icon-arrow-left" role="img"><use xlink:href="#icon-arrow-left"></use></svg>',
      nextArrow: '<svg class="slider-nav-right icon-arrow-right" role="img"><use xlink:href="#icon-arrow-right"></use></svg>',   
    });

    $('.post-slider.slider').slick({
      slide: '.slide-item',
      speed: 1200,
      prevArrow: '<svg class="slider-nav-left icon-arrow-left" role="img"><use xlink:href="#icon-arrow-left"></use></svg>',
      nextArrow: '<svg class="slider-nav-right icon-arrow-right" role="img"><use xlink:href="#icon-arrow-right"></use></svg>',   
    });



    //things got complicated with animations/overlays, needed to make each slide multiple, seperate divs
    //when slick makes a slide active, we want to throw a .active class on every div that's associated associated (via data-slick-index)
    //start with first one
    $('.slider').find('.slide-fg[data-slick-index="0"]').addClass('active');
    //revise on slide change...
    $('.slider').on('beforeChange', function(event, slick, currentSlide, nextSlide){
      $(this).find('.slide-fg').removeClass('active');
      $(this).find('.slide-fg[data-slick-index="'+nextSlide+'"]').addClass('active');
    }); 
  }

  function _navToggle() {
    $('.nav-toggle').on('click', function () {
        $('.nav-toggle').toggleClass('active');
        $('.nav-push-wrap').toggleClass('pushed');
        $('.site-nav').toggleClass('active');
    });
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
    console.log('boom!');
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

  }

  // Called on scroll
  // function _scroll(dir) {
  //   var wintop = $(window).scrollTop();
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
