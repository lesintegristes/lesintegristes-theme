<?php
/*
Template Name: Auteurs
*/

# No direct file load
if (!empty($_SERVER['SCRIPT_FILENAME']) && realpath($_SERVER['SCRIPT_FILENAME']) === realpath(__FILE__)) { die(); }

require_once ABSPATH . 'wp-admin/includes/plugin.php';

if (function_exists('wpcf7_enqueue_styles')) {
	wpcf7_enqueue_styles();
}
get_header();
?>

<div id="content" role="main" class="page-auteurs">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<h1><?php the_title(); ?></h1>
		
		<?php
		$blog_authors = lesintegristes_authors_ordered_by_last_post();
		foreach ($blog_authors as $author): ?>
		<section class="author">
			<header>
				<h1><?php echo $author->display_name ?></h1>
				<?php if ($author->li_profession): ?>
				<h2><?php echo $author->li_profession ?></h2>
				<?php endif ?>
			</header>
			<div class="content">
				<p class="photo">
					<?php echo get_avatar($author->user_email, $size = '110'); ?>
				</p>
				<?php if ($author->li_description): ?>
				<p>
					<?php echo $author->li_description ?>
				</p>
				<?php endif ?>
				
				<ul class="links">
					<?php if ($author->user_url): ?>
					<li class="home"><a href="<?php echo $author->user_url ?>" class="action"><?php echo $author->li_display_url ?></a></li>
					<?php endif ?>
					<?php if ($author->li_twitter): ?>
						<li class="twitter"><a href="https://twitter.com/<?php echo $author->li_twitter ?>" class="action">twitter.com/<?php echo $author->li_twitter ?></a></li>
					<?php endif ?>
				</ul>
				<p class="mail">Contacter <?php echo $author->li_first_name ?> : <a href="mailto:" class="action"><?php echo $author->user_email ?></a></p>
			</div>
		</section>
		<?php endforeach ?>

		<?php if (is_plugin_active('contact-form-7/wp-contact-form-7.php')): ?>
		<p class="invitation"><strong>Les Intégristes est un blog ouvert à tous,<br /> n’hésitez pas à nous contacter<br /> pour participer à sa rédaction. :)</strong></p>
		<section class="contact">
			<h1>Contactez-nous&nbsp;!</h1>
			<?php the_content(); ?>
		</section>
		<script type="text/javascript">jQuery("section.contact span.wpcf7-not-valid-tip-no-ajax").closest("p").addClass("error");</script>
		<?php endif; ?>
	<?php endwhile; endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>