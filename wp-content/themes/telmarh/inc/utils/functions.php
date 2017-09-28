<?php
/**
 * fonctions utilitaires
 * deboguage, etc ...
 *
 * @package WordPress
 * @subpackage telmarh
 * @since telmarh 1.0
 * @author : Netapsys
 */

if(!function_exists('mp')){
  /**
   * Fonction pour debugger (message privé).
   *
   * @param type $var
   * @param type $t
   */
  function mp($var, $t = true, $logged = 'administrator') {
    global $current_user;
    //if ( $logged && is_user_logged_in() && in_array( $logged, $current_user->roles) ){
      print('<pre style="text-align: left;">');
      print_r($var);
      print('</pre>');
      if($t == true)
        die();
    }
//  }
}

if(!function_exists('wp_log')){
  /**
   * créer un fichier log personnalisé dans wp-content/logs
   */
  function wp_log( $data ){
    $path_log = ABSPATH .'logs';
    @mkdir($path_log);
    $path_log.= '/wp.log';
    if(is_array($data) ||is_object($data) ){
      ob_start();
      print_r($data);
      $str = ob_get_contents();
      ob_clean();
    }else{
      $str = $data;
    }
    $str = date('Y-m-d H:i:s') . '     ' . $str . "\r\n";
    wp_create_file($path_log, $str,'a');
  }
  /**
   * creer un fichier et insere un contenu
   *
   * @param string $filename
   * @param string $somecontent
   * @return bool
   */
  function wp_create_file($filename, $somecontent, $openmode = "w"){
    if (!$handle = @fopen($filename, $openmode)) {
      return false;
    }
    if (@fwrite($handle, $somecontent) === FALSE) {
      return false;
    }
    @fclose($handle);
    return true;
  }
}

if(!function_exists('wp_minify')){
  //minification des ressources
  function wp_minify($array_file, $type){
    $file = 'telmarh';
    $minified = get_template_directory_uri() . '/' . $type .'/' . $file . '.min.' . $type ;
    $minifiedpath = get_template_directory() . '/' . $type .'/' . $file . '.min.' . $type ;

    if (is_file($minifiedpath)){
      return $minified;
    }else{
      $result = '';
      foreach($array_file as $key => $value) {
        if ($type == 'css'){
          if( $value ){
            $result .= "\n" . CssMin::minify(file_get_contents(get_template_directory_uri(). '/' . $type. '/'.$key. '.'.$type));
          }
          else {
            $result .= "\n" . file_get_contents(get_template_directory_uri(). '/' . $type. '/'.$key. '.'.$key);
          }
        }else{
          if( $value ){
            $result .= "\n" . JSMin::minify(file_get_contents(get_template_directory_uri(). '/' . $type. '/'.$key. '.'.$type));
          }else{
            $result .= "\n" . file_get_contents(get_template_directory_uri(). '/' . $type. '/'.$key. '.'.$type);
          }
        }
      }

      if ($type == 'css'){
        $result=str_replace('@charset "utf-8";', '', $result);
        $result = '@charset "utf-8";' . $result;
      }
      wp_create_file($minifiedpath,$result);
      return $minified;
    }
  }
}

if(!function_exists('wp_limite_text')){
  /**
   * Fonction qui sert a tronqué un texte par nombre de caractere.
   */
  function wp_limite_text($string, $char_limit =NULL) {
    if($string && $char_limit){
      if(strlen($string) > $char_limit){
        $words = substr($string,0,$char_limit);
        $words = explode(' ', $words);
        array_pop($words);
        return implode(' ', $words).' ...';
      }else{
        return $string;
      }
    }else{
      return $string;
    }
  }
}

