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
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'telmarh' ), max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'telmarh' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
    	<div class="grid grid-pad header-overflow">
			<div class="site-branding">
        		<div>
            
				<?php if ( get_theme_mod( 'telmarh_logo_page' ) ) :?>
    				
                    <div class="site-title">
                    
       					<a href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'>
                        	<img src='<?php echo esc_url( get_theme_mod( 'telmarh_logo_page' ) ); ?>'
							
								<?php if ( get_theme_mod( 'logo_size' ) ) : ?>
                            	
                                	width="<?php echo esc_attr( get_theme_mod( 'logo_size', __( '165', 'telmarh' ) )); ?>"
								
								<?php endif; ?> 
                                
                                alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
                        </a>
                        
    				</div><!-- site-logo -->
                    
				<?php else : ?>
                
    				<hgroup>
       					<h1 class='site-title'>
                        	<a href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'><?php bloginfo( 'name' ); ?></a>
                        </h1> 
    				</hgroup>
                    
				<?php endif; ?>
            
            	</div> 
			</div><!-- .site-branding -->
        
        
			<div class="navigation-container">
				<nav id="site-navigation" class="main-navigation" role="navigation">
            		<button class="toggle-menu menu-right push-body">
						<?php echo esc_html( get_theme_mod( 'telmarh_menu_name', __( 'Menu', 'telmarh' )  )); ?>
                	</button>
					<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
				</nav><!-- #site-navigation -->
        	</div>
            
        </div>
	</header><!-- #masthead -->
    
    <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right">
        <h3><i class="fa fa-close"></i> <?php _e( 'Close', 'telmarh' ); ?> <?php echo esc_html( get_theme_mod( 'telmarh_menu_name', __( 'Menu', 'telmarh' )  )); ?></h3>
        <?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
	</nav>

	<div id="content" class="site-content">
