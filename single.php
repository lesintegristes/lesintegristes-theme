<?php
/**
 * @package WordPress
 * @subpackage Starkers
 */

get_header(); ?>

<div id="content" role="main">
	
	<p><a href="link" class="action">Tous les articles</a></p>
	
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<header>
				<h1><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h1>
				<p class="date"><span class="day"><?php the_time('j') ?></span> <?php the_time('M y'); ?></p>
				<p class="author">Par <strong><?php the_author() ?></strong></p>
			</header>
			<div class="content">
				<?php the_content(); ?>
			</div>
			<footer>
				<?php wp_link_pages(array('before' => '<p><strong>Pages&nbsp;:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
				
				<p>
					Cet article a été publié le <?php the_time('l j F Y') ?> à <?php the_time("G\hi") ?>
					dans la catégorie <?php the_category(', ') ?>.
					Vous pouvez suivre les commentaires de cet article en utilisant <?php post_comments_feed_link('le flux RSS dédié'); ?>.
					
					<?php if ( comments_open() && pings_open() ) {
					// Both Comments and Pings are open ?>
					Vous pouvez <a href="#respond">laisser un commentaire sur cet article</a>, ou <a href="<?php trackback_url(); ?>" rel="trackback">répondre depuis votre site (trackback)</a>.
					
					<?php } elseif ( !comments_open() && pings_open() ) {
					// Only Pings are Open ?>
					Responses are currently closed, but you can <a href="<?php trackback_url(); ?> " rel="trackback">trackback</a> from your own site.
					
					<?php } elseif ( comments_open() && !pings_open() ) {
					// Comments are open, Pings are not ?>
					You can skip to the end and leave a response. Pinging is currently not allowed.
					
					<?php } elseif ( !comments_open() && !pings_open() ) {
					// Neither Comments, nor Pings are open ?>
					Both comments and pings are currently closed.
					
					<?php } ?>
					
					<?php edit_post_link('Modifier l\'article.','','') ?>
				</p>
				<?php the_tags( '<p>Tags : ', ', ', '</p>'); ?>
				<?php //edit_post_link('Modifier','<p>','</p>'); ?>
			</footer>	
		
		<?php related_posts() ?>
		
	<?php comments_template(); ?>	
			
	</article>
	
	<?php endwhile; else: ?>
		
		<p>Sorry, no posts matched your criteria.</p>
<?php endif; ?>
	</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>