<?php

# No direct file load
if (!defined('ABSPATH')) return;

/* i18n */
add_action('after_setup_theme', function(){
  load_theme_textdomain('lesintegristes', get_template_directory().'/languages');
});

/* RSS */
add_action('wp_head', function() {
  echo '<link rel="alternate" type="application/rss+xml" title="Les intégristes &raquo; Flux principal du blog" href="'. get_bloginfo('rss2_url') .'" />'."\n";
  echo '<link rel="alternate" type="application/rss+xml" title="Les intégristes &raquo; Flux des articles uniquement" href="'. get_bloginfo("wpurl") .'/articles/feed/" />'."\n";
  echo '<link rel="alternate" type="application/rss+xml" title="Les intégristes &raquo; Flux de tous les commentaires" href="'. get_bloginfo("wpurl") .'/comments/feed/" />'."\n";
});

/* Main RSS: articles + notes */
add_filter('request', function($qv) {
  if (isset($qv['feed']) && !isset($qv['post_type'])) {
    $qv['post_type'] = array('lesintegristes_note', 'post');
  }
  return $qv;
});

/* Articles-only RSS */
add_filter('rewrite_rules_array', function($rules) use($wp_rewrite) {
  $new_rules = array('^articles/feed\/?$' => 'index.php?feed=rss2&post_type=post');
  return $new_rules + $rules;
});

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

// Filter the page's title, add page's number if paged
function lesintegristes_filter_wp_title($title, $sep, $seplocation) {
  if(is_paged()) {
    $paged = lesintegristes_get_current_page_number();
    $title = str_replace($sep, '', $title);
    return "$title (page $paged) $sep " . get_bloginfo('name');
  }
  return $title . get_bloginfo('name');
}
add_filter('wp_title', 'lesintegristes_filter_wp_title', 10, 3);