<?php

function register_custom_menus() {
  register_nav_menus(
    array(
      'footer-menu' => __( 'Footer Menu' ),
    )
  );
}

add_action( 'init', 'register_custom_menus' );

function get_primary_menu() {
	$menu_id = 3; // Primary menu ID

	if (!$menu_id) {
			return new WP_Error('no_menu', 'Primary menu not found', array('status' => 404));
	}

	$menu_items = wp_get_nav_menu_items($menu_id);
	return rest_ensure_response($menu_items);
}

function get_footer_menu() {
	$menu_id = 4; // Footer menu ID

	if (!$menu_id) {
			return new WP_Error('no_menu', 'Footer menu not found', array('status' => 404));
	}

	$menu_items = wp_get_nav_menu_items($menu_id);
	return rest_ensure_response($menu_items);
}