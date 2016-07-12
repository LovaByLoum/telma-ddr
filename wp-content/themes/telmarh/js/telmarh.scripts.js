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
  		  autoplaySpeed: 2000
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
    //add experience
    jQuery( "#addExperience").click(function (){
        validatorInscription.resetForm();
        addElementRepeater( "experience", "experience-number" );
        var index = jQuery("#experience-number").val();
        addRulesElementRepeater( index, "exp_prof" );
    });

    //add formation
    jQuery( "#addFormation" ).click(function(){
        addElementRepeater( "formation", "formation-number" );
        var index = jQuery("#formation-number").val();
        addRulesElementRepeater( index, "exp_for" );
    });

    //add projet
    jQuery( "#addProjet" ).click(function(){
        addElementRepeater( "projet", "projet-number" );
        var index = jQuery("#projet-number").val();
        addRulesElementRepeater( index, "exp_pgt" )
    });

    //delete experience
    jQuery('.deleteExperience').live('click', function(){
        var _this = jQuery(this);
        deleteElementRepeater( _this, "experience", "experience-number" );
    });

    //delete formation
    jQuery('.deleteFormation').live('click', function(){
        var _this = jQuery(this);
        deleteElementRepeater( _this, "formation", "formation-number" );
    });

    //delete projet
    jQuery('.deleteProjet').live('click', function(){
        var _this = jQuery(this);
        deleteElementRepeater( _this, "projet", "projet-number" );
    });

    var infosEnPoste = {
        "fonction_user" : {
            required : true,
        messages : {
            required : "La fonction est requise."
            }
        }
    };

    var autreExperience = {
        "autre_exp" : {
            required : true,
        messages : {
            required : "L'autre année d'expérience est requis."
            }
        }
    };

    var permisCat = {
        "permis_cat" :{
            required : true,
            messages : {
                required : "La catégorie du permis est requise."
            }
        }
    };
    var projet = {
        "titre_exp_pgt" : {
            required : true
        },
        "db_exp_pgt" : {
            required : true
        },
        "df_exp_pgt" : {
            required : true
        },
        "organisme_exp_pgt" : {
            required : true
        },
        "desc_exp_pgt" : {
            required : true
        }
    };


    //Enposte
    jQuery( "input[name=en_poste]" ).change(function(){
        validatorInscription.resetForm();
        var _this = jQuery(this);
        if(_this.val() == 1){
            jQuery( ".post-required").show();
            addRules( infosEnPoste );
        } else {
            jQuery( ".post-required").hide();
            removeRules( infosEnPoste );
        }
    });

    //années d'experience
    jQuery("select[name=annee_exp]").change(function(){
        validatorInscription.resetForm();
        if ( jQuery(this).val() == "autre" ) {
            jQuery('.experience-required').show();
            addRules( autreExperience );
        } else {
            jQuery('.experience-required').hide();
            removeRules( autreExperience );
        }
    });

    //projets
    jQuery( "input[name=projet]" ).change(function(){
        validatorInscription.resetForm();
        if ( jQuery(this).val() == 1 ){
            jQuery( "#projet-repeat" ).show();
            jQuery( "#addProjet" ).show();
            addRules( projet );
        } else {
            jQuery( "#projet-repeat").hide();
            jQuery( "#addProjet").hide();
            removeRules( projet );
        }
    });

    //permis
    jQuery( "input[name=permis]" ).change(function(){
        validatorInscription.resetForm();
        var _this = jQuery(this);
        if(_this.val() == 1){
            jQuery( ".permis-required").show();
            addRules( permisCat );
        } else {
            jQuery( ".permis-required").hide();
            removeRules( permisCat );
        }
    });

    var validatorInscription = jQuery( "#inscription_user").validate({
        ignore : "",
        errorElement : "span",
        errorClass : "error",
        rules :{
            "login" : {
                required : true,
                minlength : 4,
                loginExist : true
            },
            "passwrd" : {
                required : true,
                minlength : 5
            },
            "nom" : {
                required : true,
                minlength : 3
            },
            "prenom" : {
                required : true
            },
            "birthday" : {
                required : true
            },
            "adresse" :{
                required : true
            },
            "email" : {
                required : true,
                mailExistUser : true
            },
            "niveau_etude" : {
                valueNotEquals : "0"
            },
            "date_dispo" :{
                required : true
            },
            "annee_exp" : {
                valueNotEquals : "0"
            },
            "num_phone" :{
                required : true
            },
            "titre_exp_prof" : {
                required : true,
                minlenght: 3
            },
            "db_exp_prof" : {
                required : true
            },
            "df_exp_prof" : {
                required : true
            },
            "organisme_exp_prof" : {
                required : true
            },
            "desc_exp_prof" : {
                required : true
            },
            "titre_exp_for" : {
                required : true
            },
            "db_exp_for" : {
                required : true
            },
            "df_exp_for" : {
                required : true
            },
            "organisme_exp_for" : {
                required : true
            },
            "desc_exp_for" : {
                required : true
            }
        },
        messages : {
            "login" : {
                required : "Le login est requis.",
                minlength : "Le login est trop court.",
                loginExist : "Ce login existe deja."
            },
            "passwrd" : {
                required : "Le mot de passe est requis.",
                minlength : "Le mot de passe est trop court."
            },
            "nom" : {
                required : "Le nom est requis.",
                minlength : "Le nom est trop court."
            },
            "prenom" : {
                required : "Le prénom est requis"
            },
            "birthday" : {
                required : "La date de naissance est requise."
            },
            "adresse" :{
                required : "L'adresse est requis."
            },
            "email" : {
                required : "L'adresse email est requis.",
                mailExistUser : "Cet email a est déjà utiliser."
            },
            "niveau_etude" : {
                valueNotEquals : "Le niveau d'etude est requis."
            },
            "date_dispo" :{
                required : "La date de disponibilité est requise."
            },
            "annee_exp" : {
                valueNotEquals : "l'année d'expérience est requis."
            },
            "num_phone" :{
                required : "La numéro de téléphone est requise."
            },
            "titre_exp_prof" : {
                required : "Le titre est requis."
            },
            "db_exp_prof" : {
                required : "La date de début est requise."
            },
            "df_exp_prof" : {
                required : "La date de fin est requise."
            },
            "organisme_exp_prof" : {
                required : "L'organisme / Entreprise est requis."
            },
            "desc_exp_prof" : {
                required : "La description est requise."
            },
            "titre_exp_for" : {
                required : "Le titre est requis."
            },
            "db_exp_for" : {
                required : "La date de début est requis."
            },
            "df_exp_for" : {
                required : "La date de fin est requis."
            },
            "organisme_exp_for" : {
                required : "Organisme / Entreprise est requis."
            },
            "desc_exp_for" : {
                required : "La description est requise."
            },
            "titre_exp_pgt" : {
                required : "Le titre est requis."
            },
            "db_exp_pgt" : {
                required : "La date de début est requis."
            },
            "df_exp_pgt" : {
                required : "La date de fin est requis."
            },
            "organisme_exp_pgt" : {
                required : "L'organisme / Entreprise est requis."
            },
            "desc_exp_pgt" : {
                required : "La description est requise."
            }
        }
    });

});

