<?php
# No direct file load
if (!empty($_SERVER['SCRIPT_FILENAME']) && realpath($_SERVER['SCRIPT_FILENAME']) === realpath(__FILE__)) { die(); }

/*if ( function_exists('register_sidebar') ) {
  register_sidebar(array(
    'before_widget' => '<li id="%1$s" class="widget %2$s">',
    'after_widget' => '</li>',
    'before_title' => '<h2 class="widgettitle">',
    'after_title' => '</h2>',
  ));
}*/

/* Change CSS location */
function lesintegristes_style_replace($buffer) {
  // LESINTEGRISTES_CSS_URL is a production setting (should be defined in wp-config.php)
  $css_url = (defined('LESINTEGRISTES_CSS_URL'))? LESINTEGRISTES_CSS_URL : get_template_directory_uri().'/styles/main.css';
  return str_replace(
    '<link rel="stylesheet" href="'.get_template_directory_uri().'/style.css" type="text/css" media="all" />',
    '<link rel="stylesheet" href="'.$css_url.'" type="text/css" media="all" />',
    $buffer
  );
}
function lesintegristes_style_replace_buffer() {
  ob_start('lesintegristes_style_replace');
}
add_action('template_redirect', 'lesintegristes_style_replace_buffer'); // Replaces style.css with styles/main.css

/* Google Ajax API */
function add_google_ajax_api() {
  if (!is_admin()) {
    wp_deregister_script('jquery');
    wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js', false, '1.4');
    wp_enqueue_script('jquery');
  }
}
add_action('init', 'add_google_ajax_api');

/* RSS */
function rss_head_links() {
  echo '<link rel="alternate" type="application/rss+xml" title="Les intégristes &raquo; Flux principal du blog" href="'. get_bloginfo('rss2_url') .'" />'."\n";
  echo '<link rel="alternate" type="application/rss+xml" title="Les intégristes &raquo; Flux des articles uniquement" href="'. get_bloginfo("wpurl") .'/articles/feed/" />'."\n";
  echo '<link rel="alternate" type="application/rss+xml" title="Les intégristes &raquo; Flux de tous les commentaires" href="'. get_bloginfo("wpurl") .'/comments/feed/" />'."\n";
}
add_action("wp_head", "rss_head_links");

/* Articles RSS */
function create_articles_feed() {
  load_template( TEMPLATEPATH . '/feed-articles.php');
}
add_action('do_feed_articles', 'create_articles_feed', 10, 1);

function articles_feed_rewrite($rules) {
  return array(
    'articles/feed'=> 'index.php?feed=articles'
  ) + $rules;
}
add_filter('rewrite_rules_array','articles_feed_rewrite');

function lesintegristes_get_feed_link($url, $text, $title_attr = true) {
  $title_attribute = ($title_attr)? ' title="'. $text .'"' : '';
  return '<a href="'. $url .'"'.$title_attribute.' rel="alternate" type="application/rss+xml">'. $text .'</a>';
}

/* HTML tags allowed for comments */
global $allowedtags;
$allowedtags["pre"] = array();
unset($allowedtags["del"]);
unset($allowedtags["strike"]);
unset($allowedtags["i"]);
unset($allowedtags["b"]);
unset($allowedtags["acronym"]);

/* Init weather */
$GLOBALS["cur_weather_condition"] = "";
function lesintegristes_weather_init() {

  if (!is_admin()) {

    global $cur_weather_condition;

    $weather_conditions = array("cloudy", "rain", "snow", "sunny", "night");

    if ( isset($_POST["change_weather"]) && in_array($_POST["change_weather"], $weather_conditions) ) {
      $cur_weather_condition = $_POST["change_weather"];
      setcookie("weather", $cur_weather_condition, time() + 86400, "/");

    } elseif ( isset($_COOKIE['weather']) && in_array($_COOKIE['weather'], $weather_conditions) ) {
      $cur_weather_condition = $_COOKIE['weather'];

    } else {
      $cur_weather_condition = "sunny";
      //setcookie("weather", $cur_weather_condition, time() + 86400, "/");
    }
  }
}
add_action("init", "lesintegristes_weather_init");

/* Remove <img> and <figure> */
function lesintegristes_remove_img_and_figure($content) {
  $content = apply_filters('the_content', $content);
  $content = preg_replace('@<p class="wp-caption-text">.*?</p>@si', '', $content);
  $content = preg_replace('/<img[^>]+./','', $content);
  return $content;
}

