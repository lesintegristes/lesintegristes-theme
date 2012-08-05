<?php
/*
Template Name: Home
*/

# No direct file load
if (!empty($_SERVER['SCRIPT_FILENAME']) && realpath($_SERVER['SCRIPT_FILENAME']) === realpath(__FILE__)) { die(); }

get_header(); ?>

<div id="content" role="main">
<?php query_posts("cat=-31"); ?>
<?php if (have_posts()) : ?>
	
	<h1>Derniers articles</h1>
	
	<?php
		$posts_num = 0;
		global $more;
		$more = 0;
		while (have_posts() && $posts_num < 7) :
		the_post();
		
		if ($posts_num < 4):
		?>
		
		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<header>
				<h1><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h1>
				<p class="date"><time datetime="<?php the_time('c'); ?>"><span class="day"><?php the_time('j') ?></span> <?php the_time('M y'); ?></time></p>
				<p class="author"><?php echo lesintegristes_get_author_link(get_the_author_meta('ID'), array("before" => "Par <strong>", "after" => "</strong>")) ?></p>
				<?php edit_post_link('Modifier', '<p>', '</p>'); ?>
			</header>
			<div class="content">
				<?php echo lesintegristes_remove_img_and_figure(get_the_content("")); ?>
			</div>
			<footer>
				<p class="read-post"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">Lire la suite</a></p>
				<p class="comments-count"><?php comments_popup_link('<strong><span>0</span></strong> <span>commentaires</span>', '<strong><span>1</span></strong> <span>commentaire</span>', '<strong><span>%</span></strong> <span>commentaires</span>'); ?></p>
			</footer>
		</article>
		
	<?php else: ?>
		<?php if ($posts_num === 4): ?>
	<ul class="last-articles">
		<?php endif; ?>
		<li>
			<dl>
				<dt><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></dt>
				<dd class="date"><time datetime="<?php the_time('c'); ?>"><span class="day"><?php the_time('j') ?></span> <?php the_time('M y'); ?></time></dd>
				<dd class="comments-count"><a href="<?php the_permalink() ?>#comments" title="<?php comments_number('0 commentaires', '1 commentaire', '% commentaires'); ?>"><strong><span><?php comments_number('0', '1', '%'); ?></span></strong></a></dd>
				<dd class="author"><?php echo lesintegristes_get_author_link(get_the_author_meta('ID'), array("before" => "Par <strong>", "after" => "</strong>")) ?></dd>
			</dl>
		</li>
	<?php
		endif;
		$posts_num++;
		endwhile; ?>
		<li class="all"><a href="<?php echo lesintegristes_get_articles_url() ?>">Tous les articles</a></li>
	</ul>
	
<?php else : ?>

	<h2>Not Found</h2>
	<p>Sorry, but you are looking for something that isn't here.</p>
	<?php get_search_form(); ?>

<?php endif; ?>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>