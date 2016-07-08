<?php
/**
 * Options du theme
 *
 * ajouter/modifier ici les options du themes
 */

global $telmarh_options_settings;

$telmarh_options_settings = array(
    'Configuration du pied de page'       => array(
        'adress_site' => array(
          'label' => 'Adresse du site',
          'type' => 'textarea',
          'description' => 'Ajouter ici l\'adresse du site',
        ),
        'phone_site' => array(
          'label' => 'Numéro de Téléphone du site',
          'type' => 'text',
          'description' => 'Ajouter ici le numero de téléphone du site',
        ),
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
    )
);