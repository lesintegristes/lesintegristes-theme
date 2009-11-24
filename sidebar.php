<?php
	$show_veille = !is_page('veille');
	$show_articles = ( is_category('31') || is_page('veille') || (is_single() && in_category('31')) );
	$show_notes = !is_category('31');
	$show_links = is_user_logged_in();
	$show_archives_links = is_archive() && !is_category('31');
?>
		<aside id="sidebar" role="complementary">
		
			<div class="search">
				<?php get_search_form(); ?>
			</div>
			
			<?php if ($show_veille): ?>
			<div class="veille">
				<a href="<?php echo bloginfo('url'); ?>/veille/" title="Veille : Offrez notre sélection d'infos à votre agrégateur !">
					<p><strong>Veille</strong></p>
					<p>Offrez notre sélection d'infos à votre agrégateur !</p>
				</a>
			</div>
			<?php endif; ?>
			
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
			
			<?php
				/* Archives */
				if ($show_archives_links): ?>
			<section class="text titled archives">
				<h1>Archives</h1>
				<ul>
				<?php
					global $wp_locale;
					$years = $wpdb->get_col("SELECT DISTINCT YEAR(post_date) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' ORDER BY post_date DESC");
					foreach($years as $year) :
				?>
					<li>
						<strong><a href="<?php echo get_year_link($year); ?>"><?php echo $year; ?></a></strong>
						<ul>
						<?php
							$months = $wpdb->get_col("SELECT DISTINCT MONTH(post_date) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' AND YEAR(post_date) = '".$year."' ORDER BY post_date DESC");
							foreach($months as $month) :
							?>
							<li><a href="<?php echo get_month_link($year, $month); ?>"><?php echo $wp_locale->get_month($month); ?></a></li>
							<?php endforeach;?>
						</ul>
					</li>
				<?php endforeach; ?>
				</ul>
			</section>
			<?php endif; ?>
			
			<?php
				/* Articles */
				if ( $show_articles ): ?>
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
				if ( $show_notes ): ?>
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
				<h1><a href="http://creativecommons.org/licenses/by-nc-sa/2.0/fr/">Creative Commons</a></h1>
				<p>Sauf mention contraire, les publications de ce site sont mises à disposition sous un <a href="http://creativecommons.org/licenses/by-nc-sa/2.0/fr/">contrat Creative Commons <abbr title="Paternité">BY</abbr> <abbr title="Pas d'utilisation commerciale">NC</abbr> <abbr title="Partage des conditions à l'identique">SA</abbr></a>.</p>
			</section>
			
			<?php if ($show_links): ?>
			<section class="titled text">
				<h1>Liens</h1>
				<ul>
					<li><a href="<?php echo get_option('home'); ?>/wp-admin/">Administration</a></li>
				</ul>
			</section>
			<?php endif; ?>
			
		</aside>