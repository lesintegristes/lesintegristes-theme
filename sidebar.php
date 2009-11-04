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
			
			<section class="text titled notes">
				<h1>Notes</h1>
				<ul>
					<?php
						rewind_posts();
						query_posts("cat=31");
					?>
					<?php while (have_posts()) : the_post(); ?>
					<li>
						<p class="date"><time datetime="<?php the_time('c'); ?>"><?php the_time('j/m') ?></time></p>
						<div class="content">
							<?php the_content(""); ?>
						</div>
					</li>
					<?php endwhile; ?>
				</ul>
				<p><a href="<?php echo bloginfo('url'); ?>/category/note" title="Les notes">Toutes les notes</a></p>
			</section>
			
			<section class="text titled newsletter">
				<h1>Newsletter</h1>
				<form action="http://feedburner.google.com/fb/a/mailverify" method="get">
					<p><label for="email">Suivez les intégristes depuis votre boîte mail, en entrant votre adresse email ci-dessous.</label> <input type="text" name="email" value="" id="email" /></p>
					<p class="submit">
						<input type="hidden" name="uri" value="lesintegristes" />
						<input type="hidden" name="loc" value="fr_FR" />
						<button type="submit" id="searchsubmit"><span><span>S'inscrire</span></span></button>
					</p>
				</form>
			</section>
			
			<section class="text creativecommons">
				<h1><a href="http://creativecommons.org/licenses/by-nc-sa/2.0/fr/"><img src="<?php bloginfo('template_url'); ?>/images/creative-commons.png" width="81" height="96" alt="Creative Commons" /></a></h1>
				<p>Sauf mention contraire, les publications de ce site sont mises à disposition sous un <a href="http://creativecommons.org/licenses/by-nc-sa/2.0/fr/">contrat Creative Commons <abbr title="Paternité">BY</abbr> <abbr title="Pas d'utilisation commerciale">NC</abbr> <abbr title="Partage des conditions à l'identique">SA</abbr></a>.</p>
			</section>
			
			<section class="titled text meteo">
				<h1>Météo</h1>
				<p>Pour faire la pluie et le beau temps.</p>
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
			
			<!--<ul>
				<li><h2>Archives</h2>
					<ul>
					<?php wp_get_archives('type=monthly'); ?>
					</ul>
				</li>
			</ul>-->
			
			
			
		</aside>