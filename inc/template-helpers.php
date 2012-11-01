<?php

# No direct file load
if (!defined('ABSPATH')) return;

/* Template helper: RSS link */
function lesintegristes_get_feed_link($url, $text, $title_attr = true) {
  $title_attribute = ($title_attr)? ' title="'. $text .'"' : '';
  return '<a href="'. $url .'"'.$title_attribute.' rel="alternate" type="application/rss+xml">'. $text .'</a>';
}

/* Remove <img> and <figure> */
function lesintegristes_remove_img_and_figure($content) {
  $content = apply_filters('the_content', $content);
  $content = preg_replace('@<p class="wp-caption-text">.*?</p>@si', '', $content);
  $content = preg_replace('/<img[^>]+./','', $content);
  return $content;
}

/* "Articles" URL */
function lesintegristes_get_articles_url() {
  return get_bloginfo('wpurl') . '/articles/';
}

/* "Notes" URL */
function lesintegristes_get_notes_url() {
  return get_bloginfo('wpurl') . '/notes/';
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

function lesintegristes_get_custom_field($name, $metas, $prefix = 'lesintegristes-') {
  if (!empty($metas[$prefix.$name]) && $metas[$prefix.$name][0] != '') {
    return $metas[$prefix.$name][0];
  } else {
    return NULL;
  }
}

/* Get published authors ordered by last post date */
function lesintegristes_authors_ordered_by_last_post() {
  global $wpdb;

  $blog_authors_all = get_users('fields=all');
  $blog_authors = array();
  $author_last_post_sql = "SELECT post_date FROM {$wpdb->posts} WHERE post_author = %d AND (post_type = 'post' OR post_type = 'lesintegristes_note') AND post_status = 'publish' ORDER BY post_date DESC LIMIT 1";

  // Published authors only
  foreach ($blog_authors_all as $author) {

    $last_post = $wpdb->get_row($wpdb->prepare($author_last_post_sql, array($author->ID)), OBJECT);

    if ($last_post) {
      $metas = get_user_meta($author->ID);

      // li_ = "les integristes" prefix
      $author->li_twitter = lesintegristes_get_custom_field('twitter', $metas);
      $author->li_first_name = lesintegristes_get_custom_field('first_name', $metas, '');
      $author->li_description = lesintegristes_get_custom_field('description', $metas, '');
      $author->li_description_by = lesintegristes_get_custom_field('description_by', $metas);
      $author->li_profession = lesintegristes_get_custom_field('profession', $metas);
      $author->li_last_post_date = $last_post->post_date;

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

/* Get current page number */
function lesintegristes_get_current_page_number() {
  return (get_query_var('paged')) ? get_query_var('paged') : 1;
}

/* Build a custom page title */
function lesintegristes_page_title($page_title) {
  if(is_paged()) {
    $paged = lesintegristes_get_current_page_number();
    return "$page_title (page $paged)";
  }
  return $page_title;
}