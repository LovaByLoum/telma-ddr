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
		return array("data" => $hierarchy, "post_id" => $hierarchyPostId);
	}

	public static function renderMenuFooter() {
		$html = '';
		$menuFooterElement = self::getMenuhierarchy( SLUG_MENU_FOOTER );
		$menuFooter = ( isset( $menuFooterElement['data'] ) && !empty( $menuFooterElement['data'] ) ) ? $menuFooterElement['data'] : array();
		if ( isset( $menuFooter[0] ) && !empty( $menuFooter[0] ) && count( $menuFooter[0] ) > 0 ){
			//parcourir le parent
			$html .= '<ul class="menu-footer clearfix">';
			foreach ( $menuFooter[0] as $parent ) {
				$html .= '<li class="col-1-3">';
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
			$html .= '</ul>';
		}
		return $html;
	}
}



