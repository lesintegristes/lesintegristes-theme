<?php
# No direct file load
if (!defined('ABSPATH')) return;

get_header(); ?>
<div id="content" role="main">
	<?php if (have_posts()) : ?>

	<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
	<?php /* If this is a category archive */ if (is_category()) { ?>
	<h1>Articles de la catégorie «&nbsp;<?php single_cat_title(); ?>&nbsp;»</h1>
	<p class="rss"><?php echo lesintegristes_get_feed_link(get_category_feed_link($cat, "rss2"), "Flux RSS de la catégorie «&nbsp;". single_cat_title("", false) ."&nbsp;»"); ?></p>
	<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
	<h1>Articles tagués «&nbsp;<?php single_tag_title(); ?>&nbsp;»</h1>
	<p class="rss"><?php echo lesintegristes_get_feed_link(get_tag_feed_link($tag_id), "Flux RSS du tag «&nbsp;". single_tag_title("", false) ."&nbsp;»"); ?></p>
	<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
	<h1>Articles du <?php the_time('F jS, Y'); ?></h1>
	<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>

	<?php
		if (in_array(get_the_time("n"), array("4", "8", "10"))) {
			$month_prefix = "d’";
		} else {
			$month_prefix = "de ";
		} ?>
	<h1>Articles du mois <?php echo $month_prefix ?><?php the_time('F Y'); ?></h1>

	<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
	<h1>Articles de l'année <?php the_time('Y'); ?></h1>
	<?php /* If this is an author archive */ } elseif (is_author()) { ?>
	<h1>Articles publiés par <?php echo get_userdata($author)->display_name ?></h1>
	<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
	<h1>Archives</h1>
	<?php } ?>

		<?php while (have_posts()) : the_post(); ?>
			<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
				<header>
					<h1><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h1>
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
						<div class="author"><?php echo lesintegristes_get_author_link(get_the_author_meta('ID'), array("before" => "Par<br> ")) ?></div>
					</div>
					<?php edit_post_link('Modifier', '<p>', '</p>'); ?>
				</header>
				<div class="content">
					<?php the_excerpt(); ?>
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

	<?php else :

		if ( is_category() ) { // If this is a category archive
			printf("<h2>Désolé, aucun article n'a encore été publié dans la catégorie «&nbsp;%s&nbsp;».</h2>", single_cat_title('',false));
		} else if ( is_date() ) { // If this is a date archive
			echo("<h2>Désolé, aucun article n'a été publié à cette date.</h2>");
		} else if ( is_author() ) { // If this is a category archive
			$userdata = get_userdatabylogin(get_query_var('author_name'));
			printf("<h2>Désolé, %s n'a pas encore publié d'articles.</h2>", $userdata->display_name);
		} else {
			echo("<h2>Pas d'articles trouvés.</h2>");
		}

	endif;
?>
	</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>