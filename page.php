<?php
/**
 * @package WordPress
 * @subpackage Starkers
 */

get_header(); ?>

<div id="content" role="main">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
			<h1><?php the_title(); ?></h1>
			<?php the_content('<p>Read the rest of this page &raquo;</p>'); ?>
			<?php wp_link_pages(array('before' => '<p>Pages: ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
		</div>
		<?php endwhile; endif; ?>
	<?php edit_post_link('Modifier cette page.', '<p>', '</p>'); ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>