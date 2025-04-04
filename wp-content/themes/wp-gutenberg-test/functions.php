<?php
/**
 * wp-gutenberg-test functions and definitions
 *
 * @package wp-gutenberg-test
 */

if ( ! defined( '_S_VERSION' ) ) {
    // Replace the version number of the theme on each release.
    define( '_S_VERSION', '1.0.0' );
}

add_theme_support( 'post-thumbnails' );

// Menus
require get_template_directory() . '/inc/menus.php';

// API functionality
require get_template_directory() . '/inc/api.php';

// Flexible Content Preview
require get_template_directory() . '/inc/flexible-content-preview.php';

// ACF Settings
require get_template_directory() . '/inc/acf-settings.php';
