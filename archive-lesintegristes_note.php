<?php
# No direct file load
if (!defined('ABSPATH')) return;

get_header(); ?>
<div id="content" role="main" class="notes">
	<?php if (have_posts()) : ?>

	<h1><?php echo lesintegristes_page_title("Toutes les notes"); ?></h1>
	<p class="rss"><?php echo lesintegristes_get_feed_link(get_category_feed_link($cat, "rss2"), "Flux RSS des notes") ?></p>

		<?php while (have_posts()) : the_post(); ?>
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