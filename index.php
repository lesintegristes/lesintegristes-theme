<?php
/**
 * @package WordPress
 * @subpackage Starkers
 */

get_header(); ?>

<section id="content" role="main">
<?php if (have_posts()) : ?>
	
	<h1>Derniers articles</h1>
	
	<?php
		$posts_num = 0;
		while (have_posts() && $posts_num < 5) :
		the_post();
		if ($posts_num < 2):
		?>
		
		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<header>
				<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
				<p><?php the_time('F jS, Y') ?> par <?php the_author() ?></p>
			</header>
			<div class="content">
				<?php the_content('Lire la suite de cet article'); ?>
				<p><?php edit_post_link('Edit', '', ' | '); ?>  <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></p>
			</div>
		</article>
		
	<?php
		else:
		?>
		
		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<header>
				<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
				<p><?php the_time('F jS, Y') ?> par <?php the_author() ?></p>
			</header>
			<div class="content">
				<p><?php edit_post_link('Edit', '', ' | '); ?>  <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></p>
			</div>
		</article>
		
	<?php
		endif;
		$posts_num++;
		endwhile; ?>

	<?php next_posts_link('&laquo; Older Entries') ?> | <?php previous_posts_link('Newer Entries &raquo;') ?>

<?php else : ?>

	<h2>Not Found</h2>
	<p>Sorry, but you are looking for something that isn't here.</p>
	<?php get_search_form(); ?>

<?php endif; ?>
</section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>