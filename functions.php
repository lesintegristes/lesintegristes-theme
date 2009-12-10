<?php

/*if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>',
	));
}*/

/* RSS */
function rss_head_links() {
	echo '<link rel="alternate" type="application/rss+xml" title="Les intégristes" href="'. get_bloginfo('rss2_url') .'" />'."\n";
	echo '<link rel="alternate" type="application/rss+xml" title="Les intégristes &raquo; Flux des articles uniquement" href="'. get_bloginfo("wpurl") .'/articles/feed/" />'."\n";
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

/* Init meteo */
$GLOBALS["cur_meteo_condition"] = "";
function lesintegristes_meteo_init() {
	
	if (!is_admin()) {
		
		global $cur_meteo_condition;
		
		$meteo_conditions = array("cloudy", "rain", "snow", "sunny", "night");
		
		if ( isset($_POST["change_meteo"]) && in_array($_POST["change_meteo"], $meteo_conditions) ) {
			$cur_meteo_condition = $_POST["change_meteo"];
			setcookie("meteo", $cur_meteo_condition, time() + 86400, "/");
			
		} elseif ( isset($_COOKIE['meteo']) && in_array($_COOKIE['meteo'], $meteo_conditions) ) {
			$cur_meteo_condition = $_COOKIE['meteo'];
			
		} else {
			$cur_meteo_condition = "sunny";
			setcookie("meteo", $cur_meteo_condition, time() + 86400, "/");
		}
	}
}
add_action("init", "lesintegristes_meteo_init");

/* Remove <img> and <figure> */
function lesintegristes_remove_img_and_figure($content) {
	$content = preg_replace('@<figure[^>]*?>.*?</figure>@si', '', $content);
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
	if ( $query->is_search || is_archive() ) { 
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
	
	if (!$archives_months_query[$year]) {
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

?>