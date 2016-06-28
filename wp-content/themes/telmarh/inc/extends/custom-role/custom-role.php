<?php
/**
 * Déclaration des profils users
 *
 * @package WordPress
 * @subpackage telmarh
 * @since telmarh 1.0
 * @author : Netapsys
 */

add_action('init', 'telmarh_init_role');
function telmarh_init_role(){
  add_role( USER_PROFILE_ADMIN, 'Administrateur');
  add_role( USER_PROFILE_WEBMASTER, 'Webmaster');
  add_role( USER_PROFILE_MEMBRE, 'Membre');
}