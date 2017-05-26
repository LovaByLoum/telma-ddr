<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package telmarh
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/custom-styles.css" type="text/css">
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'telmarh' ); ?></a>
    <header id="header" role="banner">
        <div class="nav-left">
            <button class="bt-toggle" data-toggle="open" aria-controls="header" aria-expanded="false"></button>
            <a href="<?php echo site_url(); ?>" class="logo" title="Axian"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.svg" alt="Axian - Let's grow together"></a>
            <nav class="navigation  nav-close">
                <div class="nav-td">
                    <?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
                </div>
            </nav>
        </div>
        <div class="nav-right">
            <a href="#" title="Se connecter" class="btn-login"><i class="fa fa-sign-in"></i> Se connecter</a>
            <div id="login-user" class="login  nav-close" <?php if ( !empty($error) ) :?>style="display: block;"<?php endif;?>>
                <?php 	if ( !is_user_logged_in() ) :?>
                    <div class="inset">
                        <?php include("tpl/connexion.tpl.php");?>
                    </div>
                <?php   endif;?>
            </div>
        </div>
    </header>

	<div id="content" class="site-content">
