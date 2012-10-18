<?php
# No direct file load
if (!defined('ABSPATH')) return;

get_header(); ?>
<div id="content" role="main" class="note">
	<p><a href="<?php bloginfo('url'); ?>/categorie/notes/" class="action">Toutes les notes</a></p>
	<p class="pagination">
		<span class="previous"><?php previous_post_link('%link', 'Note précédente', TRUE); ?></span>
		<span class="next"><?php next_post_link('%link', 'Note suivante', TRUE); ?></span>
	</p>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<header>
				<p class="date"><time datetime="<?php the_time('c'); ?>"><?php the_time('j/n/y<b\r /> H\hi') ?></time></p>
			</header>
			<div class="content">
				<?php the_content(); ?>
			</div>
			<footer>
				<p>
					Note rédigée par <?php the_author_posts_link() ?>.
					<?php if ( comments_open() && pings_open() ) {
					// Both Comments and Pings are open ?>
					Vous pouvez <a href="#respond">laisser un commentaire</a>, ou <a href="<?php trackback_url(); ?>" rel="trackback">répondre depuis votre site (trackback)</a>.

					<?php } elseif ( !comments_open() && pings_open() ) {
					// Only Pings are Open ?>
					Les commentaires sont fermés sur cette note, mais vous pouvez <a href="<?php trackback_url(); ?> " rel="trackback">répondre depuis votre site (trackback)</a>.

					<?php } elseif ( comments_open() && !pings_open() ) {
					// Comments are open, Pings are not ?>
					Vous pouvez <a href="#respond">laisser un commentaire sur cette note</a>.

					<?php } elseif ( !comments_open() && !pings_open() ) {
					// Neither Comments, nor Pings are open ?>
					Les commentaires sont fermés sur cette note.

					<?php } ?>

					<?php edit_post_link('Modifier la note.','','') ?>
				</p>
				<?php the_tags( '<p>Tags : ', ', ', '</p>'); ?>
				<?php //edit_post_link('Modifier','<p>','</p>'); ?>
			</footer>

	<?php comments_template(); ?>
	</article>

	<?php endwhile; else: ?>
		<p>Sorry, no posts matched your criteria.</p>
<?php endif; ?>
	</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>