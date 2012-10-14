<?php
# No direct file load
if (!defined('WP_USE_THEMES')) return;

get_header(); ?>
<div id="content" role="main">
<?php
		query_posts("post_type=post&paged=$paged");
		if (have_posts()) :
?>
	<h1><?php echo lesintegristes_page_title("Tous les articles"); ?></h1>
	<p class="rss"><?php echo lesintegristes_get_feed_link( get_bloginfo("wpurl").'/articles/feed/', 'Flux RSS des articles') ?></p>

	<?php
		global $more;
		$more = 0;
		while (have_posts()) : the_post(); ?>
		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<header>
				<h1><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h1>
				<p class="date"><time datetime="<?php the_time('c'); ?>"><span class="day"><?php the_time('j') ?></span> <?php the_time('M y'); ?></time></p>
				<p class="author"><?php echo lesintegristes_get_author_link(get_the_author_meta('ID'), array("before" => "Par <strong>", "after" => "</strong>")) ?></p>
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
			$next_page_exists = (get_next_posts_link() !== NULL);
			$prev_page_exists = (get_previous_posts_link() !== NULL);
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