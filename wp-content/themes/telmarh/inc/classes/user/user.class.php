<?php
/**
 * classe de service pour les users
 *
 * @package WordPress
 * @subpackage telmarh
 * @since telmarh 1.0
 * @author : Netapsys
 */
class CUser {

    private static $_elements;
	public static $_tableNameEmail = "telmarh_email_enqueue";
	
  public function __construct() {
    
  }
  
  /**
   * fonction qui prend les informations son Id. 
   * 
   * @param type $uid
   */
  public static function getById($uid) {
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
    $element->email             =   $user->data->user_email;
    $element->pseudo            =   $user->data->user_login;
    $element->role              =   $user->roles[0];
    $element->register          =   mysql2date( get_option( 'date_format' ), $user->data->user_registered );
	$element->phone_number      =   get_user_meta( $user->ID, "num_phone_user", true );


    //...

    //stocker dans le tableau statique
    self::$_elements[$uid] = $element;
  }
  
  // requete des utilisateur selon leur role ou par nom, email, ...
  public static function getBy( $role = "", $search = ""  ){
    $args = array(
      'role' => $role,
      'search' => $search       
    );
    $elements = get_users($args);
    $elts = array();
    foreach ($elements as $id) {
    	$elt = self::getById(intval($id->ID));
    	$elts[]=$elt;
    }
    return $elts;
  }

	public static function telmarh_check_email_exist()
	{
		$data = 0;
		if ( isset( $_POST['data_type'] ) && !empty( $_POST['data_type'] ) ) {
			$email = $_POST['data_type'];
			$existEmail = email_exists( $email );
			$data = ( $existEmail ) ? false : true;
		}
		echo $data;
		die();
	}

	public static function telmarh_check_login_exist(){
		$data = 0;
		if ( isset( $_POST['data_type'] ) && !empty( $_POST['data_type'] ) ){
			$login = $_POST['data_type'];
			$loginExist = username_exists( $login );
			$data = ( $loginExist ) ? false : true;
		}
		echo $data;
		die();
	}

	public static function telmarh_check_login_email_exist(){
		$data = 0;
		if ( isset( $_POST['data_type'] ) && !empty( $_POST['data_type'] ) ){
			$login = $_POST['data_type'];
			if ( strpos( $login, '@' ) ){
        $loginExist = email_exists( $login );
      } else {
        $loginExist = username_exists( $login );
      }
			$data = ( $loginExist ) ? false : true;
		}
		echo $data;
		die();
	}

	public static function request_user_approval_email( $userId )
	{
		$user = self::getById( $userId );
		$email = $user->email;
		/* on procède au cryptage de la variable */
		$hash = crypt( "123456", "activate_user_" . $user->id );
		$link = site_url() . "?action=confirmation-user&id=" . $user->id . "&hash=" . urlencode( $hash ) . "&appouve=1";
		$userEmail = $email;
		$adminEmail = get_option( "admin_email" );
		$blogname = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
		$subjetAdmin = "Un utilisateur vient de s'inscrire sur le site";
		$messageAdmin = "Bonjour Admin,

	                      Un utilisateur vient de s'inscrire sur " . get_option( "blogname" ) . "

	                      Voici ses informations :
	                        - <strong>Nom : </strong> {$user->nom}
	                        - <strong>Prénom : </strong> {$user->prenom}
	                        - <strong>Email : </strong> {$user->email}

	                      Cordialement,
	                      ";
		$sujetUser = "Confirmation de votre compte";
		$messageUser = "Bonjour {$user->prenom}  {$user->nom} ,

	                      Merci d'avoir créé un compte sur le site  <a href='" . site_url() . "'>Jobopportunity</a>.
	                      Veuillez cliquer ce lien pour confirmer votre compte :<br /><a href='" . $link . "'>Ici</a> <br />

						  L'équipe Jobopportunity
	                      Cordialement,";
		telmarh_send_mail( $adminEmail, $subjetAdmin, $messageAdmin, $blogname );
		telmarh_send_mail( $userEmail, $sujetUser, $messageUser, $blogname );
	}

	/**
	 * Programmatically logs a user in
	 *
	 * @param string $username
	 *
	 * @return bool True if the login was successful; false if it wasn't
	 */
	public static function programmatic_login( $username )
	{
		if ( is_user_logged_in() ) {
		  		wp_logout();
	    }

	    add_filter( 'authenticate', array( __CLASS__, 'allow_programmatic_login' ), 10, 3 );	// hook in earlier than other callbacks to short-circuit them
	    $user = wp_signon( array( 'user_login' => $username ) );
	    remove_filter( 'authenticate', array( __CLASS__, 'allow_programmatic_login' ), 10, 3 );

	    if ( is_a( $user, 'WP_User' ) ) {
	        wp_set_current_user( $user->ID, $user->user_login );

	        if ( is_user_logged_in() ) {
	            return true;
	        }
	    }

		return false;
	}

	/**
	 * An 'authenticate' filter callback that authenticates the user using only the username.
	 *
	 * To avoid potential security vulnerabilities, this should only be used in the context of a programmatic login,
	 * and unhooked immediately after it fires.
	 *
	 * @param WP_User $user
	 * @param string  $username
	 * @param string  $password
	 *
	 * @return bool|WP_User a WP_User object if the username matched an existing user, or false if it didn't
	 */
	public static function allow_programmatic_login( $user, $username, $password )
	{
		return get_user_by( 'login', $username );
	}

