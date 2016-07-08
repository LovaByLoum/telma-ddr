<?php
/**
 * Options du theme
 *
 * ajouter ici les options du themes
 */

global $telmarh_options_settings, $token;

$telmarh_options_settings = array(
	'Configuration du pied de page' => array(
		'adress_site'        => array(
			'label'       => 'Adresse du site',
			'type'        => 'textarea',
			'description' => 'Ajouter ici l\'adresse du site',
		),
		'phone_site'         => array(
			'label'       => 'Numéro de Téléphone du site',
			'type'        => 'text',
			'description' => 'Ajouter ici le numero de téléphone du site',
		),
		'copyright'          => array(
			'label'       => 'Copyright',
			'type'        => 'text',
			'description' => '',
		),
		'description_footer' => array(
			'label'       => 'Description du footer',
			'type'        => 'textarea',
			'description' => 'Texte qui sera afficher dans le footer'
		)
	)
);