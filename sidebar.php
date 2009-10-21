<?php
/**
 * @package WordPress
 * @subpackage Starkers
 */
?>
		<aside id="sidebar" role="complementary">
			
			<div class="search">
				<?php get_search_form(); ?>
			</div>
			
			<div class="veille">
				<a href="<?php echo bloginfo('url'); ?>/veille/" title="Veille : Offrez notre sélection d'infos à votre agrégateur !">
					<p><strong>Veille</strong></p>
					<p>Offrez notre sélection d'infos à votre agrégateur !</p>
				</a>
			</div>
			
			<section class="notes">
				<h1>Notes</h1>
				<ul>
					<?php
						rewind_posts();
						query_posts("cat=31");
					?>
					<?php while (have_posts()) : the_post(); ?>
					<li>
						<p class="date"><?php the_time('j/m') ?></p>
						<?php the_content(""); ?>
					</li>
					<?php endwhile; ?>
				</ul>
			</section>
			
			<?php if ( is_404() || is_day() || is_month() ||
						is_year() || is_search() || is_paged() ) {
			?>
			<ul>
				<li>
				
				<?php /* If this is a 404 page */ if (is_404()) { ?>
				
				<?php /* If this is a yearly archive */ } elseif (is_day()) { ?>
				<p>You are currently browsing the <a href="<?php bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> blog archives
				for the day <?php the_time('l, F jS, Y'); ?>.</p>
				
				<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
				<p>You are currently browsing the <a href="<?php bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> blog archives
				for <?php the_time('F, Y'); ?>.</p>
				
				<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
				<p>You are currently browsing the <a href="<?php bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> blog archives
				for the year <?php the_time('Y'); ?>.</p>
				
				<?php /* If this is a monthly archive */ } elseif (is_search()) { ?>
				<p>You have searched the <a href="<?php echo bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> blog archives
				for <strong>'<?php the_search_query(); ?>'</strong>. If you are unable to find anything in these search results, you can try one of these links.</p>
				
				<?php /* If this is a monthly archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
				<p>You are currently browsing the <a href="<?php echo bloginfo('url'); ?>/"><?php echo bloginfo('name'); ?></a> blog archives.</p>
				
				<?php } ?>
				
				</li>
			</ul>	
			<?php }?>
			
			<ul>
				<li><h2>Archives</h2>
					<ul>
					<?php wp_get_archives('type=monthly'); ?>
					</ul>
				</li>
				<?php wp_list_categories('show_count=1&title_li=<h2>Categories</h2>'); ?>
			</ul>
			
			<ul>
				<?php /* If this is the frontpage */ if ( is_home() || is_page() ) { ?>
					<?php wp_list_bookmarks(); ?>
					
					<li>
						<h2>Meta</h2>
						<ul>
							<?php wp_register(); ?>
							<li><?php wp_loginout(); ?></li>
							<li><a href="http://validator.w3.org/check/referer" title="This page validates as XHTML 1.0 Transitional">Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr></a></li>
							<li><a href="http://wordpress.org/" title="Powered by WordPress, state-of-the-art semantic personal publishing platform.">WordPress</a></li>
							<?php wp_meta(); ?>
						</ul>
					</li>
				<?php } ?>

				<?php //endif; ?>
			</ul>
		</aside>