
jQuery(document).ready(function () {

    //add bloc etape
	jQuery('.wrapper-etape-workflow .ajout_etape').click(function(){

		_etape_wrapper = jQuery('.wrapper-etape');
		_clone_etape = _etape_wrapper.find('.bloc_etape.item.clone');
		_etape_number_field = _etape_wrapper.find('.bloc_etape_number');
		_etape_number = _etape_number_field.val();
		_etape_number++;
		_the_clone = _clone_etape.clone();
		_the_clone.removeClass('clone');
		_etape_wrapper.append(_the_clone);

        refreshNameAllEtapes();

		_etape_number_field.val(_etape_number);

	})

    //remove bloc etape
    jQuery('.wrapper-etape-workflow').on('click', 'button.remove-bloc', function() {
        var number = jQuery(".bloc_etape").has(":not(.clone)").length;
        jQuery( '.bloc_etape_number' ).val(number-1);
        jQuery(this).parent().css('display', 'block');
        jQuery(this).parent().remove();

        refreshNameAllEtapes();
    });

    //add bloc role
	jQuery('.wrapper-etape-workflow').on('click', '.ajout_role', function(){
		_parent_bloc_etape = jQuery(this).parents('.bloc_etape');
		_parent_wrapper = jQuery(this).parents('.roles-fields-wrapper');
		_role_wrapper = jQuery('.roles-wrapper', _parent_wrapper);
		_clone_role = _role_wrapper.find('.bloc_role.item.clone');
		_role_number_field = _role_wrapper.find('.bloc_role_number');
		_role_number = _role_number_field.val();
		_role_number++;
		_the_clone = _clone_role.clone();
		_the_clone.removeClass('clone');
		_role_wrapper.append(_the_clone);
		_role_number_field.val(_role_number);

        refreshNameAllEtapes();
	});

    //delete bloc role
    jQuery('.wrapper-etape-workflow').on('click', 'button.remove-bloc-role', function() {
        var _parent = jQuery(this).closest('.bloc_etape');
        var number = _parent.find('.bloc_role_number').val();
        _parent.find('.bloc_role_number').val(number-1);
        jQuery(this).parent().css('display', 'block');
        jQuery(this).parent().remove();

        refreshNameAllEtapes();
    });

    /**
     * function pour effacer l'etape et mettre à jour les index des attribut name du formulaire
     */
    function refreshNameAllEtapes(){
	    var _thisElment = jQuery(".bloc_etape");
	    _thisElment.each( function ( index ) {
	        if ( !jQuery(this).hasClass( 'clone' ) ) {
                var selectEtat = jQuery(this).find('select.etat');
                var selectEtape = jQuery(this).find('select.etape');
                selectEtat.attr('name', 'workflow[etat][' + index +']' );
                selectEtape.attr('name', 'workflow[etape][' + index +']' );
                if ( jQuery(this).find('.bloc_role').length > 0 ){
                    jQuery(this).find('.bloc_role').each( function(i){
                       if ( !jQuery(this).hasClass( 'clone' ) ){
                           var selectRoleEtat = jQuery(this).find('select.role');
                           var selectRoleType = jQuery(this).find('select.type');
                           var selectRoleActions = jQuery(this).find('select.actions');
                           selectRoleEtat.attr('name', 'workflow[roles]['+ index + '][role]['+ i +']');
                           selectRoleType.attr('name', 'workflow[roles]['+ index + '][type]['+ i +']');
                           selectRoleActions.attr('name', 'workflow[roles]['+ index + '][actions]['+ i +'][]');
                       }
                    });
                }
            }

        } )
    }

});


