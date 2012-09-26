<?php
# No direct file load
if (!empty($_SERVER['SCRIPT_FILENAME']) && realpath($_SERVER['SCRIPT_FILENAME']) === realpath(__FILE__)) { die(); }

/* i18n */
add_action('after_setup_theme', function(){
  load_theme_textdomain('lesintegristes', get_template_directory().'/languages');
});

/* Notes */
require_once get_template_directory().'/lib/notes.php';

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

/* Feedburner counter in the Dashboard */
function lesintegristes_dashboard_feedburner() {
  echo '<p>Blog : <a href="http://feeds.feedburner.com/lesintegristes"><img src="http://feeds.feedburner.com/~fc/lesintegristes?bg=F9F9F9&amp;fg=333333&amp;anim=0" height="26" width="88" style="border:0;vertical-align:middle;" alt="" /></a></p>';
  echo '<p>Veille : <a href="http://feeds.feedburner.com/lesintegristes/veille"><img src="http://feeds.feedburner.com/~fc/lesintegristes/veille?bg=F9F9F9&amp;fg=333333&amp;anim=0" height="26" width="88" style="border:0;vertical-align:middle;" alt="" /></a></p>';
}

/* Dashboard widgets */
function lesintegristes_dashboard_widgets() {
  wp_add_dashboard_widget('lesintegristes_dashboard_feedburner', 'Statistiques Feedburner', 'lesintegristes_dashboard_feedburner');
}
add_action('wp_dashboard_setup', 'lesintegristes_dashboard_widgets' );

/* User profile: additional fields */
$lesintegristes_additional_fields = array(
  'description_by' => array(
    'name' => 'Description par',
    'help' => 'Auteur de votre description / bio',
    'placeholder' => 'Éric Le Bihan'
  ),
  'profession' => array(
    'name' => 'Profession',
    'help' => 'Votre profession',
    'placeholder' => 'Front-end Developer'
  ),
  'twitter' => array(
    'name' => 'Twitter',
    'help' => 'Votre compte Twitter, sans @',
    'placeholder' => 'lesintegristes'
  ),
);

function lesintegristes_add_profile_fields($user) {
  global $lesintegristes_additional_fields;
  echo <<<EOD
<h3>Champs additionnels</h3>
<table class="form-table">
EOD;

  foreach ($lesintegristes_additional_fields as $field_id => $field) {
    $value_attr = esc_attr(get_the_author_meta('lesintegristes-'.$field_id, $user->ID));
    echo <<<EOD
	<tr>
		<th>
			<label for="lesintegristes-{$field['name']}">{$field['name']}</label>
		</th>
		<td>
		<input type="text" placeholder="{$field['placeholder']}" name="lesintegristes-{$field_id}" id="lesintegristes-{$field_id}" value="{$value_attr}" class="regular-text lesintegristes-text" /><br />
			<span class="description">{$field['help']}</span>
		</td>
	</tr>
EOD;
  }
  echo <<<EOD
</table>
<style>
	.lesintegristes-text::-webkit-input-placeholder{color:#999;font-style:italic;}
	.lesintegristes-text:-moz-placeholder{color:#999;font-style:italic;}
 </style>
EOD;
}

function lesintegristes_save_profile_fields($user_id) {
  global $lesintegristes_additional_fields;
  if (!current_user_can('edit_user', $user_id)) {
    return FALSE;
  }
  foreach ($lesintegristes_additional_fields as $field_id => $field) {
    update_user_meta($user_id, 'lesintegristes-'.$field_id, $_POST['lesintegristes-'.$field_id]);
  }
}
add_action('show_user_profile', 'lesintegristes_add_profile_fields');
add_action('edit_user_profile', 'lesintegristes_add_profile_fields');
add_action('personal_options_update', 'lesintegristes_save_profile_fields');
add_action('edit_user_profile_update', 'lesintegristes_save_profile_fields');

function lesintegristes_get_custom_field($name, $metas, $prefix = 'lesintegristes-') {
  if (!empty($metas[$prefix.$name]) && $metas[$prefix.$name][0] != '') {
    return $metas[$prefix.$name][0];
  } else {
    return NULL;
  }
}

/* Get published authors ordered by last post date */
function lesintegristes_authors_ordered_by_last_post() {
  $blog_authors_all = get_users('fields=all');
  $blog_authors = array();

  // Published authors only
  foreach ($blog_authors_all as $author) {
    $author->posts_count = count_user_posts($author->ID);

    if ($author->posts_count) {
      $metas = get_user_meta($author->ID);
      $last_post = get_posts('showposts=1&author='.$author->ID);

      // li_ = "les integristes" prefix
      $author->li_twitter = lesintegristes_get_custom_field('twitter', $metas);
      $author->li_first_name = lesintegristes_get_custom_field('first_name', $metas, '');
      $author->li_description = lesintegristes_get_custom_field('description', $metas, '');
      $author->li_description_by = lesintegristes_get_custom_field('description_by', $metas);
      $author->li_profession = lesintegristes_get_custom_field('profession', $metas);
      $author->li_last_post_date = $last_post[0]->post_date;

      // http://example.com => example.com
      $author->li_display_url = str_replace(parse_url($author->user_url, PHP_URL_SCHEME) . '://', '', $author->user_url);

      $blog_authors[] = $author;
    }
  }

  // Order by last post date
  usort($blog_authors, function($a, $b){
    if ($a->li_last_post_date == $b->li_last_post_date) {
      return 0;
    }
    return ($a->li_last_post_date > $b->li_last_post_date)? -1 : 1;
  });

  return $blog_authors;
}