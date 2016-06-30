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
jQuery(".entreprise, .localisation, .annee-experience, .type-contrat, .criticite").change(function(){
    _this = jQuery(this);
    if ( _this.is(":checked") ){
        _this.parent("label").addClass("checked");
    } else {
        _this.parent("label").removeClass("checked");
    }
})

 
