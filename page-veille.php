<?php
/*
Template Name: Veille
*/

# No direct file load
if (!empty($_SERVER['SCRIPT_FILENAME']) && realpath($_SERVER['SCRIPT_FILENAME']) === realpath(__FILE__)) { die(); }

get_header(); ?>

<div id="content" role="main">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<h1><?php the_title(); ?></h1>

		<?php
		$page_content = get_the_content();

		preg_match_all('/\[rss:(\S+)\]/', $page_content, $matches, PREG_SET_ORDER);

		$feed_url = NULL;
		if (count($matches) && count($matches[0] === 2)) {
			$feed_url = $matches[0][1];
			$page_content = str_replace('[rss:'.$feed_url.']', '', $page_content);
		}
		echo $page_content;
		?>

		<?php
		if ($feed_url):

		require_once (ABSPATH . WPINC . '/feed.php');

		$rss = fetch_feed($feed_url);
		if (!is_wp_error($rss)) {
			$maxitems = $rss->get_item_quantity(15);
			$rss_items = $rss->get_items(0, $maxitems);
		}
		?>

		<ul>
			<?php if ($maxitems == 0): ?>
			<li><div>Erreur : aucun lien n’a été trouvé.</div></li>
<?php else: foreach ( $rss_items as $item ): ?>
			<li>
				<div>
					<p>
						<a href="<?php echo esc_url($item->get_permalink()); ?>">
							<?php echo trim(esc_html($item->get_title())); ?>

						</a>
					</p>
					<div>
						<p>
							<?php
							$item_content = html_entity_decode(strip_tags($item->get_description()), ENT_COMPAT, 'UTF-8');
							$shorten_item_content = mb_substr($item_content, 0, 150);
							echo trim($shorten_item_content);
							if (strlen($item_content) !== strlen($shorten_item_content)) {
								echo ' […]';
							}
							?>

						</p>
					</div>
				</div>
			</li>
<?php endforeach; endif; ?>
		</ul>
		<?php endif; ?>

		<?php endwhile; endif; ?>

	<?php edit_post_link('Modifier cette page', '<p>', '</p>'); ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>