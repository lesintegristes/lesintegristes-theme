<?php
/**
 * @package WordPress
 * @subpackage Starkers
 */

get_header(); ?>

<section id="content" role="main">
<?php query_posts("cat=-31"); ?>
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
				<h1><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h1>
				<p class="date"><span class="day"><?php the_time('j') ?></span> <?php the_time('M y'); ?></p>
				<p class="author">Par <strong><?php the_author() ?></strong></p>
			</header>
			<div class="content">
				<?php the_content(""); ?>
			</div>
			<footer>
				<p class="read-post"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">Lire la suite</a></p>
				<p class="comments"><?php comments_popup_link('<strong><span>0</span></strong> <span>commentaires</span>', '<strong><span>1</span></strong> <span>commentaire</span>', '<strong><span>%</span></strong> <span>commentaires</span>'); ?></p>
				<?php //edit_post_link('Modifier', '<p>', '</p>'); ?>
			</footer>
		</article>
		
	<?php else: ?>
		<?php if ($posts_num === 2): ?>
	<ul class="last-articles">
		<?php endif; ?>
		<li>
			<dl>
				<dt><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></dt>
				<dd class="date"><span class="day"><?php the_time('j') ?></span> <?php the_time('M y'); ?></dd>
				<dd class="comments" title="<?php comments_number('0 commentaires', '1 commentaire', '% commentaires'); ?>"><strong><span><?php comments_number('0', '1', '%'); ?></span></strong></dd>
				<dd class="author">Par <strong><?php the_author() ?></strong></dd>
			</dl>
		</li>
	<?php
		endif;
		$posts_num++;
		endwhile; ?>
		<li class="all"><a href="link">Tous les articles</a></li>
	</ul>
	
	<?php /*next_posts_link('&laquo; Older Entries') ?> | <?php previous_posts_link('Newer Entries &raquo;')*/ ?>

<?php else : ?>

	<h2>Not Found</h2>
	<p>Sorry, but you are looking for something that isn't here.</p>
	<?php get_search_form(); ?>

<?php endif; ?>
</section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>