<?php

add_filter('preview_post_link', 'custom_preview_link', 10, 2);

function custom_preview_link($preview_link, $post) {
  $custom_link = '/preview/' . $post->post_name;
  return $custom_link;
}
