<?php
/**
 * @package WordPress
 * @subpackage Starkers
 */

get_header(); ?>
<div id="content" role="main">
<?php
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		query_posts("cat=-31&paged=$paged");
		if (have_posts()) :
?>
	<h1>Tous les articles</h1>
	
	<?php
		global $more;
		$more = 0;
		while (have_posts()) : the_post(); ?>
		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<header>
				<h1><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h1>
				<p class="date"><span class="day"><?php the_time('j') ?></span> <?php the_time('M y'); ?></p>
				<p class="author">Par <strong><?php the_author() ?></strong></p>
				<?php edit_post_link('Modifier', '<p>', '</p>'); ?>
			</header>
			<div class="content">
				<?php echo get_the_excerpt(); ?>
			</div>
			<footer>
				<p class="read-post"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">Lire la suite</a></p>
				<p class="comments-count"><?php comments_popup_link('<strong><span>0</span></strong> <span>commentaires</span>', '<strong><span>1</span></strong> <span>commentaire</span>', '<strong><span>%</span></strong> <span>commentaires</span>'); ?></p>
			</footer>
		</article>
		<?php endwhile; ?>
		
		<?php
			$next_page_exists = (get_next_posts_link('Articles plus anciens') !== NULL);
			$prev_page_exists = (get_previous_posts_link('Articles plus récents') !== NULL);
		?>
		<?php if ($next_page_exists || $prev_page_exists): ?>
		<p class="pagination">
			<?php if ($next_page_exists): ?>
				<span class="older action"><?php next_posts_link('Articles plus anciens') ?></span>
			<?php endif; ?>
			<?php if ($prev_page_exists): ?>
				<span class="newer action"><?php previous_posts_link('Articles plus récents') ?></span>
			<?php endif; ?>
		</p>
		<?php endif; ?>
		
<?php else : ?>
	
	<h2>Not Found</h2>
	<p>Sorry, but you are looking for something that isn't here.</p>
	<?php get_search_form(); ?>
	
<?php endif; ?>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>