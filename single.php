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
				<?php the_content('<p>Read the rest of this entry &raquo;</p>'); ?>
			</div>
			<footer>
				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
				
				<?php the_tags( '<p>Tags: ', ', ', '</p>'); ?>
				<p class="read-post"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">Lire la suite</a></p>
				<p class="comments"><?php comments_popup_link('<strong><span>0</span></strong> <span>commentaires</span>', '<strong><span>1</span></strong> <span>commentaire</span>', '<strong><span>%</span></strong> <span>commentaires</span>'); ?></p>
				<?php //edit_post_link('Modifier', '<p>', '</p>'); ?>
				<p>
					This entry was posted
					<?php /* This is commented, because it requires a little adjusting sometimes.
					You'll need to download this plugin, and follow the instructions:
					http://binarybonsai.com/wordpress/time-since/ */
					/* $entry_datetime = abs(strtotime($post->post_date) - (60*120)); echo time_since($entry_datetime); echo ' ago'; */ ?>
					on <?php the_time('l, F jS, Y') ?> at <?php the_time() ?>
					and is filed under <?php the_category(', ') ?>.
					You can follow any responses to this entry through the <?php post_comments_feed_link('RSS 2.0'); ?> feed.

					<?php if ( comments_open() && pings_open() ) {
					// Both Comments and Pings are open ?>
					You can <a href="#respond">leave a response</a>, or <a href="<?php trackback_url(); ?>" rel="trackback">trackback</a> from your own site.

					<?php } elseif ( !comments_open() && pings_open() ) {
					// Only Pings are Open ?>
					Responses are currently closed, but you can <a href="<?php trackback_url(); ?> " rel="trackback">trackback</a> from your own site.

					<?php } elseif ( comments_open() && !pings_open() ) {
					// Comments are open, Pings are not ?>
					You can skip to the end and leave a response. Pinging is currently not allowed.

					<?php } elseif ( !comments_open() && !pings_open() ) {
					// Neither Comments, nor Pings are open ?>
					Both comments and pings are currently closed.
					
					<?php } edit_post_link('Edit this entry','','.'); ?>
				</p>
			</footer>	
		</article>
		
	<?php comments_template(); ?>
	
	<?php endwhile; else: ?>
		
		<p>Sorry, no posts matched your criteria.</p>
<?php endif; ?>
	</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>