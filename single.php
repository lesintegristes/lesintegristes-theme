<?php
# No direct file load
if (!empty($_SERVER['SCRIPT_FILENAME']) && realpath($_SERVER['SCRIPT_FILENAME']) === realpath(__FILE__)) { die(); }

get_header();
?>
<div id="content" role="main">
	
	<p><a href="<?php echo lesintegristes_get_articles_url() ?>" class="action">Tous les articles</a></p>
	
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<header>
				<h1><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h1>
				<div class="infos">
					<time class="date" datetime="<?php the_time('c'); ?>">
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
					<div class="author"><?php echo lesintegristes_get_author_link(get_the_author_meta('ID'), array("before" => "Par<br> ")) ?></div>
				</div>
			</header>
			<div class="content">
				<?php the_content(); ?>
			</div>
			<footer>
				<?php wp_link_pages(array('before' => '<p><strong>Pages&nbsp;:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
				
				<p>
					Article rédigé par <?php the_author_posts_link() ?>, publié le <time datetime="<?php the_time('c'); ?>"><?php echo strtolower(get_the_time('l j F Y')) ?> à <?php the_time("G\hi") ?></time>
					dans la catégorie <?php the_category(', ') ?>.
					Vous pouvez suivre les commentaires de cet article en utilisant <?php post_comments_feed_link('le flux RSS dédié'); ?>.
					
					<?php if ( comments_open() && pings_open() ) {
					// Both Comments and Pings are open ?>
					Vous pouvez <a href="#respond">laisser un commentaire sur cet article</a>, ou <a href="<?php trackback_url(); ?>" rel="trackback">répondre depuis votre site (trackback)</a>.
					
					<?php } elseif ( !comments_open() && pings_open() ) {
					// Only Pings are Open ?>
					Les commentaires sont fermés sur cet article, mais vous pouvez <a href="<?php trackback_url(); ?> " rel="trackback">répondre depuis votre site (trackback)</a>.
					
					<?php } elseif ( comments_open() && !pings_open() ) {
					// Comments are open, Pings are not ?>
					Vous pouvez <a href="#respond">laisser un commentaire sur cet article</a>.
					
					<?php } elseif ( !comments_open() && !pings_open() ) {
					// Neither Comments, nor Pings are open ?>
					Les commentaires sont fermés sur cet article.
					
					<?php } ?>
					
					<?php edit_post_link('Modifier l\'article.','','') ?>
				</p>
				<?php the_tags( '<p>Tags : ', ', ', '</p>'); ?>
				<?php //edit_post_link('Modifier','<p>','</p>'); ?>
			</footer>	
		
		<?php if (function_exists('related_posts')) { related_posts(); } ?>
		
	<?php comments_template(); ?>	
			
	</article>
	
	<?php endwhile; else: ?>
		<p>Sorry, no posts matched your criteria.</p>
<?php endif; ?>
	</div>
	
<?php

get_sidebar();
get_footer();