/* "Articles" URL */
function lesintegristes_get_articles_url() {
  return get_bloginfo("wpurl") . '/articles/';
}

function lesintegristes_strip_tags_content($text, $tags = '', $invert = FALSE) {

  preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
  $tags = array_unique($tags[1]);

  if(is_array($tags) AND count($tags) > 0) {
    if($invert == FALSE) {
      return preg_replace('@<(?!(?:'. implode('|', $tags) .')\b)(\w+)\b.*?>.*?</\1>@si', '', $text);
    }
    else {
      return preg_replace('@<('. implode('|', $tags) .')\b.*?>.*?</\1>@si', '', $text);
    }
  }
  elseif($invert == FALSE) {
    return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
  }
  return $text;
}

/* Exclude "Notes" in search  */
function lesintegristes_notes_filter($query) {
  if ( $query->is_search ) {
    $query->set('cat','-31');
  }
  return $query;
}
add_filter('pre_get_posts','lesintegristes_notes_filter');


/* Archives nav */
$notes_term_taxonomy_id = "36";
$archives_years_query = NULL;
$archives_months_query = array();

function get_lesintegristes_archives_years_query() {
  global $wpdb, $notes_term_taxonomy_id, $archives_years_query;

  if (!$archives_years_query) {
    $archives_years_query = $wpdb->get_col("SELECT DISTINCT YEAR(wposts.post_date) FROM $wpdb->posts wposts INNER JOIN $wpdb->term_relationships wcategory ON wposts.ID = wcategory.object_id WHERE wposts.post_status = 'publish' AND wposts.post_type = 'post' AND wcategory.term_taxonomy_id != '".$notes_term_taxonomy_id."' ORDER BY wposts.post_date DESC");
  }

  return $archives_years_query;
}
function get_lesintegristes_archives_months_query($year) {
  global $wpdb, $notes_term_taxonomy_id, $archives_months_query;

  if (!isset($archives_months_query[$year])) {
    $archives_months_query[$year] = $wpdb->get_col("SELECT DISTINCT MONTH(wposts.post_date) FROM $wpdb->posts wposts INNER JOIN $wpdb->term_relationships wcategory ON wposts.ID = wcategory.object_id WHERE wposts.post_status = 'publish' AND wposts.post_type = 'post' AND YEAR(wposts.post_date) = '".$year."' AND wcategory.term_taxonomy_id != '".$notes_term_taxonomy_id."' ORDER BY wposts.post_date DESC");
  }

  return $archives_months_query[$year];
}

/* Get an attribute if true */
function getAttributeIfTrue($condition, $attribute = 'class', $value = 'active') {
  if ($condition) {
    return ' '. $attribute .'="'. $value .'"';
  } else {
    return '';
  }
}

/* Get author link (with some options) */
function lesintegristes_get_author_link($author_id, $opts = array()) {

  if (!isset($opts["before"])) $opts["before"] = "";
  if (!isset($opts["after"]))  $opts["after"] = "";

  $author = get_userdata($author_id);

  return '<a href="'. get_bloginfo('url') .'/author/'. $author->user_nicename .'/" title="Articles par '.$author->display_name.'">'. $opts["before"]  . $author->display_name . $opts["after"] . '</a>';
}

// Feedburner counter in the Dashboard
function lesintegristes_dashboard_feedburner() {
  echo '<p>Blog : <a href="http://feeds.feedburner.com/lesintegristes"><img src="http://feeds.feedburner.com/~fc/lesintegristes?bg=F9F9F9&amp;fg=333333&amp;anim=0" height="26" width="88" style="border:0;vertical-align:middle;" alt="" /></a></p>';
  echo '<p>Veille : <a href="http://feeds.feedburner.com/lesintegristes/veille"><img src="http://feeds.feedburner.com/~fc/lesintegristes/veille?bg=F9F9F9&amp;fg=333333&amp;anim=0" height="26" width="88" style="border:0;vertical-align:middle;" alt="" /></a></p>';
}

// Dashboard widgets
function lesintegristes_dashboard_widgets() {
  wp_add_dashboard_widget('lesintegristes_dashboard_feedburner', 'Statistiques Feedburner', 'lesintegristes_dashboard_feedburner');
}
add_action('wp_dashboard_setup', 'lesintegristes_dashboard_widgets' );