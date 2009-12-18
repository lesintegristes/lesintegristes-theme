<?php
	global $cur_meteo_condition;
	
	$body_classes .= "meteo-" . $cur_meteo_condition;
	
	$articles_active = ( is_home() || (is_single() && !in_category('31')) || (is_archive() && !is_category('31')) );
	$notes_active = ( is_category('31') || (is_single() && in_category('31')) );
	$auteurs_active = is_page('auteurs');
?>
<!doctype html>
<html <?php language_attributes(); ?>>
	<head>
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
		<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
		<link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/images/favicon.ico" />
		<link rel="icon" type="image/x-icon" href="<?php bloginfo('template_url'); ?>/images/favicon.ico" />
		<link rel="icon" type="image/png" href="<?php bloginfo('template_url'); ?>/images/favicon.png" />
		<link rel="apple-touch-icon" href="<?php bloginfo('template_url'); ?>/images/apple-touch-icon.png"/>
		<!--[if !IE 6]><!--><link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="all" /><!--<![endif]-->
		<!--[if IE 6]><link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/styles/ie6-universal.0.3.css" media="all" /><![endif]-->
		<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/styles/syntax-highlighter.css" media="all" />
		<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/styles/sh-lesintegristes.css" media="all" />
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
		<?php wp_enqueue_script( 'cookies', '/wp-content/themes/lesintegristes/scripts/jquery.cookies.2.1.0.min.js', array('jquery'), '1.0', true ); ?>
		<?php wp_enqueue_script( 'main', '/wp-content/themes/lesintegristes/scripts/main.js', array('jquery'), '1.0', true ); ?>
		<?php if ( is_home() ) wp_enqueue_script( 'home', '/wp-content/themes/lesintegristes/scripts/home.js', array('jquery'), '1.0', true ); ?>
		<?php if ( is_singular() ) wp_enqueue_script( 'single', '/wp-content/themes/lesintegristes/scripts/single.js', array('jquery'), '1.0', true ); ?>
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
						<li><a href="<?php bloginfo('url'); ?>/categorie/notes/"<?php echo getAttributeIfTrue($notes_active) ?>><span>Notes</span></a></li>
						<li><a href="<?php bloginfo('url'); ?>/auteurs/"<?php echo getAttributeIfTrue($auteurs_active) ?>><span>Auteurs</span></a></li>
					</ul>
				</nav>
				<p><?php echo lesintegristes_get_feed_link(get_bloginfo('rss2_url'), 'Flux RSS du blog') ?></p>
			</div>
		</header>