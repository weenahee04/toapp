$(window).on("load scroll",function(e){   
    var scroll = $(window).scrollTop();
  
    if (scroll >= 100) {  
        $("body").addClass("scrolling"); 
    } else {
        $("body").removeClass("scrolling");
    } 
});
 
$(document).ready(function(){   
    $("a.target").on('click', function(event) {
        event.preventDefault();
        var hash = this.hash; 

        $('html, body').animate({
            scrollTop: $(hash).offset().top  
            }, 800, function(){ 
        });
    }); 
  
    AOS.init({
        duration: 1200,
       // offset:0,
        once: true
    });

    // Toggle Box

    $(".btn-expand").on("click",function(){
        var $this = $(this);
        $this.parent().next().slideToggle();
        $this.toggleClass("show"); 
    });
 

    $(".title-expand").on("click",function(){
        var $this = $(this);
        $this.parent().find(".collapse").slideToggle();
        $this.toggleClass("show"); 
    });

    /*------------[Start] form-effect ------------*/
 
    $('.form .form-control, .form .form-select').each(function(index){
       
        if($(this).val().length != 0){ 
         $(this).parents(".form-group").addClass("has-value");
        }
     });
  
      
     $(".form-select:not(.custom)").each(function (i) {
         var $dropdownList = $(this).find(".dropdown-menu").find("li");
         $dropdownList.on('click', function() {
             var dropdownListValue = $(this).html(); 
             $dropdownList.parents(".form-select").find('[data-bs-toggle]').html(dropdownListValue).addClass("selected");
 
             $dropdownList.removeClass("active");
             $(this).addClass("active");
         }); 
     });
     
    $('select').on('change', function() {
        if (this.value) {
            $(this).addClass("selected");
        } else {
            $(this).removeClass("selected");
        }
    }).change();
  
});
 
$(window).on("load", function() {
  
  $(".preload, .preloader").delay(150).fadeOut(250, function() {
    $(this).css({
      display: "none",
      visibility: "hidden",
      pointerEvents: "none"
    });
  });

  setTimeout(function () {
     $("html").addClass("page-loaded");
  }, 200);
 
  $('img.svg-js').each(function() {
      var $img = jQuery(this);
      var imgURL = $img.attr('src');
      var attributes = $img.prop("attributes");

      $.get(imgURL, function(data) {
          // Get the SVG tag, ignore the rest
          var $svg = jQuery(data).find('svg');

          // Remove any invalid XML tags
          $svg = $svg.removeAttr('xmlns:a');

          // Loop through IMG attributes and apply on SVG
          $.each(attributes, function() {
              $svg.attr(this.name, this.value);
          });

          // Replace IMG with SVG
          $img.replaceWith($svg);
      }, 'xml');
  });
});

$(function() {
  setTimeout(function() {
    $(".preload, .preloader").fadeOut(200, function() {
      $(this).css({
        display: "none",
        visibility: "hidden",
        pointerEvents: "none"
      });
    });
  }, 1200);
});
