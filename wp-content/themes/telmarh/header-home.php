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
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">

	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'telmarh' ); ?></a>

	<header id="masthead" class="site-header-home" role="banner">
    	<div class="grid grid-pad header-overflow">
        
		<div class="site-branding">
        	<div>
        
			<?php if ( get_theme_mod( 'telmarh_logo' ) ) : ?>
            
    				<div class="site-title">
       					<a href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'>
                        
                        	<img src='<?php echo esc_url( get_theme_mod( 'telmarh_logo' ) ); ?>'
                             
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
                        </h1><!-- .site-title -->
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
        	</div><!-- navigation-container -->
            
        </div>
	</header><!-- #masthead -->
    
    <?php if ( get_theme_mod('telmarh_sticky_active') != 1 ) { ?>
    
    	<header id="masthead" class="site-header banner--clone" role="banner">
    		<div class="grid grid-pad header-overflow">
				<div class="site-branding">
        			<div>
            
					<?php if ( get_theme_mod( 'telmarh_logo_page' ) ) : ?>
    				
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
                            </h1><!-- .site-title --> 
    					</hgroup>
                        
					<?php endif; ?>
            
            		</div>
				</div><!-- .site-branding -->
        
        
				<div class="navigation-container">
					<nav id="site-navigation" class="main-navigation" role="navigation">
						<button class="toggle-menu menu-right push-body"><?php echo esc_html( get_theme_mod( 'telmarh_menu_name', __( 'Menu', 'telmarh' )  )); ?></button>
						<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
					</nav><!-- #site-navigation -->
        		</div><!-- navigation-container -->
        
        	</div>
		</header><!-- #masthead -->
    
    <?php } ?>
    
    <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right">
        <h3><i class="fa fa-close"></i> <?php _e( 'Close', 'telmarh' ); ?> <?php echo esc_html( get_theme_mod( 'telmarh_menu_name', __( 'Menu', 'telmarh' )  )); ?></h3>
        <?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?> 
	</nav><!-- cbp-spmenu -->
	<?php $error = ( isset( $_POST['errors'] ) && !empty( $_POST['errors'] ) ) ? $_POST['errors'] : "";?>
	<div id="login-user" class="login" <?php if ( !empty($error) ) :?>style="display: block;"<?php endif;?>>
		<?php   if ( !is_user_logged_in() ) :?>
					<div class="inset">
						<?php include("tpl/connexion.tpl.php");?>
					</div>
		<?php   endif;?>
	</div>

	<div id="content" class="site-content">
