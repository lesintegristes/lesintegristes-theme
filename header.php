<?php
	# No direct file load
	if (!defined('ABSPATH')) return;

	global $cur_weather_condition;

	$body_classes = (isset($body_classes)? $body_classes : '') . 'weather-' . $cur_weather_condition;

	$articles_active = ( is_home() || (is_single() && !is_singular('lesintegristes_note')) || (is_archive() && !is_post_type_archive('lesintegristes_note')) );
	$notes_active = ( is_post_type_archive('lesintegristes_note') || is_singular('lesintegristes_note') );
	$auteurs_active = is_page('auteurs');
	if(is_paged()) { $paged = lesintegristes_get_current_page_number(); }
?>
<!doctype html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo('charset'); ?>" />
		<title><?php wp_title('·', true, 'right'); bloginfo('name'); ?></title>
		<link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/images/favicon.ico" />
		<link rel="icon" type="image/x-icon" href="<?php bloginfo('template_url'); ?>/images/favicon.ico" />
		<link rel="icon" type="image/png" href="<?php bloginfo('template_url'); ?>/images/favicon.png" />
		<link rel="apple-touch-icon" href="<?php bloginfo('template_url'); ?>/images/apple-touch-icon.png"/>
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" />
		<?php wp_head(); ?>
	</head>
	<body <?php body_class($body_classes); ?>>
	<script>document.body.className += ' js'</script>
	<div>
	<div id="wrapper">
		<header role="banner" id="header">
			<p class="shortcuts">
				<a href="#content">Accéder au contenu</a>
				<a href="#searchform">Accéder à la recherche</a>
			</p>
			<div>
				<h1><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
				<nav role="navigation">
					<ul>
						<li><a href="<?php echo lesintegristes_get_articles_url() ?>"<?php echo getAttributeIfTrue($articles_active) ?>><span>Articles</span></a></li>
						<li><a href="<?php echo lesintegristes_get_notes_url() ?>"<?php echo getAttributeIfTrue($notes_active) ?>><span>Notes</span></a></li>
						<li><a href="<?php bloginfo('url'); ?>/auteurs/"<?php echo getAttributeIfTrue($auteurs_active) ?>><span>Auteurs</span></a></li>
					</ul>
				</nav>
				<p><?php echo lesintegristes_get_feed_link(get_bloginfo('rss2_url'), 'Flux RSS du blog') ?></p>
			</div>
		</header>
