<?php
/**
 * @package WordPress
 * @subpackage Starkers
 */

automatic_feed_links();

if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>',
	));
}


function lesintegristes_excerpt_length($length) {
	return 100;
}
add_filter('excerpt_length', 'lesintegristes_excerpt_length');

function lesintegristes_remove_img_and_figure($content) {
	$content = strip_tags_content($content, '<figure>', TRUE);
	$content = preg_replace('/<img[^>]+./','', $content);
	return $content;
}

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
?>