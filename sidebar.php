		<aside id="sidebar" role="complementary">
		
		<!--[if !IE 6]><!-->
		<section class="titled text meteo">
			<h1>Météo</h1>
			<p>Faites la pluie et le beau temps.</p>
			<?php global $cur_meteo_condition; ?>
			<form action="" method="post">
				<p><input name="change_meteo" type="radio" value="sunny" id="meteo-sunny"<?php echo getAttributeIfTrue( ($cur_meteo_condition === "sunny"), "checked", "checked") ?> /> <label for="meteo-sunny"<?php echo getAttributeIfTrue(($cur_meteo_condition === "sunny")) ?>>Soleil</label></p>
				<p><input name="change_meteo" type="radio" value="cloudy" id="meteo-cloudy"<?php echo getAttributeIfTrue( ($cur_meteo_condition === "cloudy"), "checked", "checked") ?> /> <label for="meteo-cloudy"<?php echo getAttributeIfTrue(($cur_meteo_condition === "cloudy")) ?>>Nuageux</label></p>
				<p><input name="change_meteo" type="radio" value="rain" id="meteo-rain"<?php echo getAttributeIfTrue( ($cur_meteo_condition === "rain"), "checked", "checked") ?> /> <label for="meteo-rain"<?php echo getAttributeIfTrue(($cur_meteo_condition === "rain")) ?>>Pluie</label></p>
				<p><input name="change_meteo" type="radio" value="snow" id="meteo-snow"<?php echo getAttributeIfTrue( ($cur_meteo_condition === "snow"), "checked", "checked") ?> /> <label for="meteo-snow"<?php echo getAttributeIfTrue(($cur_meteo_condition === "snow")) ?>>Neige</label></p>
				<p><input name="change_meteo" type="radio" value="night" id="meteo-night"<?php echo getAttributeIfTrue( ($cur_meteo_condition === "night"), "checked", "checked") ?> /> <label for="meteo-night"<?php echo getAttributeIfTrue(($cur_meteo_condition === "night")) ?>>Nuit</label></p>
				<p class="submit"><button type="submit"><span><span>Changer la météo</span></span></button></p>
				<p>(Sélection valable 24h.)</p>
			</form>
		</section>
		<!--<![endif]-->
			
			<div class="search">
				<?php get_search_form(); ?>
			</div>
			
			<?php if (!is_page('veille')): ?>
			<div class="veille">
				<a href="<?php echo bloginfo('url'); ?>/veille/" title="Veille : Offrez notre sélection d'infos à votre agrégateur !">
					<p><strong>Veille</strong></p>
					<p>Offrez notre sélection d'infos à votre agrégateur !</p>
				</a>
			</div>
			<?php endif; ?>
			
			<?php
				/* Articles */
				if ( is_category('31') || is_page('veille') || (is_single() && in_category('31')) ): ?>
			<section class="text titled articles">
				<h1>Derniers articles</h1>
				<ul>
					<?php
						rewind_posts();
						query_posts("cat=-31&posts_per_page=5");
					?>
					<?php while (have_posts()) : the_post(); ?>
					<li>
						<p class="date"><time datetime="<?php the_time('c'); ?>"><span class="day"><?php the_time('j') ?></span> <?php the_time('M y'); ?></time></p>
						<p class="title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title() ?></a></p>
						<p class="comments-count"><a href="<?php the_permalink() ?>#comments" title="<?php comments_number('0 commentaires', '1 commentaire', '% commentaires'); ?>"><strong><span><?php comments_number('0', '1', '%'); ?></span></strong></a></p>
						<p class="author">Par <strong><?php the_author_posts_link() ?></strong></p>
					</li>
					<?php endwhile; ?>
				</ul>
				<p class="footer"><a href="<?php echo bloginfo('url'); ?>/articles/" class="all">Tous les articles</a></p>
			</section>
			<?php endif; ?>
			
			<?php
				/* Notes */
				if (!is_category('31')): ?>
			<section class="text titled notes">
				<h1>Dernières Notes</h1>
				<ul>
					<?php
						rewind_posts();
						query_posts("cat=31&posts_per_page=3");
					?>
					<?php while (have_posts()) : the_post(); ?>
					<li>
						<p class="date"><time datetime="<?php the_time('c'); ?>"><?php the_time('j/m') ?></time></p>
						<div class="content">
							<?php the_advanced_excerpt('length=30&use_words=1') ?> <span class="more"><a href="<?php the_permalink() ?>" rel="bookmark">Lire la note</a></span>
						</div>
						<p class="comments-count"><a href="<?php the_permalink() ?>#comments" title="<?php comments_number('0 commentaires', '1 commentaire', '% commentaires'); ?>"><strong><span><?php comments_number('0', '1', '%'); ?></span></strong></a></p>
					</li>
					<?php endwhile; ?>
				</ul>
				<p class="footer"><a href="<?php echo bloginfo('url'); ?>/categorie/notes/" class="all">Toutes les notes</a></p>
			</section>
			<?php endif; ?>
			
			<section class="text titled newsletter">
				<h1>Newsletter</h1>
				<form action="http://feedburner.google.com/fb/a/mailverify" method="get">
					<p><label for="email">Suivez les intégristes depuis votre boîte mail, en entrant votre adresse email ci-dessous.</label> <input type="text" name="email" value="" id="email" /></p>
					<p class="submit">
						<input type="hidden" name="uri" value="lesintegristes" />
						<input type="hidden" name="loc" value="fr_FR" />
						<button type="submit"><span><span>S'inscrire</span></span></button>
					</p>
				</form>
			</section>
			
			<section class="text creativecommons">
				<h1><a href="http://creativecommons.org/licenses/by-nc-sa/2.0/fr/"><img src="<?php bloginfo('template_url'); ?>/images/creative-commons.png" width="81" height="96" alt="Creative Commons" /></a></h1>
				<p>Sauf mention contraire, les publications de ce site sont mises à disposition sous un <a href="http://creativecommons.org/licenses/by-nc-sa/2.0/fr/">contrat Creative Commons <abbr title="Paternité">BY</abbr> <abbr title="Pas d'utilisation commerciale">NC</abbr> <abbr title="Partage des conditions à l'identique">SA</abbr></a>.</p>
			</section>
			
			<?php if (is_user_logged_in()): ?>
			<section class="titled text">
				<h1>Liens</h1>
				<ul>
					<li><a href="<?php echo get_option('home'); ?>/wp-admin/">Administration</a></li>
				</ul>
			</section>
			<?php endif; ?>
			
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
			
		</aside>