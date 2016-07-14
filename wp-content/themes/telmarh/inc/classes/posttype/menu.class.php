<?php

/**
 * Qui recupere les menu dans le BO
 * Class CMenu
 */
class CMenu
{
	public function __construct(){

	}

	public static function getMenuhierarchy( $menuName )
	{
		$hierarchy = array();
		$hierarchyPostId = array();
		if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[$menuName] ) ) {
			$menu = wp_get_nav_menu_object( $locations[$menuName] );
			$menu_items = wp_get_nav_menu_items( $menu->term_id );
			foreach ( $menu_items as $key => $menu_item ) {
				if ( $menu_item->menu_item_parent == 0 ) {
					$hierarchy[0][] = array(
						'id'      => $menu_item->ID,
						'url'     => $menu_item->url,
						'title'   => $menu_item->title,
						'slug'    => sanitize_title( $menu_item->title ),
						'post_id' => $menu_item->object_id,
						'type'    => $menu_item->type,
					);
					$hierarchyPostId[0][] = $menu_item->object_id;
				}
			}
			if ( isset( $hierarchy[0] ) && !empty( $hierarchy[0] ) ){
				foreach ( $hierarchy[0] as $key => $parent ) {
					foreach ( $menu_items as $menu_list ) {
						if ( $parent['id'] == $menu_list->menu_item_parent ) {
							$hierarchy[$parent['id']][0][] = array(
								'id'      => $menu_list->ID,
								'url'     => $menu_list->url,
								'title'   => $menu_list->title,
								'slug'    => $parent['slug'],
								'post_id' => $menu_list->object_id,
							);
							$hierarchyPostId[$parent['post_id']][0][] = $menu_list->object_id;
						}
					}
					if ( isset( $hierarchy[$parent['id']][0] ) && !empty( $hierarchy[$parent['id']][0] ) ){
						foreach ( $hierarchy[$parent['id']][0] as $key => $elementParent ){
							foreach ( $menu_items as $menu_list ){
								if ( $elementParent['id'] == $menu_list->menu_item_parent ) {
									$hierarchy[$parent['id']][$elementParent['id']][] = array(
										'id'      => $menu_list->ID,
										'url'     => $menu_list->url,
										'title'   => $menu_list->title,
										'slug'    => $parent['slug'],
										'post_id' => $menu_list->object_id,
								);
								$hierarchyPostId[$parent['post_id']][$elementParent['post_id']][] = $menu_list->object_id;
								}
							}
						}
					}
				}
			}

		}
		return array("data" => $hierarchy, "post_id" => $hierarchyPostId);
	}

	public static function renderMenuFooter() {
		global $telmarh_options;
		$html = '';
		$html .= '<ul class="menu-footer clearfix">';
		$menuFooterElement = self::getMenuhierarchy( SLUG_MENU_FOOTER );
		$menuFooter = ( isset( $menuFooterElement['data'] ) && !empty( $menuFooterElement['data'] ) ) ? $menuFooterElement['data'] : array();
		$menuCount = count($menuFooter[0]) + 2;
		if ( !empty( $telmarh_options['facebook'] ) || !empty( $telmarh_options['google'] ) || !empty( $telmarh_options['linkedin'] ) || !empty( $telmarh_options['instagramm'] ) || !empty( $telmarh_options['twitter'] )  ){
			$html .= '<li class="col-1-' . $menuCount . '">';
			$html .= '<a href="javascript:;" title="Suivez-nous">Suivez-nous</a>';
			$arrayKeyRs = array( 'facebook', 'google', 'linkedin', 'instagramm', 'twitter' );
			$html .= '<ul class="social-media-icons footer">';
			foreach ( $arrayKeyRs as $key ){
				if ( isset( $telmarh_options[$key] ) && !empty( $telmarh_options[$key] ) ){
					$html .= '	<li class="test">
	                                <a href="' . $telmarh_options[$key] . '" target="_blank">
	                                    <i class="fa fa-' . $key . '"></i>
	                                </a>
                            	</li>';
				}
			}
			$html .= '</ul>';
		}
		if ( isset( $menuFooter[0] ) && !empty( $menuFooter[0] ) && count( $menuFooter[0] ) > 0 ){
			//parcourir le parent
			foreach ( $menuFooter[0] as $parent ) {
				$html .= '<li class="col-1-' . $menuCount . '">';
				$html .= '<a href="' . get_permalink( $parent['url'] ) . '" >' . $parent['title'] . '</a>' ;
				if ( isset( $menuFooter[$parent['id']][0] ) && !empty( $menuFooter[$parent['id']][0] ) ){
					//menu child
					$html .= '<ul>';
					foreach ( $menuFooter[$parent['id']][0] as $child ){
						$html .= '<li>';
						$html .= '<a href="' . $child['url'] . '">' . $child['title'] . '</a>' ;
						//menu third niveau
						if ( isset( $menuFooter[$parent['id']][$child['id']] ) && !empty( $menuFooter[$parent['id']][$child['id']] ) ){
							$html .= '<ul>';
							foreach ( $menuFooter[$parent['id']][$child['id']] as $thirdChild ) {
								$html .= '<li>';
								$html .= '<a href="' . $thirdChild['url'] . '">' . $thirdChild['title'] . '</a>';
								$html .= '</li>';
							}
							$html .= '</ul>';
						}
						$html .= '</li>';
					}
					$html .= '</ul>';
				}
				$html .= '</li>';
			}
		}
		if ( isset( $telmarh_options['description_footer'] ) && !empty( $telmarh_options['description_footer'] ) ) {
			$html .= '<li class="col-1-' . $menuCount . '">';
			$html .= '<a href="javascript:;" title="Suivez-nous">Suivez-nous</a>';
			$html .= '  <div class="site-info">
  							' . apply_filters("the_content", $telmarh_options['description_footer']) . '
  							<p class="contact">
  							    <a href="#" class="submit_link button--wapasha button--round-l " title="Nous contacter">
                                    Nous contacter
                                </a>
  							</p>
  						</div>';
			$html .= '</li>';
		}
		$html .= '</ul>';
		return $html;
	}
}