if(!function_exists('wp_limite_word')){
  /**
   * Fonction qui sert a tronqué un texte par nombre de mot.
   */
  function wp_limite_word($string, $word_limit =NULL) {
    if($string && $word_limit){
      $words = preg_split("/[\s,-:]+/", $string, -1 ,PREG_SPLIT_OFFSET_CAPTURE);
      if (isset($words[$word_limit-1])){
        $the_word = $words[$word_limit-1][0];
        $offset = intval($words[$word_limit-1][1]);
        $string = substr($string,0, $offset +strlen($the_word));
        if (isset($words[$word_limit])){
          $string.='...';
        }
      }
      return $string;
    }else{
      return $string;
    }
  }
}

if(!function_exists('wp_get_post_by_template')){
  /**
   * fonction qui recherche les posts par son template
   */
  function wp_get_post_by_template($meta_value, $dir_page_template = 'page-templates/'){
    $args = array(
      'post_type' => 'page',
      'meta_key' => '_wp_page_template',
      'meta_value' => $dir_page_template . $meta_value,
      'suppress_filters' => FALSE,
      'numberposts' => 1,
      //'fields' => 'ids'
    );
    $posts = get_posts($args);
    if(isset($posts) && !empty($posts)){
      return $posts[0];
    }else{
      global $post;
      return $post;
    }
  }
}

if (!function_exists('get_post_by_slug')) :
  //fonction recherchant les post par slug
  function get_post_by_slug($slug, $pt, $pages = false)
  {
    if (empty($slug))
      return false;

    if (is_array($pages) && !empty($pages))
    {
      foreach ($pages as $page)
        if ($page->post_name == $slug)
          return $page;
    }

    global $wpdb;
    return $wpdb->get_row("SELECT * FROM $wpdb->posts WHERE post_name = '". $wpdb->escape($slug)."' AND post_status = 'publish' AND post_type ='". $wpdb->escape($pt)."'");
  }
endif;

//requiert tous les fichiers d'un dossier
function require_once_files_in($path){
  if ( is_dir($path) ){
    $nodes = glob($path . '/*.php');
    foreach ($nodes as $node) {
      if(is_file($node)){
        require_once( $node );
      }
    }
  }
}

//obtenir les labels pour la création de post type en français accordé avec le genre et nombre
/*
 * @param $ptsingle string : nom post type au singulier
 * @param $ptplural string : nom post type au pluriel
 * @param $masculin boolean : definir si masculin
 */
function get_custom_post_type_labels($ptsingle, $ptplural, $masculin){
  $labels = array(
    "name"				=> ucfirst($ptsingle),
    "singular_name"		=> ucfirst($ptplural),
    "add_new"			=> "Ajouter" ,
    "add_new_item"		=> "Ajouter" . ($masculin ? " un nouveau " : " une nouvelle " ) . $ptsingle,
    "edit_item"			=> "Modifier " . $ptsingle,
    "new_item"			=> ($masculin ? "Nouveau " : "Nouvelle " ) . $ptsingle,
    "view_item"			=> "Voir " . $ptsingle,
    "search_items"		=> "Rechercher des "  . $ptplural ,
    "not_found"			=> ($masculin ? "Aucun " : "Aucune " ) . $ptsingle .  ($masculin ? " trouvé" : " trouvée" ),
    "not_found_in_trash"=> ($masculin ? "Aucun " : "Aucune " ) . $ptsingle .  ($masculin ? " trouvé " : " trouvée " ) . "dans la corbeille",
    "parent_item_colon"	=> ucfirst($ptsingle) . ($masculin ? " parent" : " parente" ),
    "all_items"			=> ($masculin ? "Tous les " : "Toutes les " ) . $ptplural,
    "menu_name"         => ucfirst($ptplural),
    "parent_item_colon" => "",
  );
  return $labels;
}

//obtenir les labels pour la création de taxonomie en français accordé avec le genre et nombre
/*
 * @param $taxsingle string : nom taxonomie au singulier
 * @param $taxplural string : nom taxonomie au pluriel
 * @param $masculin boolean : definir si masculin
 */
