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
				<p class="date"><time datetime="<?php the_time('c'); ?>"><span class="day"><?php the_time('j') ?></span> <?php the_time('M y'); ?></time></p>
				<p class="author"><?php echo lesintegristes_get_author_link(get_the_author_meta('ID'), array("before" => "Par <strong>", "after" => "</strong>")) ?></p>
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
