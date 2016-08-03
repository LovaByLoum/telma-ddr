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
    jQuery(".order-criteria").change(function(){
        jQuery(".recherche").val("");
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

    jQuery(".menu-item #login_user, .postule-offre > span").on("click", function(){
        jQuery("#login-user").slideToggle();

    });

    addDatePickerInClass("datepicker");
    //add experience
    jQuery( "#addExperience").click(function (){
        jQuery( ".datepicker" ).datepicker( "destroy").removeClass("hasDatepicker");
        validatorInscription.resetForm();
        addElementRepeater( "experience", "experience-number" );
        var index = jQuery("#experience-number").val();
        addRulesElementRepeater( index, "exp_prof" );
        addDatePickerInClass("datepicker");
    });

    //add formation
    jQuery( "#addFormation" ).click(function(){
        validatorInscription.resetForm();
        jQuery( ".datepicker" ).datepicker( "destroy").removeClass("hasDatepicker");
        addElementRepeater( "formation", "formation-number" );
        var index = jQuery("#formation-number").val();
        addRulesElementRepeater( index, "exp_for" );
        addDatePickerInClass("datepicker");
    });

    //add projet
    jQuery( "#addProjet" ).click(function(){
        validatorInscription.resetForm();
        jQuery( ".datepicker" ).datepicker( "destroy");
        addElementRepeater( "projet", "projet-number" );
        var index = jQuery("#projet-number").val();
        addRulesElementRepeater( index, "exp_pgt" );
        addDatePickerInClass("datepicker");
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
            required : "La fonction dans l'entreprise est requise."
            }
        },
        "entreprise_user" :{
            required : true,
            messages : {
                required : "Le nom de l'entreprise est requis."
            }
        }
    };

    var autreExperience = {
        "autre_exp" : {
            required : true,
        messages : {
            required : "Le Niveau d'étude est requis."
            }
        }
    };

    var permisCat = {
        'permCat[]' :{
            required : true
        }
    };
    var projetNew = {
        "titre_exp_pgt" : {
            required : true
        },
        "db_exp_pgt" : {
            required : true
        },
        "df_exp_pgt" : {
            required : true
        },
        "desc_exp_pgt" : {
            required : true
        },
        "organisme_exp_pgt" : {
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
    jQuery("select[name=niveau_etude]").change(function(){
        validatorInscription.resetForm();
        if ( jQuery(this).val() == "autre" ) {
            jQuery('.niveau-required').show();
            addRules( autreExperience );
        } else {
            jQuery('.niveau-required').hide();
            removeRules( autreExperience );
        }
    });

    //projets
    jQuery( "input[name=projet]" ).change(function(){
        validatorInscription.resetForm();
        if ( jQuery(this).val() == 1 ){
            jQuery( "#projet-repeat" ).show();
            jQuery( "#addProjet" ).show();
            addRules( projetNew );
        } else {
            jQuery( "#projet-repeat").hide();
            jQuery( "#addProjet").hide();
            removeRules( projetNew );
        }
    });

    //permis
    jQuery( "input[name=permis]" ).change(function(){
        validatorInscription.resetForm();
        var _this = jQuery(this);

        if(_this.val() == "1"){
            addRules( permisCat );
            jQuery( ".permis-required").show();

        } else {
            removeRules( permisCat );
            jQuery( ".permis-required").hide();
        }
    });

    var validatorInscription = jQuery( "#inscription_user").validate({
        ignore : "",
        errorElement : "span",
        errorClass : "error",
        invalidHandler:  function(e){
              setTimeout(
                function(){
                    scrollTop :jQuery('input.error,textarea.error').eq(0).parent();
                },
                500
              );
            },
        errorPlacement: function(error, element) {
            if(element.attr("name") == 'permCat[]' ) {
                error.insertAfter(jQuery(".latest"));
            } else {
                error.insertAfter(element);
            }
        },
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
            "passwrdConfirm" : {
                required : true,
                equalTo : "#passwrd"
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
                mailExistUser : true,
                email : true
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
                number : true
            },
            "titre_exp_prof" : {
                required : true
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
            "passwrdConfirm" : {
                required : "La confirmation mot de passe est requis.",
                equalTo : "Les mots de passe ne sont pas identiques."
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
                mailExistUser : "Cette adresse mail est déjà utilisée.",
                email : "L'adresse email n'est pas valide."
            },
            "niveau_etude" : {
                valueNotEquals : "Le Niveau d'étude est requis."
            },
            "date_dispo" :{
                required : "La date de disponibilité est requise."
            },
            "annee_exp" : {
                valueNotEquals : "l'année d'expérience est requis."
            },
            "num_phone" :{
                number : "La numéro de téléphone est invalide (entier uniquement)."
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
            },
            'permCat[]' : {
                required : "La catégorie du permis est requise."
            }
        }
    });

    if ( jQuery("#fm-form-1").length > 0 ){
        //remove checked radio if not checked parent
        jQuery( "input.parent").change(function(){
            var _this = jQuery(this);
            var classChild = _this.data("class");
            if ( !_this.is(":checked") ){
                jQuery('.' + classChild).removeAttr('checked');
            } else {
                jQuery('.' + classChild).eq(0).attr('checked', true);
            }
        });
        //active parent is checked box
        jQuery("input.anglais","input.francais", "input.malagasy" ).change(function(){
            var _this = jQuery(this);
            var _class = _this.attr("class");
            if ( jQuery('input[data-class =' + _class + ']').is(":checked")  ){
                //nothing
            } else {
                jQuery('input[data-class =' + _class + ']').attr("checked", true);
            }
        });
        var validatorPostule = jQuery( "#fm-form-1" ).validate({
            ignore : "",
            errorElement : "span",
            errorClass : "error",
            invalidHandler:  function(e){
              setTimeout(
                function(){
                    scrollTop :jQuery('input.error,textarea.error').eq(0).parent();
                },
                500
              );
            },
            errorPlacement: function(error, element) {
                if(element.attr("name") == "compInfo[]" ) {
                    error.insertAfter(jQuery(".latest"));
                } else if( element.attr("name") == "langue[]" ){
                    error.insertAfter(jQuery(".list-parent"));
                } else if( element.attr("name") == "file-57864af3474de" ){
                    error.insertAfter(jQuery(".cv"));
                } else if( element.attr("name") == "file-57864b273eb37" ){
                    error.insertAfter(jQuery(".lm"));
                }else if( element.attr("name") == "file-5787a3939c837" ){
                    error.insertAfter(jQuery(".autre"));
                } else {
                    error.insertAfter(element);
                }
            },
            rules : {
                "compInfo[]" : {
                    required : true
                },
                "langue[]" : {
                    required : true
                },
                "textarea-57864acd93cf8" : {
                    required : true
                },
                "file-57864af3474de" : {
                    required : true,
                    extension : "pdf|rtf|docx|doc"
                },
                "file-57864b273eb37" : {
                    required : true,
                    extension : "pdf|rtf|docx|doc"
                },
                "file-5787a3939c837" :{
                    extension : "pdf|rtf|docx|doc"
                }
            },
            messages : {
                "compInfo[]" : {
                    required : "La compétence informatique est requise."
                },
                "langue[]" : {
                    required : "La compétence linguistique est requise."
                },
                "textarea-57864acd93cf8" : {
                    required : "Le message est requis."
                },
                "file-57864af3474de" : {
                    required : "Le CV est requis.",
                    extension : "Le format n'est pas valide ( seulement pdf, rtf, docx et doc )."
                },
                "file-57864b273eb37" : {
                    required : "La lettre de motivation est requis.",
                    extension : "Le format n'est pas valide ( seulement pdf, rtf, docx et doc )."
                },
                "file-5787a3939c837" : {
                    extension : "Le format n'est pas valide ( seulement pdf, rtf, docx et doc )."
                }
            }
        });

        jQuery(".inputfile").change(showPreviewImage_click);
        jQuery(".list-children input[type=checkbox]").change(function(){
            var _checked = false;
            var _this = jQuery(this);
            var _class = _this.attr("class");
            jQuery("input." + _class). each(function (index, elt){
                if ( jQuery(elt).is(":checked") ) _checked = true;
            });
            if ( _checked ) {
                jQuery("input[data-class= " + _class + " ]"). attr( "checked", true );
            } else {
                jQuery("input[data-class= " + _class + " ]"). removeAttr( "checked");
            }

        });
    }

    if ( jQuery("#fm-form-2").length > 0 ){
        jQuery("#fm-form-2").validate({
            ignore : "",
            errorElement : "span",
            errorClass : "error",
            invalidHandler:  function(e){
              setTimeout(
                function(){
                  scrollto(jQuery('input.error,textarea.error').eq(0).parent());
                },
                500
              );
            },
            errorPlacement: function(error, element) {
                if ( element.attr("name") == "file-5791c48e104c8" ){
                    error.insertAfter(jQuery(".cv"));
                } else if( element.attr("name") == "file-5791c4b7d5a8f" ){
                    error.insertAfter(jQuery(".lm"));
                } else {
                    error.insertAfter(element);
                }
            },
            rules :{
                "text-5791c400818e9" :{
                    required : true
                },
                "text-5791c435dbe6d" : {
                    required : true
                },
                "text-5791c44862170" : {
                    required : true,
                    email : true
                },
                "text-5791c4629e06d" : {
                    number : true
                },
                "file-5791c48e104c8" : {
                    required : true,
                    extension : "pdf|rtf|docx|doc"
                },
                "file-5791c4b7d5a8f" : {
                    required : true,
                    extension : "pdf|rtf|docx|doc"
                }
            },
            messages :{
                "text-5791c400818e9" :{
                    required : "Le nom est requis."
                },
                "text-5791c435dbe6d" : {
                    required : "Le prénom est requis."
                },
                "text-5791c4629e06d" : {
                    number : "La numéro de téléphone est invalide (entier uniquement)."
                },
                "text-5791c44862170" : {
                    required : "L'adresse email est requis.",
                    email : "L'adresse email n'est pas valide."
                },
                "file-5791c48e104c8" : {
                    required : "Le CV est requis.",
                    extension : "Le format n'est pas valide ( seulement pdf, rtf, docx et doc )."
                },
                "file-5791c4b7d5a8f" : {
                    required : "La lettre de motivation est requise.",
                    extension : "Le format n'est pas valide ( seulement pdf, rtf, docx et doc )."
                }
            }
        });
        jQuery(".inputfile").change(showPreviewImage_click);
    }

    if ( jQuery("#loginform").length > 0 ){
        jQuery("#loginform").validate({
            ignore : "",
            errorElement : "p",
            errorClass : "login-username error",
            errorPlacement: function(error, element) {
                error.insertBefore(".data-error");
            },
            rules :{
                "custom_log" : {
                   required : true
                },
                "custom_pwd" : {
                    required : true
                }
            },
            messages : {
                "custom_log" : {
                   required : "L'identifiant ou adresse de messagerie est requis."
                },
                "custom_pwd" : {
                    required : "Le mot de passe est requis."
                }
            }
        });
    }

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
    jQuery( "textarea[name=" + description + "]").rules("add", {
        required : true,
        messages : {
            required : "La description est requise."
        }
    })
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
        jQuery('[name="'+item+'"]').rules('add',rulesObj[item]);
    }
}
function removeRules(rulesObj){
    for (var item in rulesObj){
       jQuery('[name="'+item+'"]').rules('remove');
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
        jQuery(this).attr("id", _name + count);
        jQuery(this).prev("label").attr("for", _name + count );
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

function addDatePickerInClass( elementClass ){
    jQuery('input.' + elementClass).datepicker({
        dateFormat : 'dd/mm/yy',
        altField : '',
        altFormat :  'dd/mm/yy',
        changeYear: true,
        yearRange: '-100:+100',
        changeMonth: true,
        showButtonPanel : true,
        firstDay: 1,
        showButtonPanel: true,
        monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
        monthNamesShort: ['Janv', 'Févr', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
        dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
        dayNamesShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
        dayNamesMin: ['Di', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
        weekHeader: 'Sem.',
        closeText: 'Fermer',
        currentText : "Ce jour"
    });
}
function showPreviewImage_click(event) {
    var files = this.files;
    var $input = jQuery(this);
    var $id = $input.attr("id");
    var i = 0,
        len = files.length;
    jQuery("label[for=" + $id + "]").html("Modifier");
    (function readFile(n) {
        var reader = new FileReader();
        var f = files[n];
        reader.onload = function (e) {
            $input.next().next().html(f.name);

            // if `n` is less than `len` ,
            // call `readFile` with incremented `n` as parameter
            if (n < len - 1) readFile(++n)
        };
        reader.readAsDataURL(f); // `f` : current `File` object
    }(i)); // `i` : `n` within immediately invoked function expression
}
