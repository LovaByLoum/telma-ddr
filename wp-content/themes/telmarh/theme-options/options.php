<?php
/**
 * Options du theme
 *
 * ajouter/modifier ici les options du themes
 */

global $telmarh_options_settings;

$telmarh_options_settings = array(
    'Configuration du pied de page'       => array(
        'copyright' => array(
          'label' => 'Copyright',
          'type' => 'text',
          'description' => '',
        ),
        'description_footer' => array(
            'label'       => 'Description du footer',
            'type'        => 'textarea',
            'description' => 'Texte qui sera afficher dans le footer'
        )
    ),
    'Configuration pagination'  => array(
        'nombre_atus' => array(
          'label' => 'Nombres offres pour afficher dans la liste du premier affichage',
          'type' => 'text',
          'description' => '',
        )
    ),
    'Réseaux sociaux'               => array(
        'facebook'   => array(
            'label'       => 'Facebook',
            'type'        => 'url',
            'description' => 'Url',
        ),
        'twitter'    => array(
            'label'       => 'Twitter',
            'type'        => 'url',
            'description' => 'Url',
        ),
        'instagramm' => array(
            'label'       => 'Instagramm',
            'type'        => 'url',
            'description' => 'Url',
        ),
        'linkedin'    => array(
            'label'       => 'Linkedin',
            'type'        => 'url',
            'description' => 'Url',
        ),
        'google'  => array(
            'label'       => 'Google+',
            'type'        => 'url',
            'description' => 'Url',
        ),
    ),
	'Formulaire postulation offre' => array(
		'subjet_mail_gt' => array(
			'label'         => 'Sujet email GT',
			'type'          => 'text',
		),
		'content_mail_gt' => array(
			'label'         => 'Contenu du message',
			'type'          => 'textarea',
			'description'   => 'token : <ul><li><strong>lien vers l\'offre :</strong>[offre:url]</li><li><strong>la soumission :</strong>[soubmission:data]</li><li><strong>le site url :</strong>[site:name]</li></ul>'
		)
	),
	'Formulaire de contact' => array(
		'email_send_contact' => array(
			'label'     => 'Email d\'envoie contact',
			'type'      => 'text',
		),
		'subjet_mail_user' => array(
			'label'         => 'Sujet email utilisateur',
			'type'          => 'text',
		),
		'content_mail_user' => array(
			'label'         => 'Contenu du message',
			'type'          => 'textarea',
			'description'   => 'token : <ul><li><strong>la soumission :</strong>[soubmission:data]</li><li><strong>le site url :</strong>[site:name]</li></ul>'
		),
		'subjet_mail_admin' => array(
			'label'         => 'Sujet email administrateur',
			'type'          => 'text',
		),
		'content_mail_admin' => array(
			'label'         => 'Contenu du message',
			'type'          => 'textarea',
			'description'   => 'token : <ul><li><strong>la soumission :</strong>[soubmission:data]</li><li><strong>le site url :</strong>[site:name]</li></ul>'
		),
		'option_reponse_form' => array(
			'label'         => 'Texte apres la validation du formulaire',
			'type'          => 'textarea'
		)

	),
	'Option champs inscription' => array(
		'list_pays' => array(
			'label'             => 'Liste des pays',
			'type'              => 'text',
			'description'       => 'Séparer les valeurs par un virgule (ex : Madagascar,France,Canada)'
		),
		'list_nationnalite' => array(
			'label'             => 'Liste Nationnalité',
			'type'              => 'text',
			'description'       => 'Séparer les valeurs par un virgule (ex : Malgache,Français,Americain)'
		)
	)
);