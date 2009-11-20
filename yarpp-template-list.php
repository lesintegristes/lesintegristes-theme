<?php /*
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
					<dd class="date"><span class="day"><?php the_time('j') ?></span> <?php the_time('M y'); ?></dd>
					<dd class="comments-count" title="<?php comments_number('0 commentaires', '1 commentaire', '% commentaires'); ?>"><strong><span><?php comments_number('0', '1', '%'); ?></span></strong></dd>
					<dd class="author">Par <strong><?php the_author_posts_link() ?></strong></dd>
				</dl>
			</li>
			<?php endwhile; ?>
		</ul>
	</div>
<?php endif; ?>