(function ($)
  { "use strict"
  
    
/* 1. Proloder */
    $(window).on('load', function () {
      $('#preloader-active').delay(450).fadeOut('slow');
      $('body').delay(450).css({
        'overflow': 'visible'
      });
    });


/* 2. sticky And Scroll UP */
    $(window).on('scroll', function () {
      var scroll = $(window).scrollTop();
      if (scroll < 400) {
        $(".header-sticky").removeClass("sticky-bar");
        $('#back-top').fadeOut(500);
      } else {
        $(".header-sticky").addClass("sticky-bar");
        $('#back-top').fadeIn(500);
      }
    });

  // Scroll Up
    $('#back-top a').on("click", function () {
      $('body,html').animate({
        scrollTop: 0
      }, 800);
      return false;
    });
  

/* 3. slick Nav */
// mobile_menu
    var menu = $('ul#navigation');
    if(menu.length){
      menu.slicknav({
        prependTo: ".mobile_menu",
        closedSymbol: '+',
        openedSymbol:'-'
      });
    };

/* 4. MainSlider-1 */
    // h1-hero-active
    function mainSlider() {
      var BasicSlider = $('.slider-active');
      BasicSlider.on('init', function (e, slick) {
        var $firstAnimatingElements = $('.single-slider:first-child').find('[data-animation]');
        doAnimations($firstAnimatingElements);
      });
      BasicSlider.on('beforeChange', function (e, slick, currentSlide, nextSlide) {
        var $animatingElements = $('.single-slider[data-slick-index="' + nextSlide + '"]').find('[data-animation]');
        doAnimations($animatingElements);
      });
      BasicSlider.slick({
        autoplay: false,
        autoplaySpeed: 4000,
        dots: false,
        fade: true,
        arrows: false, 
        prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-angle-left"></i></button>',
        nextArrow: '<button type="button" class="slick-next"><i class="fas fa-angle-right"></i></button>',
        responsive: [{
            breakpoint: 1024,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
              infinite: true,
            }
          },
          {
            breakpoint: 991,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
              arrows: false
            }
          },
          {
            breakpoint: 767,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
              arrows: false
            }
          }
        ]
      });

      function doAnimations(elements) {
        var animationEndEvents = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
        elements.each(function () {
          var $this = $(this);
          var $animationDelay = $this.data('delay');
          var $animationType = 'animated ' + $this.data('animation');
          $this.css({
            'animation-delay': $animationDelay,
            '-webkit-animation-delay': $animationDelay
          });
          $this.addClass($animationType).one(animationEndEvents, function () {
            $this.removeClass($animationType);
          });
        });
      }
    }
    mainSlider();
 
 
/* 5. Testimonial Active*/
  var testimonial = $('.h1-testimonial-active');
  if(testimonial.length){
  testimonial.slick({
      dots: false,
      infinite: true,
      speed: 1000,
      autoplay:false,
      arrows: true,
      prevArrow: '<button type="button" class="slick-prev"><i class="ti-angle-left"></i></button>',
      nextArrow: '<button type="button" class="slick-next"><i class="ti-angle-right"></i></button>',
      slidesToShow: 1,
      slidesToScroll: 1,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: true,
            dots: false,
            arrows:true
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            dots: false,
            arrows:false
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            dots: false,
            arrows:false
          }
        }
      ]
    });
  }

  // Agent-active-active
  $('.clients-speech-active').slick({
    dots: true,
    infinite: true,
    speed: 300,
    arrows: true,
    prevArrow: '<button type="button" class="slick-prev"><i class="ti-angle-left"></i></button>',
    nextArrow: '<button type="button" class="slick-next"><i class="ti-angle-right"></i></button>',
    slidesToShow: 1,
    slidesToScroll: 1,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          infinite: true,
          dots: true
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          dots: false
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          dots: false
        }
      }
    ]
  });
  
/* 5. instagram Active */
    var client_list = $('.instagram-active');
    if(client_list.length){
      client_list.owlCarousel({
        slidesToShow: 4,
        slidesToScroll: 1,
        loop: true,
        autoplay:true,
        speed: 3000,
        smartSpeed:2000,
        nav: false,
        dots: false,
        margin: 0,

        autoplayHoverPause: true,
        responsive : {
          1200 : {
            nav: false,
            items: 4,
          },
          992 : {
            nav: false,
            items: 3,
          },
          768 : {
            nav: false,
            items: 4,
          },
          576: {
            nav: false,
            items: 2,
          },
          0 : {
            nav: false,
            items: 1,
          }
        }
      });
    }



/* 6. Nice Selectorp  */
  var nice_Select = $('select');
    if(nice_Select.length){
      nice_Select.niceSelect();
    }

/* 7. data-background */
    $("[data-background]").each(function () {
      $(this).css("background-image", "url(" + $(this).attr("data-background") + ")")
      });


/* 10. WOW active */
    new WOW().init();

// 11. ---- Mailchimp js --------//  
    function mailChimp() {
      $('#mc_embed_signup').find('form').ajaxChimp();
    }
    mailChimp();


// 12 Pop Up Img
    var popUp = $('.single_gallery_part, .img-pop-up');
      if(popUp.length){
        popUp.magnificPopup({
          type: 'image',
          gallery:{
            enabled:true
          }
        });
      }

    
// 12 Pop Up Video
    var popUp = $('.popup-video');
    if(popUp.length){
      popUp.magnificPopup({
        type: 'iframe'
      });
    }

/* 13. counterUp*/
    $('.counter').counterUp({
      delay: 10,
      time: 3000
    });
    
    // off-canvas menu body open and close
    $(document).ready(function(){
        // add class
        $('.menu-bar').click(function(){
          $('.menu-body').toggleClass('menu-open');
        })
        // Remove class
        $('.close-icon-menu').click(function(){
          $('.menu-body').removeClass('menu-open');
        })

      // when body click then working close menu
        $(document).click(function(event){
          if (!$(event.target).closest(".menu-body, .menu-bar").length) {
            $("body").find(".menu-body").removeClass("menu-open");
          }
        });

        //off -canvas menu item click
        $('.click-menu ul').hide();
        $(".click-menu a").click(function () {
          $(this).parent(".click-menu").children("ul").slideToggle("100");
          $(this).find(".right").toggleClass("ti-plus ti-minus");
        });
    });





})(jQuery);
