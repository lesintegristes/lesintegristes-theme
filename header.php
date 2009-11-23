<?php
	global $cur_meteo_condition;
	if ($cur_meteo_condition !== "") {
		$body_classes .= "meteo-" . $cur_meteo_condition;
	}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
	<head>
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
		<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
		<!--[if !IE 6]><!--><link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="all" /><!--<![endif]-->
		<!--[if IE 6]><link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/styles/ie6-universal.0.3.css" media="all" /><![endif]-->
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
			<div>
				<h1><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
				<nav role="navigation">
					<ul>
						<li><a href="<?php echo lesintegristes_get_articles_url() ?>"><span>Articles</span></a></li>
						<li><a href="<?php bloginfo('url'); ?>/categorie/notes/"><span>Notes</span></a></li>
						<li><a href="<?php bloginfo('url'); ?>/auteurs/"><span>Auteurs</span></a></li>
					</ul>
				</nav>
				<p><a rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss_url'); ?>">RSS</a></p>
			</div>
		</header>