function get_custom_taxonomy_labels($taxsingle, $taxplural, $masculin){
  $labels = array(
    'name'                       => ucfirst($taxsingle),
    'singular_name'              => ucfirst($taxsingle),
    'search_items'               => 'Rechercher des '. $taxplural,
    'popular_items'              => ucfirst($taxplural) . ' les plus populaires',
    'all_items'                  => ($masculin ? "Tous les " : "Toutes les " ) . $taxplural,
    'parent_item'                => null,
    'parent_item_colon'          => null,
    'edit_item'                  => 'Modifier',
    'update_item'                => 'Mettre à jour',
    'add_new_item'               => 'Ajouter ' . ($masculin ? "un " : "une " ) . $taxsingle,
    'new_item_name'              => 'Nouveau nom',
    'separate_items_with_commas' => 'Séparez les ' . $taxplural . ' par des virgules',
    'add_or_remove_items'        => 'Ajouter ou supprimer ' . ($masculin ? "un " : "une " ) . $taxsingle,
    'choose_from_most_used'      => 'Choisir parmi les ' . $taxplural . ' les plus '. ($masculin ? "utilisés" : "utilisées" ),
    'not_found'                  => ($masculin ? "Aucun " : "Aucune " ) . $taxsingle,
    'menu_name'                  => ucfirst($taxplural),
  );
  return $labels;
}

//custom capabilities for post
function wp_get_custom_posts_capabilities( $capability_type, $is_taxo = false ){
  if ( $is_taxo ){
    $caps =  array(
      "manage_terms"        => "manage_{$capability_type}s",
      "edit_terms"          => "edit_{$capability_type}s",
      "delete_terms"        => "delete_{$capability_type}s",
      "assign_terms"        => "assign_{$capability_type}s",
    );
  }else{
    $caps =  array(
      "edit_post"                   => "edit_{$capability_type}",
      "edit_private_posts"          => "edit_private_{$capability_type}s",
      "edit_published_posts"        => "edit_published_{$capability_type}s",
      "delete_post"                 => "delete_{$capability_type}",
      "delete_posts"                => "delete_{$capability_type}s",
      "delete_private_posts"        => "delete_private_{$capability_type}s",
      "delete_published_posts"      => "delete_published_{$capability_type}s",
      "delete_others_posts"         => "delete_others_{$capability_type}s",
      "edit_posts"                  => "edit_{$capability_type}s",
      "edit_others_posts"           => "edit_others_{$capability_type}s",
      "publish_posts"               => "publish_{$capability_type}s",
      "read_private_posts"          => "read_private_{$capability_type}s",
      "create_posts"                => "edit_{$capability_type}s",
    );
  }

  //perform affichage dans Advanced Access Manager
  if ( class_exists('mvb_WPAccess') ){
    $keys = array_unique(array_values($caps));
    $str = '';
    foreach ( $keys as $v){
      $str.="\$grouped_list['" . str_replace('_', ' ', ucfirst($capability_type)) . "'][]='$v';\n";
    }

    $str .=
      "foreach( \$grouped_list['Miscelaneous'] as \$k => \$v ){
          if ( in_array( \$v,  \$grouped_list['" . str_replace('_', ' ', ucfirst($capability_type)) . "'] ) ){
        unset( \$grouped_list['Miscelaneous'][\$k] );
      }
  }\n";
    $str.= 'return $grouped_list;';
    $function = create_function('$grouped_list', $str );
    add_filter('aam_grouped_list',  $function);
  }

  return $caps;
}

/*fonction d'encryptage*/
function wp_encrypt_text($str){
  $str = base64_encode($str);
  return $str;
}

/*function de decryptage*/
function wp_decrypt_text($str){
  $str = base64_decode($str);
  return $str;
}

