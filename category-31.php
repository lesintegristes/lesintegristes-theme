<?php
/**
 * @package WordPress
 * @subpackage Starkers
 */

get_header(); ?>
<div id="content" role="main" class="notes">
	
	<?php if (have_posts()) : ?>
	
	<h1>Toutes les notes</h1>
		
		<?php while (have_posts()) : the_post(); ?>
			<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
				<header>
					<p class="date"><?php the_time('j/n/y<b\r /> H\hi') ?></p>
					<?php //edit_post_link('Modifier', '<p>', '</p>'); ?>
				</header>
				<div class="content">
					<?php echo get_the_content(); ?>
				</div>
				<footer>
					<p>
						<span class="author">Par <a href="link"><?php the_author() ?></a></span>,
						<?php comments_popup_link('0 commentaires', '1 commentaire', '% commentaires'); ?>,
						<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">Lien permanent</a></p>
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
		
	<?php else :

		if ( is_category() ) { // If this is a category archive
			printf("<h2>Sorry, but there aren't any posts in the %s category yet.</h2>", single_cat_title('',false));
		} else if ( is_date() ) { // If this is a date archive
			echo("<h2>Sorry, but there aren't any posts with this date.</h2>");
		} else if ( is_author() ) { // If this is a category archive
			$userdata = get_userdatabylogin(get_query_var('author_name'));
			printf("<h2>Sorry, but there aren't any posts by %s yet.</h2>", $userdata->display_name);
		} else {
			echo("<h2>No posts found.</h2>");
		}
		get_search_form();

	endif;
?>
	</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>