<?php
/**
 * @package WordPress
 * @subpackage Starkers
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
	<head>
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
		<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
		<?php wp_enqueue_script( 'cookies', '/wp-content/themes/lesintegristes/scripts/jquery.cookies.2.1.0.min.js', array('jquery'), '1.0', true ); ?>
		<?php wp_enqueue_script( 'main', '/wp-content/themes/lesintegristes/scripts/main.js', array('jquery'), '1.0', true ); ?>
		<?php if ( is_home() ) wp_enqueue_script( 'home', '/wp-content/themes/lesintegristes/scripts/home.js', array('jquery'), '1.0', true ); ?>
		<?php if ( is_singular() ) wp_enqueue_script( 'single', '/wp-content/themes/lesintegristes/scripts/single.js', array('jquery'), '1.0', true ); ?>
		<?php wp_head(); ?>
		<!--[if IE]>
		<script src="<?php bloginfo('template_url'); ?>/scripts/html5.js"></script>
		<![endif]-->
	</head>
	<body <?php body_class(); ?>>
	<div>
	<div id="wrapper">
		<header role="banner" id="header">
			<div>
				<h1><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
				<nav role="navigation">
					<ul>
						<li><a href="<?php bloginfo('url'); ?>/articles/"><span>Articles</span></a></li>
						<li><a href="<?php bloginfo('url'); ?>/notes/"><span>Notes</span></a></li>
						<li><a href="<?php bloginfo('url'); ?>/auteurs/"><span>Auteurs</span></a></li>
					</ul>
				</nav>
				<p><a rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss_url'); ?>">RSS</a></p>
			</div>
		</header>