	public static function installTable(){
		global $wpdb;
		if ( $wpdb->get_var( "show tables like '" . self::$_tableNameEmail . "'" ) != self::$_tableNameEmail ) {

			$sql = "CREATE TABLE  " . self::$_tableNameEmail . " (
              id bigint(20) NOT NULL auto_increment,
              email varchar(255) default NULL,
              date_envoi datetime default NULL,
              envoyer int(1) default 0,
              element varchar(225) default NULL,
              PRIMARY KEY  (`id`)
            ) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;";

			$wpdb->query( $sql );
		}

	}

    public static function send_notifications($lot = 100)
    {
        global $wpdb, $telmarh_options;
        global $ts_mail_errors;
        global $phpmailer;
        if ($wpdb->get_var("SHOW TABLES LIKE '" . self::$_tableNameEmail . "'") == self::$_tableNameEmail) {
            $emails = $wpdb->get_results($sql = "SELECT * FROM " . self::$_tableNameEmail . " WHERE envoyer = 0  ORDER BY id ASC LIMIT " . $lot);
            write_log('recuperation adresses mails pour envoi de notifications ok ');
            $sujet = (isset($telmarh_options['subjet_mail_gt']) && !empty($telmarh_options['subjet_mail_gt'])) ? $telmarh_options['subjet_mail_gt'] : "";
            $content = (isset($telmarh_options['content_mail_gt']) && !empty($telmarh_options['content_mail_gt'])) ? $telmarh_options['content_mail_gt'] : "";
            $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
            $date_format = get_option('date_format');
            $time_format = get_option('time_format');
            $error_log_message = 'Debut envoi mail: ' . $sujet . '. Ce ' . date("d-m-Y H:i:s");

            if (!empty($emails)) {
                foreach ($emails as $line) {
                    $email = $line->email;
                    $dataUniqueId = $line->element;
                    $siteName = get_bloginfo("name");
                    $data = COffre::getElementFormInFosByUniqueId(FORMULAIRE_POSTULER_OFFRE, $dataUniqueId);
                    $tobereplaced = array('[offre:url]', '[soubmission:data]', '[site:name]');
                    $replacement = array($data['offre'], $data['html'], $siteName);
                    $content = str_replace($tobereplaced, $replacement, $content);
                    $sujet = str_replace($tobereplaced, $replacement, $sujet);
                    $error_log_message = 'Debut envoi mail: ' . strip_tags($sujet) . '. Ce ' . date("d-m-Y H:i:s");
                    write_log($error_log_message);
                    $result = telmarh_send_mail($email, strip_tags($sujet), $content, $blogname);
                    //$result = wp_mail($sendto, $subject, $content, $headers);
                    //$result = wp_mail($sendto, $subject, $content, $headers);
                    if (!$result) {
                        if (!isset($ts_mail_errors)) $ts_mail_errors = array();
                        if (isset($phpmailer)) {
                            $ts_mail_errors[] = $phpmailer->ErrorInfo;
                            write_log( 'Erreur d\'envoie de mail pour ' . $email . ' : '. $phpmailer->ErrorInfo );
                        }
                    } else {
                        write_log('Envoi mail ok pour ' . $email);
                        $wpdb->update(self::$_tableNameEmail, array('envoyer' => 1, 'date_envoi' => date('Y-m-d H:i:s')), array('id' => $line->id));
                    }
                }
                write_log('Fin envoi mail' . '. Ce ' . date("d-m-Y H:i:s"));
            }

        } else {
            write_log('La table ' . self::$_tableNameEmail . ' n\'existe pas encore');
        }

    }

	public static function purge_list_email( $lot = 100 )
	{
		global $wpdb;
		self::installTable();
        write_log( 'Debut purge liste mails ' . '. Ce ' . date("d-m-Y H:i:s"));
		$time_last_month = strtotime( "-1 month", time() );
		$sql = "DELETE
	            FROM " . self::$_tableNameEmail . "
	            WHERE envoyer = 1
	            AND UNIX_TIMESTAMP(date_envoi) < '" . $time_last_month . "'
	            ORDER BY date_envoi ASC LIMIT {$lot}";
		$results = $wpdb->query( $sql );
        if ( $results ){
            write_log( 'Fin purge liste mails ' . '. Ce ' . date("d-m-Y H:i:s"));
        } else {
            write_log( 'Aucune action n \'a été faite pour la purge listes mails' . '. Ce ' . date("d-m-Y H:i:s"));
        }

	}
        
        public static function clear_cron_tasks (  ){
		global $wpdb;
            set_time_limit(0);
                write_log( 'Debut du lancement cron pour envoyé les mails ' );
                self::send_notifications();
	}


}

add_filter('wp_ajax_telmarh_check_email_exist',array('CUser','telmarh_check_email_exist'));
add_filter('wp_ajax_nopriv_telmarh_check_email_exist',array('CUser','telmarh_check_email_exist'));
add_filter('wp_ajax_telmarh_check_login_exist',array('CUser','telmarh_check_login_exist'));
add_filter('wp_ajax_nopriv_telmarh_check_login_exist',array('CUser','telmarh_check_login_exist'));
add_filter('wp_ajax_telmarh_check_login_email_exist',array('CUser','telmarh_check_login_email_exist'));
add_filter('wp_ajax_nopriv_telmarh_check_login_email_exist',array('CUser','telmarh_check_login_email_exist'));
?>