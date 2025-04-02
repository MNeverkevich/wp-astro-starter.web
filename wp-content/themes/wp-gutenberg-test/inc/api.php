<?php

add_filter('rest_url_prefix', function() {
	return 'wpastroapi';
});

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
		'/wp/v2/home_page',
		'/wp/v2/form',
		'/contact-form-7/v1/contact-forms/',
		'/acf/v3/options',
		'/wp/v2/search',
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

add_action('rest_api_init', function() {
	register_rest_route('wp/v2', '/form/(?P<id>\d+)', [
			'methods'  => 'GET',
			'callback' => 'get_contact_form_html',
	]);
});

function get_contact_form_html($request) {
	$form_id = $request['id'];
	$html = do_shortcode('[contact-form-7 id="' . $form_id . '"]');
	return rest_ensure_response(array(
			'html' => $html
	));
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