jQuery.validator.addMethod("mailExistUser", function( value, element, arg ){
    var isSuccess = false;
    jQuery.ajax({
        type    : "POST",
        url     : ajaxurl,
        async   : false,
        data    : {
           action      : "telmarh_check_email_exist",
           data_type   : value
       },
       success : function(response){
           isSuccess = response ? true : false
       }
    });
    return isSuccess;
}, "L'email exist dejà.");

jQuery.validator.addMethod( "loginExist", function( value, element, arg ){
    var isSuccess = false;
    jQuery.ajax({
        type : "post",
        url : ajaxurl,
        async   : false,
        data : {
            action : "telmarh_check_login_exist",
            data_type : value
        },
        success : function ( response ){
            isSuccess = response ? true : false
        }
    });
    return isSuccess;
});

jQuery.validator.addMethod("valueNotEquals", function(value, element, arg){
 return arg != value;
}, "Value must not equal arg.");

function addRulesElementRepeater( index, namePrefix ){
    var titre = "titre_" + namePrefix + index;
    var dateDebut = "db_" + namePrefix + index;
    var dateFin = "df_" + namePrefix + index
    var orgnisme = "organisme_" + namePrefix + index;
    var description = "desc_" + namePrefix + index;
    jQuery( "input[name= " + titre + "]" ).rules("add", {
            required : true,
            minlength : 3,
            messages : {
                required : "Le titre est requis.",
                minlength : "La titre est trop court."
            }
        }
    );
    jQuery( "input[name= " + dateDebut + "]" ).rules("add", {
            required : true,
            messages : {
                required : "La date de début est requis."
            }
        }
    );
    jQuery( "input[name= " + orgnisme + "]" ).rules("add", {
            required : true,
            messages : {
                required : "Organisme / Entreprise est requis."
            }
        }
    );
    jQuery( "input[name= " + dateFin + "]" ).rules("add", {
            required : true,
            messages : {
                required : "La date de fin est requis."
            }
        }
    );
    jQuery( "textarea[name= " + description + "]" ).rules("add", {
            required : true,
            messages : "La description est requise."
        }
    );
}

function addRules(rulesObj){
    for (var item in rulesObj){
        jQuery('input[name='+item+']').rules('add',rulesObj[item]);
    }
}
function removeRules(rulesObj){
    for (var item in rulesObj){
       jQuery('input[name='+item+']').rules('remove');
    }
}

function setCollabsBlockTo(element, count, removevalue){
    element.find('.col-1-1.number h5 > span').html(count+1);
    //name
    element.find('[name]').each(function(){
        _name = jQuery(this).attr('name').match(/[a-zA-Z_-]+/);
        if (removevalue){
            jQuery(this).val('');
        }
        jQuery(this).attr('name', _name + count);
    })
    return element;
}

function addElementRepeater( classContainer, idNumberElement ){
    var _clone = jQuery('.' + classContainer).last().clone();
    var _count = jQuery('.' + classContainer).length;
    _clone.removeClass("sample");
    _clone = setCollabsBlockTo( _clone, _count, true );
    _clone.insertAfter( jQuery('.' + classContainer).last() );
    _number = jQuery('.' + classContainer).length-1;
    jQuery( "#" + idNumberElement ).val(_number);
}

function deleteElementRepeater( element, classContainer, idNumberElement ){
    if ( jQuery('.' + classContainer).length > 1 ){
        element.parents('.' + classContainer).remove();
                //refresh
        jQuery('.' + classContainer).each(function(index){
            setCollabsBlockTo(element, index, false);
        })
        _number = jQuery('.' + classContainer).length-1;
        jQuery( "#" + idNumberElement ).val(_number);
    }
}
