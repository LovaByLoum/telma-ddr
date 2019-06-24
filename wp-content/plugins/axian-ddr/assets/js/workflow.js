jQuery(document).ready(function () {

	// tester si au moins un div est affiché

	
	// cloner une étape
	jQuery('#ajout_etape').on('click', function () {
		// jQuery('div#bloc-etape').show();
		jQuery('div#bloc-etape').clone().appendTo("div#principale");
		var numItems = $('.clone_etapes').length;
				
	});

	// cloner les rôles

	jQuery('#ajout_role').on('click', function () {
		jQuery('div#bloc-roles').clone().appendTo('div#bloc-roles')
	});

	// masquer le bouton ajouter actions

	jQuery('#ajout_action').hide();

	// afficher le bloc rôle
	jQuery('#ajout_role').on('click', function(){
	});

	// afficher le bloc action

	jQuery('#ajout_action').on('click', function(){
		jQuery('.clone_actions').removeClass('hidden');
	});

	//active les selects dans les blocs

	jQuery("#chosen-select").chosen();

	// Ajax pour l'envoi post du formulaire
	jQuery.post(
		ajaxurl,
		{
			'action': 'mon_action',
			'param' : 'coucou'
		},
		function(response) {
			console.log(response);
		}
	);

	// fermer un bloc

	jQuery('.close-bloc').on('click', function(c){
		jQuery(this).parent().fadeOut('slow', function(c){
		});
	});	


	

});