add_action( "save_post", "telmarh_save_post" );
function telmarh_save_post( $post_id ){
	// If this is just a revision, don't send the email.
	if ( wp_is_post_revision( $post_id ) )
		return;
	$post_type = get_post_type( $post_id );
	if ( $post_type == JM_POSTTYPE_OFFRE ) {
		$offre              = JM_Offre::getById( $post_id );
		$societe            = ( isset( $offre->societe_associe ) && !empty( $offre->societe_associe ) ) ? JM_Societe::getById( $offre->societe_associe ) : "";
		$societeName        = ( !empty( $societe ) && isset( $societe->slug ) && !empty( $societe->slug ) ) ? mb_strtoupper( $societe->slug ) : "TELMA";
		$departement        = ( isset( $offre->departement ) && !empty( $offre->departement ) ) ? $offre->departement[0] : "";
		$departementName    = ( !empty( $departement ) && isset( $departement->slug ) && !empty( $departement->slug ) ) ? mb_strtoupper( $departement->slug ) : "RH";
		$dateNow            =  date( "Ym" );

		changeReferenceIsExistToMeta( $societeName . "/" . $departementName . "/" . $dateNow, $post_id );
	}
}

add_action("login_enqueue_scripts", "telmarh_login_enqueue_script");
function telmarh_login_enqueue_script()
{
    global $telmarh_options;
    $imageUrl = ( isset( $telmarh_options['image_bg_connect'] ) && !empty( $telmarh_options['image_bg_connect'] ) ) ? $telmarh_options['image_bg_connect'] : get_template_directory_uri() . '/images/plage-1.jpg';
	$logo_image = get_theme_mod( 'telmarh_logo' );
	$style = '<style type="text/css">
	        #login h1{
	               padding-top: 30px;
	        }
	        #login h1 a, .login h1 a {
	            background-image: url(' . get_template_directory_uri() . '/images/logo-rgb.png);
	            padding-bottom: 10px;
	        }
          .login-action-login {
            background: url(' . $imageUrl . ') no-repeat center top;
            background-size: cover;
          }
          body #login {
            background-color: #fff;
            padding: 0 0 10px;
          }
          #login .message {
            border-left: none;
            color: #c80f2d;
            font-family: arial;
            font-size: 14px;
            -webkit-box-shadow: none;
            -moz-box-shadow: none;
            -o-box-shadow: none;
            -ms-box-shadow: none;
            box-shadow: none;
          }
          .login label {
            color: #646469;
            font-family: arial;
            font-size: 14px;
          }
          .login #loginform {
            -webkit-box-shadow: none
            -moz-box-shadow: none;
            -ms-box-shadow: none;
            -o-z-box-shadow: none;
            box-shadow: none;
          }
          .login #loginform .input, .login #loginform input[type=checkbox], .login input[type=text] {
            color: #646469;
            font-family: arial;
            font-size: 14px;
          }
          .login #loginform input[type=checkbox], .login input[type=text] {

          }
          .login #loginform input::-webkit-input-placeholder {color: #646469; }
          .login #loginform input::-moz-placeholder {color: #646469; }646469
          .login #loginform input:-ms-input-placeholder {color: #646469; }
          .login #loginform input:-moz-placeholder {color: #646469; }
          .login #loginform .forgetmenot {
            float: none;
          }
          .login #loginform .forgetmenot label {
            color: #646469;
            font-family: arial;
            font-size: 14px;
          }
          #login #loginform p.submit .button {
            background-color: #e57e75;
            border: none;
            -webkit-border-radius: 0
            -moz-border-radius: 0;
            -ms-border-radius: 0;
            -o-border-radius: 0;
            border-radius: 0;
            -webkit-box-shadow: none
            -moz-box-shadow: none;
            -ms-box-shadow: none;
            -o-z-box-shadow: none;
            box-shadow: none;
            -webkit-text-shadow: none
            -moz-text-shadow: none;
            -ms-text-shadow: none;
            -o-text-shadow: none;
            text-shadow: none;
            font-size: 14px;
            height: 37px;
            line-height: 37px;
            padding: 0 12px 12px;
          }
          #login #loginform p.submit .button:hover {
            background-color: #c80f2d;
          }
          .login p#backtoblog, .login #nav {
            color: #646469;
            font-size: 12px;
          }
          .login p#nav a, .login p#backtoblog a {
            color: #646469;
          }
          .login p#backtoblog a:hover, .login p#nav a:hover, .login h1 a:hover {
            color: #c80f2d;
          }
          .login #backtoblog a:hover, .login #nav a:hover, .login h1 a:hover {
            color: #c80f2d;
          }
	    </style>';
	echo $style;
}
function telmarh_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'telmarh_login_logo_url' );
function telmarh_login_logo_url_title() {
    return esc_attr( get_bloginfo( 'name', 'display' ) );
}
add_filter( 'login_headertitle', 'telmarh_login_logo_url_title' );

