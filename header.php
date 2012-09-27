<?php
	# No direct file load
	if (!empty($_SERVER['SCRIPT_FILENAME']) && realpath($_SERVER['SCRIPT_FILENAME']) === realpath(__FILE__)) { die(); }

	global $cur_weather_condition;

	$body_classes = (isset($body_classes)? $body_classes : '') . 'weather-' . $cur_weather_condition;

	$articles_active = ( is_home() || (is_single() && !in_category('31')) || (is_archive() && !is_category('31')) );
	$notes_active = ( is_category('31') || (is_single() && in_category('31')) );
	$auteurs_active = is_page('auteurs');
?>
<!doctype html>
<html <?php language_attributes(); ?>>
	<head>
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
		<title><?php wp_title('·', true, 'right'); ?> <?php bloginfo('name'); ?></title>
		<link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/images/favicon.ico" />
		<link rel="icon" type="image/x-icon" href="<?php bloginfo('template_url'); ?>/images/favicon.ico" />
		<link rel="icon" type="image/png" href="<?php bloginfo('template_url'); ?>/images/favicon.png" />
		<link rel="apple-touch-icon" href="<?php bloginfo('template_url'); ?>/images/apple-touch-icon.png"/>
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
		<!--[if !IE 6]><!--><link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="all" /><!--<![endif]-->
		<!--[if IE 6]><link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/styles/ie6-universal.0.3.css" media="all" /><![endif]-->
		<?php if ( is_single() ) : ?><link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/styles/sh-min.css" media="all" /><?php endif; ?>
		<?php wp_enqueue_script( 'main', '/wp-content/themes/lesintegristes/scripts/main-min.js', array('jquery'), '1.0', true ); ?>
		<?php if ( is_single() ) wp_enqueue_script( 'single', '/wp-content/themes/lesintegristes/scripts/single-min.js', array('jquery'), '1.0', true ); ?>
		<?php wp_head(); ?>
		<!--[if IE]>
		<script src="<?php bloginfo('template_url'); ?>/scripts/html5.js"></script>
		<![endif]-->
		<script type="text/javascript">
			jQuery.lesintegristes = {
				themeUrl: "<?php bloginfo('template_url'); ?>"
			};
		</script>
	</head>
	<body <?php body_class($body_classes); ?>>
	<script type="text/javascript">document.body.className += " js"</script>
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