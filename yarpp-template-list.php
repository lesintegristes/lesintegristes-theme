<?php
# No direct file load
if (!empty($_SERVER['SCRIPT_FILENAME']) && realpath($_SERVER['SCRIPT_FILENAME']) === realpath(__FILE__)) { die(); }

/*
List template
This template returns the related posts as a comma-separated list.
Author: mitcho (Michael Yoshitaka Erlewine)
*/
?>
<?php if ($related_query->have_posts()): ?>
	<div class="related-posts">
		<h2>Articles (peut-être) en relation</h2>
		<ul class="last-articles">
		<?php
			$postsArray = array();
			while ($related_query->have_posts()) : $related_query->the_post();
				$postsArray[] = '<a href="'.get_permalink().'" rel="bookmark">'.get_the_title().'</a><!-- ('.get_the_score().')-->';
				?>
			<li>
				<dl>
					<dt><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></dt>
					<dd class="date"><time datetime="<?php the_time('c'); ?>"><span class="day"><?php the_time('j') ?></span> <?php the_time('M y'); ?></time></dd>
					<dd class="comments-count"><a href="<?php the_permalink() ?>#comments" title="<?php comments_number('0 commentaires', '1 commentaire', '% commentaires'); ?>"><strong><span><?php comments_number('0', '1', '%'); ?></span></strong></a></dd>
					<dd class="author"><?php echo lesintegristes_get_author_link(get_the_author_meta('ID'), array("before" => "Par <strong>", "after" => "</strong>")) ?></dd>
				</dl>
			</li>
			<?php endwhile; ?>
		</ul>
	</div>
<?php endif; ?>