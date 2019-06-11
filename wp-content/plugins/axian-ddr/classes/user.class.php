<?php

class AxianDDRUser{

    public static $company_list = array(
        'AXIAN' => 'AXIAN',
        'BNI MADAGASCAR' => 'BNI MADAGASCAR',
        'EDM' => 'EDM',
        'FIRSTIMMO' => 'FIRSTIMMO',
        'GES' => 'GES',
        'Jovena' => 'Jovena',
        'IORS' => 'IORS',
        'Link' => 'LInk',
        'SGEM' => 'SGEM',
        'TOM' => 'TOM',
        'TRM' => 'TRM',
        'TELMA' => 'TELMA',
        'TELMA Compres' => 'TELMA Comores',
        'WeLight' => 'WeLight',
    );

    public $fields;

    public function __construct(){
        // Hooks near the bottom of profile page (if current user)
        add_action('show_user_profile', array($this,'show_user_profile'));

        // Hooks near the bottom of the profile page (if not current user)
        add_action('edit_user_profile', array($this,'edit_user_profile'));

        // Hook is used to save custom fields that have been added to the WordPress profile page (if current user)
        add_action( 'personal_options_update',array($this, 'update_extra_profile_fields' ));

        // Hook is used to save custom fields that have been added to the WordPress profile page (if not current user)
        add_action( 'edit_user_profile_update',array($this, 'update_extra_profile_fields' ));

        $departements = AxianDDRTerm::getby(array('type' => 'departement') , 'options' );;
        $this->fields = array(
            'company' => array(
                'label' => 'Company',
                'type' => 'select',
                'name' => 'axian_ddr_user_meta[company]',
                'size' => '50',
                'search' => true,
                'options' => AxianDDRUser::$company_list,
                'placeholder' => ' '
            ),
            'manager' => array(
                'label' => 'Manager',
                'type' => 'autocompletion',
                'source' => 'user',
                'name' => 'axian_ddr_user_meta[manager]',
            ),
            'departement' => array(
                'label' => 'Département',
                'type' => 'select',
                'name' => 'axian_ddr_user_meta[departement]',
                'size' => '50',
                'search' => true,
                'class' =>'departement',
                'options' => $departements,
                'placeholder' => ' '
            ),
            'next_ad_int_description' => array(
                'label' => 'Description',
                'type' => 'textarea',
                'cols' => '40',
                'rows' => '4',
                'name' => 'axian_ddr_user_meta[next_ad_int_description]',
            ),
            'next_ad_int_cn' => array(
                'label' => 'Fonction',
                'type' => 'text',
                'size' => '50',
                'name' => 'axian_ddr_user_meta[next_ad_int_cn]',
            ),
            'classification' => array(
                'label' => 'Classification',
                'type' => 'text',
                'size' => '50',
                'name' => 'axian_ddr_user_meta[classification]',
            ),
            'mobile' => array(
                'label' => 'Mobile',
                'type' => 'text',
                'size' => '50',
                'name' => 'axian_ddr_user_meta[mobile]',
            ),
            'titre' => array(
                'label' => 'Titre',
                'type' => 'text',
                'size' => '50',
                'name' => 'axian_ddr_user_meta[titre]',
            ),
            'matricule' => array(
                'label' => 'Matricule',
                'type' => 'text',
                'size' => '50',
                'name' => 'axian_ddr_user_meta[matricule]',
            ),
        );
    }

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

    public function edit_user_profile( $user ) {
        $post_data = [];
        foreach ( $this->fields as $key => $value ){
            $post_data[$key] = get_the_author_meta( $key, $user->ID );
        }
        if ( current_user_can( 'edit_user', $user->ID ) && !AxianDDRUser::isADUser($user->ID)) :?>
            <h3>Appartenance</h3>
            <div class="ddr-settings">
                <?php foreach ( $this->fields as $field ) :?>
                    <div class="form-field form-required term-name-wrap form-row col-md-6">
                        <?php axian_ddr_render_field($field , $post_data);?>
                    </div>
                <?php endforeach ?>
            </div>
        <?php endif;
    }

    public function show_user_profile( $user ) {
        $post_data = [];
        foreach ( $this->fields as $key => $value ){
            $post_data[$key] = get_the_author_meta( $key, $user->ID );
        }
        if ( current_user_can( 'edit_user', $user->ID ) && !AxianDDRUser::isADUser($user->ID)) :?>
            <h3>Appartenance</h3>
            <div class="ddr-settings">
                <?php foreach ( $this->fields as $field ) :?>
                    <div class="form-field form-required term-name-wrap form-row col-md-6">
                        <?php axian_ddr_render_field($field , $post_data, true, true);?>
                    </div>
                <?php endforeach ?>
            </div>
        <?php endif;
    }

    public function update_extra_profile_fields( $user_id ) {
        if ( current_user_can( 'edit_user', $user_id ) && !AxianDDRUser::isADUser($user_id)){
            foreach($_POST['axian_ddr_user_meta'] as $key => $value ){
                update_user_meta( $user_id, $key, $value );
            }
        }
    }

    public static function getUserValidator(){
        global $wpdb;
        $role_filter = array(
            'administrateur-ddr',
            'assistante-direction',
            'assistante-rh',
            'controleur-budgetaire',
            'drh',
            'dg',
            'responsable_rh',
        );

        $glue = "";
        $query_select = "
                            SELECT u.ID as id FROM   ".$wpdb->users."  AS u
                            INNER JOIN  ".$wpdb->usermeta."   AS um
                            ON  ( u.ID = um.user_id AND um.meta_key = 'wp_capabilities' )
                            WHERE
                        ";
        foreach ( $role_filter as $role ){
            $query_select .= $glue . ' um.meta_value LIKE \'%"' . $role . '"%\' ';
            $glue = ' OR ';
        }
        $results = $wpdb->get_results($query_select,ARRAY_A);
        return $results;
    }
}
new AxianDDRUser();