<?php
# No direct file load
if (!defined('WP_USE_THEMES')) return;

get_header(); ?>
<div id="content" role="main" class="notes">
	<?php if (have_posts()) : ?>

	<h1><?php echo lesintegristes_page_title("Toutes les notes"); ?></h1>
	<p class="rss"><?php echo lesintegristes_get_feed_link(get_category_feed_link($cat, "rss2"), "Flux RSS des notes") ?></p>

		<?php while (have_posts()) : the_post(); ?>
			<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
				<header>
					<p class="date"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><time datetime="<?php the_time('c'); ?>"><?php the_time('j/n/y<b\r /> H\hi') ?></time></a></p>
					<?php edit_post_link('Modifier', '<p>', '</p>'); ?>
				</header>
				<div class="content">
					<?php echo get_the_content(); ?>
				</div>
				<footer>
					<p>
						<span class="author">Par <?php the_author_posts_link() ?></span>,
						<?php comments_popup_link('0 commentaires', '1 commentaire', '% commentaires'); ?>,
						<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">Lien permanent</a>
					</p>
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
				<span class="older action"><?php next_posts_link('Notes plus anciennes') ?></span>
			<?php endif; ?>
			<?php if ($prev_page_exists): ?>
				<span class="newer action"><?php previous_posts_link('Notes plus récentes') ?></span>
			<?php endif; ?>
		</p>
		<?php endif; ?>

	<?php else : ?>
		<h2>Désolé, aucune note n'a encore été publiée.</h2>
	<?php endif; ?>
	</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>