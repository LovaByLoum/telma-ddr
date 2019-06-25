jQuery(document).ready(function () {

	jQuery('.wrapper-etape-workflow .ajout_etape').click(function(){
		_etape_wrapper = jQuery('.wrapper-etape');
		_clone_etape = _etape_wrapper.find('.bloc_etape.item.clone');
		_etape_number_field = _etape_wrapper.find('.bloc_etape_number');
		_etape_number = _etape_number_field.val();
		_etape_number++;
		_the_clone = _clone_etape.clone();
		_the_clone.find('[name]').each(function(){
			var _name = jQuery(this).attr('name');
			_name = _name.replace('_row_index_etape', _etape_number);
			jQuery(this).attr('name', _name);
		});
		_the_clone.removeClass('clone');
		_etape_wrapper.append(_the_clone);
		_etape_number_field.val(_etape_number);
	})
	
	jQuery('.wrapper-etape-workflow').on('click', '.ajout_role', function(){
		_parent_wrapper = jQuery(this).parents('.roles-fields-wrapper');
		_role_wrapper = jQuery('.roles-wrapper', _parent_wrapper);
		_clone_role = _role_wrapper.find('.bloc_role.item.clone');
		_role_number_field = _role_wrapper.find('.bloc_role_number');
		_role_number = _role_number_field.val();
		_role_number++;
		_the_clone = _clone_role.clone();
		_the_clone.find('[name]').each(function(){
			var _name = jQuery(this).attr('name');
			_name = _name.replace('_row_index_role', _role_number);
			jQuery(this).attr('name', _name);
		});
		_the_clone.removeClass('clone');
		_role_wrapper.append(_the_clone);
		_role_number_field.val(_role_number);
	})

	// masquer le bouton ajouter actions

	/*jQuery('#ajout_action').hide();

	// afficher le bloc rôle
	jQuery('#ajout_role').on('click', function(){
	});

	// afficher le bloc action

	jQuery('#ajout_action').on('click', function(){
		jQuery('.clone_actions').removeClass('hidden');
	});

	
	//fonction cloner et remove
	var regex = /^(.+?)(\d+)$/i;
	var cloneIndex = jQuery('.bloc_etape').length;
	//var cloneIndexRole = jQuery('.bloc-roles').length;

	function clone() {
		jQuery('div#bloc_etape').clone()
		.appendTo('.bloc_etape')
		.attr('id', 'bloc_etape' + "["+ cloneIndex + "]")
		.each(function () {
			var id = this.id || "";
			var match = id.match(regex) || []; 
			if (match.length == 3) {
				this.id = match[1] + (cloneIndex);
			}
		})
		.on('click', 'button#ajout_etape', clone)
		.on('click', '.close-bloc', remove);
	}

	function remove() {
		jQuery(this).parents('.bloc_etape').remove();
	}

	jQuery('button#ajout_etape').on('click', clone);
	jQuery('.close-bloc').on('click', remove);
	

	// cloner les rôles

		function cloneRole() {
		jQuery('div#bloc-roles').clone()
		.appendTo('div#bloc-roles')
		.attr('id', 'bloc-roles', +'['+ cloneIndexRole + ']')
		.each(function () {
			var id = this.id || "";
			var match = id.match(regex) || [];
			if (match.length == 3) {
				this.id = match[1] + (cloneIndexRole);
			}
		})
		.on('click', 'button#ajout_role', cloneRole);
	}

	jQuery('button#ajout_role').on('click', cloneRole);
	*/




});


