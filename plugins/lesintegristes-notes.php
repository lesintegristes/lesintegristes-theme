<?php
/*
Plugin Name: Les Intégristes - Notes
Plugin URI: http://
Description: Remplit automatiquement le titre des notes.
Author: Pierre Bertet
Version: 1.0.0
Author URI: http://www.pierrebertet.net
*/

add_action('save_post', 'lesintegristes_notes_title_intercept', 10, 2);

/* Si un post appartient à la catégorie Note, le titre et le slug sont automatiquement remplis. */
function lesintegristes_notes_title_intercept($postID, $post) {
  if (isset($_POST["post_category"]) && in_array("31", $_POST["post_category"]) && !wp_is_post_revision($postID)) {
    $post_excerpt   = mb_substr(strip_tags($post->post_content), 0, 50, 'utf-8');
    $new_post_title = "Note&nbsp;: " . $post_excerpt . "&nbsp;[…]";
    $new_post_name  = sanitize_title($post_excerpt);
    if ( $post->post_title !== $new_post_title && $post->post_name !== $new_post_name ) {
      wp_update_post(array(
        "ID" => $postID,
        "post_title" => $new_post_title,
        "post_name" => $new_post_name
      ));
    }
  }
}