add_filter('manage_edit-' . JM_POSTTYPE_OFFRE . '_columns', 'telmarh_manage_candidature_columns',10);
function telmarh_manage_candidature_columns( $columns ){
	$columns['reference'] = "Réference";
	$columns['author'] = "Auteur";

	return $columns;
}
//societe column value
add_action( 'manage_' . JM_POSTTYPE_OFFRE .'_posts_custom_column', 'telmarh_manage_societe_column_value', 10, 2 );
function telmarh_manage_societe_column_value( $column_name, $post_id ) {
	$reference = get_post_meta( $post_id, REFERENCE_OFFRE, true );
	if ( $column_name == "reference" ){
		echo $reference;
	} elseif ( $column_name == "nbr_candidature" ){
		echo CPage::fm_get_number_posted_by_post_parent( $post_id, FORMULAIRE_POSTULER_OFFRE );
	}

}
add_action('add_meta_boxes','telmarh_init_metabox_offre');
function telmarh_init_metabox_offre(){
	add_meta_box('reference', 'Réference Offre', 'telmarh_offre_relations', JM_POSTTYPE_OFFRE, 'normal');
}
function telmarh_offre_relations( $post ){
	if ( !empty( $post->post_title ) ) $reference = get_post_meta( $post->ID, REFERENCE_OFFRE, true );
	else $reference = "Obtenu apres sauvegarde...";

	?>
	    <table class="form-table">
	        <tbody>
	            <tr>
	                <th scope="row">
	                    <label>Réference offre</label>
	                </th>
	                <td>
	                    <input type="text" value="<?php echo $reference;?>" readonly style="width: 100%;">
	                </td>
	            </tr>
	        </tbody>
	    </table>
	<?php
}
function changeReferenceIsExistToMeta( $reference, $postId ){
	global $wpdb;
	$sql = "SELECT
	  post_id,
	  meta_value
	FROM
	  " . $wpdb->prefix . "postmeta
	WHERE meta_key = '" . REFERENCE_OFFRE . "'
	  AND  meta_value LIKE '%" . $reference . "_%'
	ORDER BY meta_value ASC ";
	$result = end($wpdb->get_results( $sql ));
	if ( isset($result->post_id ) && !empty( $result->post_id ) && isset( $result->meta_value ) && !empty( $result->meta_value ) ){ //update reference
		$explode = explode( "_", $result->meta_value );
		if ( $postId == $result->post_id ){
			$referenceNew = $result->meta_value;
		} else {
			$increment = intval( $explode[1] );
			$referenceNew = $explode[0] . '_' . ( $increment + 1 );
		}
		update_post_meta( $postId, REFERENCE_OFFRE, $referenceNew );
	} else { //nouveau reference
		$referenceNew = $reference . '_1';
		add_post_meta( $postId, REFERENCE_OFFRE, $referenceNew );
	}
}
/**
 * Load jQuery datepicker.
 *
 * By using the correct hook you don't need to check `is_admin()` first.
 * If jQuery hasn't already been loaded it will be when we request the
 * datepicker script.
 */
