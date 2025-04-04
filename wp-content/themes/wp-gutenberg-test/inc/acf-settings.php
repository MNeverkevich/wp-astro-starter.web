<?php

function acf_json_save_point( $path ) {
  return get_stylesheet_directory() . '/acf-json';
}
add_filter( 'acf/settings/save_json', 'acf_json_save_point' );
