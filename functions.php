<?php

automatic_feed_links();

if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>',
	));
}

/* Init meteo */
$GLOBALS["cur_meteo_condition"] = "";

function lesintegristes_meteo_init() {
	
	if (!is_admin()) {
		
		global $cur_meteo_condition;
		
		$meteo_conditions = array("cloudy", "rain", "snow", "sunny", "night");
		
		$body_classes = "";
		
		if ( isset($_POST["change_meteo"]) && in_array($_POST["change_meteo"], $meteo_conditions) ) {
			$cur_meteo_condition = $_POST["change_meteo"];
			setcookie("meteo", $cur_meteo_condition, time() + 86400, "/");
			
		} elseif ( isset($_COOKIE['meteo']) && in_array($_COOKIE['meteo'], $meteo_conditions) ) {
			$cur_meteo_condition = $_COOKIE['meteo'];
		}
	}
}
add_action("init", "lesintegristes_meteo_init");

function lesintegristes_remove_img_and_figure($content) {
	$content = preg_replace('@<figure[^>]*?>.*?</figure>@si', '', $content);
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

function lesintegristes_search_filter($query) {
	if ($query->is_search) { 
		$query->set('cat','-31');
	}
	return $query; 
}
add_filter('pre_get_posts','lesintegristes_search_filter');

function getAttributeIfTrue($condition, $attribute = 'class', $value = 'active') {
	
	if ($condition) {
		return ' '. $attribute .'="'. $value .'"';
	} else {
		return '';
	}
}

?>