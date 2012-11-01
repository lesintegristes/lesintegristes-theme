<?php

# No direct file load
if (!defined('ABSPATH')) return;

/* Change CSS location */
function lesintegristes_style_replace($buffer) {
  // LESINTEGRISTES_CSS_URL is a production setting (should be defined in wp-config.php)
  $css_url = (defined('LESINTEGRISTES_CSS_URL'))? LESINTEGRISTES_CSS_URL : get_template_directory_uri().'/styles/main.css';
  return str_replace(
    '<link rel="stylesheet" href="'.get_template_directory_uri().'/style.css" />',
    '<link rel="stylesheet" href="'.$css_url.'" />',
    $buffer
  );
}
function lesintegristes_style_replace_buffer() {
  ob_start('lesintegristes_style_replace');
}
add_action('template_redirect', 'lesintegristes_style_replace_buffer'); // Replaces style.css with styles/main.css

/* Scripts and styles */
add_action('wp_enqueue_scripts', function() {
  $js_prefix = get_bloginfo('template_url').'/scripts/';
  $css_prefix = get_bloginfo('template_url').'/styles/';
  $js_suffix = WP_DEBUG? '.js' : '-min.js';
  $jquery_suffix = WP_DEBUG? '.js' : '.min.js';

  // Main script
  if (WP_DEBUG) { // Script added to main-min.js (see Makefile)
    wp_enqueue_script('jquery.cookies', $js_prefix.'jquery.cookies.2.2.0'.$js_suffix, array('jquery'), '2.2', TRUE);
  }
  wp_enqueue_script('main', $js_prefix.'main'.$js_suffix, array('jquery'), '1.1', TRUE);

  // Single script
  if (is_single()) {
    if (WP_DEBUG) {
      // JS added to single-min.js (see Makefile)
      wp_enqueue_script('prism', $js_prefix.'prism.js', array(), '1', TRUE);
    }
    wp_enqueue_style('prism', $css_prefix.'prism.css', array(), '1');
    wp_enqueue_script('single', $js_prefix.'single'.$js_suffix, array('jquery'), '1.0', TRUE);
  }

  // Google AJAX API
  wp_deregister_script('jquery');
  wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js', array(), '1.8', TRUE);
  wp_enqueue_script('jquery');
});