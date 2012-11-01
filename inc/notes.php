<?php

/* Notes custom type */
add_action('init', function(){
  register_post_type('lesintegristes_note',
    array(
      'labels' => array(
        'name' => _x('Notes', 'note type', 'lesintegristes'),
        'singular_name' => _x('Note', 'note type', 'lesintegristes'),
        'add_new' => _x('Add New', 'note type', 'lesintegristes'),
        'add_new_item' => _x('Add a new note', 'note type', 'lesintegristes'),
        'edit_item' => _x('Edit note', 'note type', 'lesintegristes'),
        'new_item' => _x('New Note', 'note type', 'lesintegristes'),
        'view_item' => _x('View Note', 'note type', 'lesintegristes'),
        'search_items' => _x('Search Notes', 'note type', 'lesintegristes'),
        'not_found' => _x('No notes found', 'note type', 'lesintegristes'),
        'not_found_in_trash' => _x('No notes found in Trash', 'note type', 'lesintegristes'),
      ),
      'public' => TRUE,
      'has_archive' => TRUE,
      'exclude_from_search' => TRUE,
      'menu_position' => 5,
      'supports' => array('editor', 'author', 'trackbacks', 'comments', 'revisions'),
      'rewrite' => array('slug' => 'notes'),
    )
  );
});

/* Auto post title */
add_action('save_post', function($postID, $post) {
  if (isset($_POST['post_type']) && $_POST['post_type'] == 'lesintegristes_note' && !wp_is_post_revision($postID)) {
    $post_excerpt   = mb_substr(strip_tags($post->post_content), 0, 50, 'utf-8');
    $new_post_title = "Note&nbsp;: " . $post_excerpt . "&nbsp;[…]";
    $new_post_name  = sanitize_title($post_excerpt);
    if ( $post->post_title !== $new_post_title || $post->post_name !== $new_post_name ) {
      wp_update_post(array(
        "ID" => $postID,
        "post_title" => $new_post_title,
        "post_name" => $new_post_name
      ));
    }
  }
}, 10, 2);