function wpse_enqueue_datepicker() {
    // Load the datepicker script (pre-registered in WordPress).
    wp_enqueue_script( 'jquery-ui-datepicker' );

    // You need styling for the datepicker. For simplicity I've linked to Google's hosted jQuery UI CSS.
    wp_register_style( 'jquery-ui', get_template_directory_uri() . '/css/jquery-ui.min.css' );
    wp_enqueue_style( 'jquery-ui' );
}
add_action( 'wp_enqueue_scripts', 'wpse_enqueue_datepicker' );

add_action('wp_head','pluginname_ajaxurl');
function pluginname_ajaxurl() {
  echo '<script type="text/javascript">
  var ajaxurl = "' . admin_url('admin-ajax.php') .'"
  </script>';
}

add_action("admin_head", "telmarh_admin_head");
function telmarh_admin_head(){
	global $current_user;
	$scripts = "";
	if ( in_array( $current_user->roles[0], array( JM_ROLE_RESPONSABLE_RH ) ) ) {
		$scripts .= "\r\n
	        <script>
	        jQuery(document).ready(function(){
	            //menu form
	            //jQuery(\"#toplevel_page_fm-admin-main\").remove();
	            jQuery(\"#toplevel_page_fm-admin-main a.toplevel_page_fm-admin-main .wp-menu-name\").html('Formulaires postulation');
	            jQuery(\"#toplevel_page_fm-admin-main div.wp-submenu\").remove();
	            jQuery(\"form#fm-main-form input[type=submit][name=fm-add-new]\").remove();
	            jQuery(\"form#fm-main-form div.wrap div.tablenav\").remove();
	            jQuery(\"form#fm-main-form div.wrap table.widefat tbody tr td div.row-actions span.edit a[title*='Afficher']\").each(function(){
	                \$data = jQuery(this);
	                jQuery(this).parent().html('').append(\$data);
	                jQuery(this).parent().parent().parent().find('strong a').attr('href',\$data.attr('href'));
	            });
	            jQuery(\"#wpbody #fm-editor-tabs-wrap\").remove();
	        });
	        </script>
	    ";
	} else if ( is_admin() && in_array( $current_user->roles[0], array( "subscriber" ) ) ){
		$scripts .= "\\
			<style>
				#acf-status_user,#acf-notation_user,#acf-observations_user{
					display: none;
				}
			</style>
			";
	}

	echo $scripts;
}
add_filter( "fm_filter_custom", "telmarh_fm_search_custom", 10, 1 );
function telmarh_fm_search_custom( $postData ){
	if ( isset( $_GET['id'] ) && $_GET['id'] == FORMULAIRE_POSTULER_OFFRE ){
		$societes =  JM_Societe::getBy();
			$selected = $postData['fm-data-search-society'];
			$dataSelect = array( "" => "Tous" );
			foreach ( $societes as $societe ){
				$dataSelect[ $societe->titre ] = $societe->titre;
			}
			?>
		<div class="postbox fm-data-options" style="float:right;">
			<h3>Recherche par entreprise</h3>
			<table>
				<tr>
					<td>Entreprise:</td>
					<td>
						<select name="fm-data-search-society" id="fm-data-search-society">
							<?php foreach ( $dataSelect as $key => $col ): ?>
									<option value="<?php echo $key;?>" <?php if($selected == $key) echo 'selected="selected"';?>>
										<?php
										echo $col;?>
									</option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
			</table>
		</div><?php
	}

}
add_filter( "fm_data_query_clauses", "telmarh_fm_data_query_clauses", 10, 1 );
function telmarh_fm_data_query_clauses( $queryClauses ){
	global $wpdb;
	if ( isset( $_POST['form-id'] ) && !empty( $_POST['form-id'] ) && $_POST['form-id'] == FORMULAIRE_POSTULER_OFFRE ){
		$nickname = CPage::fm_get_unique_name_by_nickname( "entreprise_postule", FORMULAIRE_POSTULER_OFFRE );
		if ( isset( $_POST['fm-data-search-society'] ) && !empty( $_POST['fm-data-search-society'] ) ){
			if ( !trim($_POST['fm-data-search']) == "" && isset( $_POST['fm-data-search-column'] ) && $_POST['fm-data-search-column'] == $nickname ){
				unset($_POST['fm-data-search-society']);
			} else {
				$queryClauses[] = $wpdb->prepare("`". $nickname ."` = %s ", $_POST['fm-data-search-society']);
			}

		}
	}

	return $queryClauses;
}

function telmarh_add_custom_filter() {
	global $filterNiveauEtudeShow, $filterDomaineMetier;
	//Niveau d'etude
	$niveauEtudes = get_terms( JM_TAXONOMIE_NIVEAU_ETUDE, array( 'hide_empty' => false ) );
	if ( !is_null( $filterNiveauEtudeShow ) ) return;
	//Domaine d'etude
	$domaineMetier = get_terms( JM_TAXONOMIE_DEPARTEMENT, array( 'hide_empty' => false ) );
	if ( !is_null( $filterDomaineMetier ) ) return;
	$filterNiveauEtudeShow = true;
	$filterDomaineMetier = true;
	$niveauEtudesSelected = ( isset( $_GET[ 'niveau_etude' ] ) && !empty( $_GET[ 'niveau_etude' ] ) ) ? $_GET[ 'niveau_etude' ] : "";
	$domaineEtudeSelected = ( isset( $_GET[ 'domaine_etude' ] ) && !empty( $_GET[ 'domaine_etude' ] ) ) ? $_GET[ 'domaine_etude' ] : "";
	echo ' <select name="domaine_etude" id="domaine_etude" style="float:none;"><option value="">Domaine métier ciblé...</option>';
	foreach ( $domaineMetier as $term ) {
		$selected = $term->name == $domaineEtudeSelected ? ' selected="selected"' : '';
		echo '<option value="' . $term->name . '"' . $selected . '>' . $term->name . '</option>';
	}
	echo '</select>';
	echo '<input type="submit" class="button" value="Filter">';
	echo ' <select name="niveau_etude" id="niveau_etude" style="float:none;"><option value="">Niveau Etude...</option>';
	foreach ( $niveauEtudes as $term ) {
		$selected = $term->name == $niveauEtudesSelected ? ' selected="selected"' : '';
		echo '<option value="' . $term->name . '"' . $selected . '>' . $term->name . '</option>';
	}
	echo '</select>';
	echo '<input type="submit" class="button" value="Filter">';
}
add_action( 'restrict_manage_users', 'telmarh_add_custom_filter' );
function telmarh_filter_users_by_custom( $query ) {
    global $pagenow;
    if ( is_admin() && 'users.php' == $pagenow ) {
	    if ( isset( $_GET[ 'niveau_etude' ] ) ){
		    $niveauEtude = !empty( $_GET[ 'niveau_etude' ] ) ? $_GET[ 'niveau_etude' ] : "";
            $meta_query[] = array(
                array(
                    'key' => 'niveau_etude_user',
                    'value' => $niveauEtude
                )
            );
	    }

	    if ( isset( $_GET['domaine_etude'] ) ){
			$domaineMetier = !empty( $_GET['domaine_etude'] ) ? $_GET['domaine_etude'] : "" ;
		    $meta_query[] = array(
			    array(
				    'key' => "domaine_metier_recherche_user",
				    'value' => $domaineMetier
			    )
		    );
	    }
	    $query->set( 'meta_query', $meta_query );
    }
}
add_filter( 'pre_get_users', 'telmarh_filter_users_by_custom' );
//domaine Etude
function acf_load_domaine_etude_field_choices( $field ){
	global $telmarh_options;
	//reset choices
	$field['choices'] = array( );
	$field['choices'][""] = "Domaine d'etude ...";
	if ( isset( $telmarh_options['list_domaine_etude'] ) && !empty( $telmarh_options['list_domaine_etude'] ) ){
		$domainesEtudes = explode( ",", $telmarh_options['list_domaine_etude'] );
		foreach ( $domainesEtudes as $elt ){
			$field['choices'][sanitize_title( $elt )] = $elt;
		}
	}

	return $field;
}
add_filter('acf/load_field/name=domaine_etude_user', 'acf_load_domaine_etude_field_choices');

//nationnalite
function acf_load_nationalite_field_choices( $field ){
	global $telmarh_options;
	//reset choices
	$field['choices'] = array( );
	$field['choices'][""] = "Nationalité ...";
	if ( isset( $telmarh_options['list_nationnalite'] ) && !empty( $telmarh_options['list_nationnalite'] ) ){
		$nationalites = explode( ",", $telmarh_options['list_nationnalite'] );
		foreach ( $nationalites as $elt ){
			$field['choices'][sanitize_title( $elt )] = $elt;
		}
	}

	return $field;
}
add_filter('acf/load_field/name=nationalite_user', 'acf_load_nationalite_field_choices');

//pays
function acf_load_localisation_field_choices( $field ){
	global $telmarh_options;
	//reset choices
	$field['choices'] = array( );
	$field['choices'][""] = "Localisation ...";
	if ( isset( $telmarh_options['list_pays'] ) && !empty( $telmarh_options['list_pays'] ) ){
		$localisations = explode( ",", $telmarh_options['list_pays'] );
		foreach ( $localisations as $elt ){
			$field['choices'][sanitize_title( $elt )] = $elt;
		}
	}

	return $field;
}
add_filter('acf/load_field/name=localisation_exp_pgt', 'acf_load_localisation_field_choices');
add_filter('acf/load_field/name=localisation_exp_for', 'acf_load_localisation_field_choices');
add_filter('acf/load_field/name=localisation', 'acf_load_localisation_field_choices');
$obj = pw_new_user_approve();
remove_action( "new_user_approve_approve_user", array($obj, "approve_user" ) );
add_action( "new_user_approve_approve_user", "telmarh_ew_user_approve_approve_user" );
function telmarh_ew_user_approve_approve_user( $user_id ){
	$user = new WP_User( $user_id );
	if ( in_array( $user->roles[0], array( USER_ROLE_CANDIDAT )  ) ){
		update_user_meta( $user->ID, 'pw_user_status', 'approved' );
	} else {
		$objApprove = pw_new_user_approve();
		$objApprove->approve_user( $user_id );
	}

}
function telmarh_remove_page_template() {
    global $pagenow;
    if ( in_array( $pagenow, array( 'post-new.php', 'post.php') ) && get_post_type() == 'page' ) { ?>
        <script type="text/javascript">
            (function(jQuery){
	            jQuery(document).ready(function(){
		            jQuery('#page_template option[value="template-fullwidth.php"]').remove();
		            jQuery('#page_template option[value="template-left-sidebar.php"]').remove();
		            jQuery('#page_template option[value="template-projects.php"]').remove();
		            jQuery('#page_template option[value="template-services.php"]').remove();
		            jQuery('#page_template option[value="template-testimonials.php"]').remove();
                })
            })(jQuery)
        </script>
    <?php
    }
}
add_action('admin_footer', 'telmarh_remove_page_template', 10);

add_filter("new_user_approve_welcome_message", "telmarh_new_user_approve_welcome_message");
function telmarh_new_user_approve_welcome_message( $message ){
    return "Bienvenue chez Portail de recrutement du Groupe AXIAN. Ce site est accessible uniquement aux utilisateurs agréés. Pour être approuvé, vous devez d'abord vous enregistrer.";
}


