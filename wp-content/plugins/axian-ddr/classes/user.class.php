<?php

class AxianDDRUser{
    private static $_elements;
    public static function getById($uid){
        $uid = intval($uid);

        //On essaye de charger l'element
        if(!isset(self::$_elements[$uid])) {
            self::_load($uid);
        }
        //Si on a pas réussi à chargé l'article (pas publiée?)
        if(!isset(self::$_elements[$uid])) {
            return FALSE;
        }

        return self::$_elements[$uid];
    }

    /**
     * fonction qui charge toutes les informations dans le variable statique $_elements.
     *
     * @param type $uid
     */
    private static function _load( $uid ) {
        global $wpdb;
        $uid = intval($uid);
        $user = get_user_by('id',$uid);

        $element = new stdClass();
        //traitement des données
        $element->id                =   $user->data->ID;
        $element->nom               =   get_user_meta( $user->data->ID, "last_name", true );
        $element->prenom            =   get_user_meta( $user->data->ID, "first_name", true );
        $element->display_name      =   $user->data->display_name;
        $element->email             =   $user->data->user_email;
        $element->pseudo            =   $user->data->user_login;
        $element->role              =   $user->roles;
        $element->register          =   mysql2date( get_option( 'date_format' ), $user->data->user_registered );

        $element->company           =   get_user_meta( $user->ID, "company", true );
        $element->manager           =   get_user_meta( $user->ID, "manager", true );
        $element->_manager          =   get_user_meta( $user->ID, "_manager", true );
        $element->departement       =   get_user_meta( $user->ID, "departement", true );
        $element->description       =   get_user_meta( $user->ID, "next_ad_int_description", true );
        $element->cn                =   get_user_meta( $user->ID, "next_ad_int_cn", true );
        $element->classification    =   get_user_meta( $user->ID, "classification", true );
        $element->mobile            =   get_user_meta( $user->ID, "mobile", true );
        $element->titre             =   get_user_meta( $user->ID, "title", true );
        $element->matricule         =   get_user_meta( $user->ID, "matricule", true );


        //...

        //stocker dans le tableau statique
        self::$_elements[$uid] = $element;
    }

    public static function isADUser($userId){
        $samAccountName = get_user_meta($userId, NEXT_AD_INT_PREFIX . 'samaccountname', true);
        if ($samAccountName) {
            return true;
        }
        return false;
    }
}