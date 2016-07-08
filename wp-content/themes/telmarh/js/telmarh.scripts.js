jQuery( function( $ ){
 
$(document).ready(function() {
	$('.client-carousel').slick({
		  dots: false,
		  infinite: true,
		  speed: 300,
		  slidesToShow: 4,
		  centerMode: false,
		  variableWidth: true,
		  autoplay: true,
  		  autoplaySpeed: 2000,
		});
	});	
	
});

jQuery( function( $ ){

	$(document).ready(function() {
		$('.fade').hover(
			function(){
				$(this).find('.caption').fadeIn(350);
			},
			function(){
				$(this).find('.caption').fadeOut(350);
			}
		);
	});
	
});

jQuery( function( $ ){
	
	$(document).ready(function() {
		$('.toggle-menu').jPushMenu();
	});

    //accordion
    if (jQuery('.content-accordion').length > 0) {
        jQuery('.widget-area .widget').each ( function (index) {
            jQuery('.head-accordion', this).click (function() {
                jQuery(this).toggleClass ('open');
                jQuery('.content-accordion', jQuery('.widget-area .widget').eq(index) ).slideToggle ('900');
    			return false;
    		});
    	});
    }
    jQuery(".entreprise, .localisation, .annee-experience, .type-contrat, .criticite, .departement").change(function(){
        _this = jQuery(this);
        if ( _this.is(":checked") ){
            _this.parent("label").addClass("checked");
        } else {
            _this.parent("label").removeClass("checked");
        }
        if ( jQuery( window ).width() < 867 ){
            jQuery("html, body").animate({
                scrollTop : jQuery( "#pl-64").offset().top
            }, 1000);
        } else {
            jQuery("html, body").animate({
                scrollTop : jQuery( "#content").offset().top
            }, 1000);
        }
    });

    jQuery(".pagination-button-offre_pagination_box").live( 'click',function(){
        if ( jQuery( window ).width() < 867 ){
            jQuery("html, body").animate({
                scrollTop : jQuery( "#pl-64").offset().top
            }, 1000);
        } else {
            jQuery("html, body").animate({
                scrollTop : jQuery( "#content").offset().top
            }, 1000);
        }
    });

    if (  jQuery('.slick-track').length > 0 ){
        jQuery('.slick-track').slick({
          dots: true,
          autoplay: true,
          infinite: true,
          speed: 300,
          slidesToShow: 4,
          slidesToScroll: 1,
          responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: true
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
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
          ]
        });
    }

    jQuery(window).on('resize', function(){
          var win = jQuery(this); //this = window
          if (win.height() < 867) {
              jQuery(".page-template-offres .listing-offer .grid .col-3-12").insertBefore(".page-template-offres .listing-offer .grid .col-9-12");
          }
          if (win.width() >= 867) {
              jQuery(".page-template-offres .listing-offer .grid .col-9-12").insertBefore(".page-template-offres .listing-offer .grid .col-3-12");
          }
    });

    if ( jQuery(window).width() < 867 ) {
        jQuery(".page-template-offres .listing-offer .grid .col-3-12").insertBefore(".page-template-offres .listing-offer .grid .col-9-12");
    }

    jQuery(".menu-item #login_user").on("click", function(){
        jQuery("#login-user").slideToggle();

    });

    jQuery('input.datepicker').datepicker({
        dateFormat : 'dd/mm/yy',
        altField : '',
        altFormat :  'dd/mm/yy',
        changeYear: true,
        yearRange: '-100:+100',
        changeMonth: true,
        showButtonPanel : true,
        firstDay: 1,
        showButtonPanel: true,
        closeText: 'Fermer'
    });


});
