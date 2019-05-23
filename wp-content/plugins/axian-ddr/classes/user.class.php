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
        $element->role              =   $user->roles[0];
        $element->register          =   mysql2date( get_option( 'date_format' ), $user->data->user_registered );

        //$element->phone_number      =   get_user_meta( $user->ID, "num_phone_user", true );


        //...

        //stocker dans le tableau statique
        self::$_elements[$uid] = $element;
    }
}