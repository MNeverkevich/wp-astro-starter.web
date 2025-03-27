<?php
/**
 * wp-gutenberg-test functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package wp-gutenberg-test
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Implement the Custom Preview for Flexible Content.
 */
require get_template_directory() . '/inc/flexible-content-preview.php';

add_theme_support( 'post-thumbnails' );

function register_custom_menus() {
  register_nav_menus(
    array(
      'footer-menu' => __( 'Footer Menu' ),
    )
  );
}

add_filter('rest_url_prefix', function() {
	return 'wpastroapi';
});

add_action( 'init', 'register_custom_menus' );

function restrict_wp_frontend() {
	if (!is_admin() && !is_user_logged_in()) {
			wp_die('Assess Denied', 'Assess Denied', ['response' => 403]);
	}
}
add_action('template_redirect', 'restrict_wp_frontend');

add_filter('rest_endpoints', function ($endpoints) {
	if (is_user_logged_in()) {
		return $endpoints;
	}

	$allowed_routes = [
		'/wp/v2/posts',
		'/wp/v2/pages',
		'/wp/v2/media',
		'/wp/v2/menus',
		'/wp/v2/categories',
		'/wp/v2/users',
		'/wp/v2/home_page'
	];

	foreach ($endpoints as $route => $details) {
		$is_allowed = false;
		foreach ($allowed_routes as $allowed) {
			if (strpos($route, $allowed) === 0) {
				$is_allowed = true;
				break;
			}
		}
		if (!$is_allowed) {
			unset($endpoints[$route]);
		}
	}

	return $endpoints;
});

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

add_action('rest_api_init', function () {
	register_rest_route('wp/v2/menus', '/primary-menu', array(
			'methods' => 'GET',
			'callback' => 'get_primary_menu',
			'permission_callback' => '__return_true'
	));

	register_rest_route('wp/v2/menus', '/footer-menu', array(
			'methods' => 'GET',
			'callback' => 'get_footer_menu',
			'permission_callback' => '__return_true'
	));
});


add_action('rest_api_init', function () {
	register_rest_route('wp/v2/', '/home_page', array(
		'methods'  => 'GET',
		'callback' => function () {
			$home_page_id = get_option('page_on_front');

			if (!$home_page_id) {
				return new WP_Error('no_home_page', 'The home page is not installed', array('status' => 404));
			}

			$home_page = get_post($home_page_id);

			if (!$home_page) {
				return new WP_Error('invalid_page', 'Page not found', array('status' => 404));
			}

			return [
				'id'    => $home_page->ID,
				'slug'  => $home_page->post_name,
				'title' => get_the_title($home_page_id),
				'url'   => get_permalink($home_page_id)
			];
		},
	));
});
