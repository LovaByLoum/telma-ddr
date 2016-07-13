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
    $element->id          =   $user->data->ID;
    $element->nom         =   get_user_meta( $user->data->ID, "last_name", true );
    $element->prenom      =   get_user_meta( $user->data->ID, "first_name", true );
    $element->email       =   $user->data->user_email;
    $element->pseudo      =   $user->data->user_login;
    $element->role        =   $user->roles[0];
    $element->register    =   mysql2date( get_option( 'date_format' ), $user->data->user_registered );


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
	   * @param string $username
	   * @param string $password
	   * @return bool|WP_User a WP_User object if the username matched an existing user, or false if it didn't
	   */
	  public static function allow_programmatic_login( $user, $username, $password ) {
	  	return get_user_by( 'login', $username );
	  }

}

add_filter('wp_ajax_telmarh_check_email_exist',array('CUser','telmarh_check_email_exist'));
add_filter('wp_ajax_nopriv_telmarh_check_email_exist',array('CUser','telmarh_check_email_exist'));
add_filter('wp_ajax_telmarh_check_login_exist',array('CUser','telmarh_check_login_exist'));
add_filter('wp_ajax_nopriv_telmarh_check_login_exist',array('CUser','telmarh_check_login_exist'));
?>