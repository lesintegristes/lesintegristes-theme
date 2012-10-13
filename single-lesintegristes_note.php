<?php
# No direct file load
if (!empty($_SERVER['SCRIPT_FILENAME']) && realpath($_SERVER['SCRIPT_FILENAME']) === realpath(__FILE__)) { die(); }

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
				<div class="infos">
					<time title="Le <?php the_time('j F Y'); ?> à <?php the_time('H\hi'); ?>" class="date" datetime="<?php the_time('c'); ?>">
					<svg width="24" height="24" viewBox="-12.5 -12 24 24">
						<circle cx="0" cy="0" r="10" stroke="#b7b2ac" fill="white" stroke-width="3"  />
						<rect x="-1"  y="-7" width="2" height="2" fill="#b7b2ac" />
						<rect x="-1"  y="-7" width="2" height="2" fill="#b7b2ac" transform="rotate(90)" />
						<rect x="-1"  y="-7" width="2" height="2" fill="#b7b2ac" transform="rotate(180)" />
						<rect x="-1"  y="-7" width="2" height="2" fill="#b7b2ac" transform="rotate(270)" />
						<line id="hours"   stroke="#b7b2ac" stroke-width="2" stroke-linecap="round" x1="0" x2="0" y1="0" y2="-5" transform="rotate(<?php echo get_the_time('g') * 30 ?>)" />
						<line id="minutes" stroke="#b7b2ac" stroke-width="2" stroke-linecap="round" x1="0" x2="0" y1="0" y2="-7" transform="rotate(<?php echo get_the_time('i') * 6 ?>)" />
					</svg>
					<?php the_time('j M') ?><br> <?php the_time('Y'); ?></time>
				</div>
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