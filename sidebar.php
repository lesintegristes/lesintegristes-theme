<?php
# No direct file load
if (!empty($_SERVER['SCRIPT_FILENAME']) && realpath($_SERVER['SCRIPT_FILENAME']) === realpath(__FILE__)) { die(); }

$show_veille = !is_page('veille');
$show_articles = ( is_archive() || (is_page() && !is_page('page-home')) || is_single() || is_404() );
$show_notes = !is_post_type_archive('lesintegristes_note');
$show_links = is_user_logged_in();
$show_archives_links = is_date();
?>
		<aside id="sidebar" role="complementary">

			<div class="search">
				<?php get_search_form(); ?>
			</div>

			<?php if ($show_veille): ?>
			<div class="veille">
				<a href="<?php echo bloginfo('url'); ?>/veille/" title="Veille : Offrez notre sélection d'infos à votre agrégateur !">
					<div>
						<p><strong>Veille</strong></p>
						<p>Offrez notre sélection d'infos à votre agrégateur !</p>
					</div>
				</a>
			</div>
			<?php endif; ?>

			<section class="titled text weather collapsible">
				<h1><span>Météo</span></h1>
				<div>
					<?php global $cur_weather_condition; ?>
					<form action="" method="post">
						<p><input name="change_weather" type="radio" value="sunny" id="weather-sunny"<?php echo getAttributeIfTrue( ($cur_weather_condition === "sunny"), "checked", "checked") ?> /> <label for="weather-sunny"<?php echo getAttributeIfTrue(($cur_weather_condition === "sunny")) ?> title="Soleil">Soleil</label></p>
						<p><input name="change_weather" type="radio" value="cloudy" id="weather-cloudy"<?php echo getAttributeIfTrue( ($cur_weather_condition === "cloudy"), "checked", "checked") ?> /> <label for="weather-cloudy"<?php echo getAttributeIfTrue(($cur_weather_condition === "cloudy")) ?> title="Nuageux">Nuageux</label></p>
						<p><input name="change_weather" type="radio" value="rain" id="weather-rain"<?php echo getAttributeIfTrue( ($cur_weather_condition === "rain"), "checked", "checked") ?> /> <label for="weather-rain"<?php echo getAttributeIfTrue(($cur_weather_condition === "rain")) ?> title="Pluie">Pluie</label></p>
						<p><input name="change_weather" type="radio" value="snow" id="weather-snow"<?php echo getAttributeIfTrue( ($cur_weather_condition === "snow"), "checked", "checked") ?> /> <label for="weather-snow"<?php echo getAttributeIfTrue(($cur_weather_condition === "snow")) ?> title="Neige">Neige</label></p>
						<p><input name="change_weather" type="radio" value="night" id="weather-night"<?php echo getAttributeIfTrue( ($cur_weather_condition === "night"), "checked", "checked") ?> /> <label for="weather-night"<?php echo getAttributeIfTrue(($cur_weather_condition === "night")) ?> title="Nuit">Nuit</label></p>
						<p class="submit"><button type="submit"><span><span>Changer la météo</span></span></button></p>
					</form>
					<p>Faites la pluie et le beau temps (sélection valable 24h).</p>
				</div>
			</section>

			<?php
				/* Archives */
				if ($show_archives_links): ?>
			<section class="text titled archives">
				<h1>Archives</h1>
				<ul>
				<?php
					global $wp_locale;
					$years = get_lesintegristes_archives_years_query();
					foreach($years as $year) :
				?>
					<li>
						<strong><a href="<?php echo get_year_link($year); ?>"><?php echo $year; ?></a></strong>
						<ul>
						<?php
							$months = get_lesintegristes_archives_months_query($year);
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
						$articles_query = new WP_Query('post_type=post&posts_per_page=3');
						while ($articles_query->have_posts()) :
							$articles_query->the_post();
					?>
					<li>
						<p class="date"><time datetime="<?php the_time('c'); ?>"><span class="day"><?php the_time('j') ?></span> <?php the_time('M y'); ?></time></p>
						<p class="title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title() ?></a></p>
						<p class="comments-count"><a href="<?php the_permalink() ?>#comments" title="<?php comments_number('0 commentaires', '1 commentaire', '% commentaires'); ?>"><strong><span><?php comments_number('0', '1', '%'); ?></span></strong></a></p>
						<p class="author"><?php echo lesintegristes_get_author_link(get_the_author_meta('ID'), array("before" => "Par <strong>", "after" => "</strong>")) ?></p>
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
						$notes_query = new WP_Query('post_type=lesintegristes_note&posts_per_page=3');
						while ($notes_query->have_posts()) :
							$notes_query->the_post();
					?>
					<li>
						<p class="date"><time datetime="<?php the_time('c'); ?>"><?php the_time('j/m') ?></time></p>
						<div class="content">
							<?php
							if (function_exists('the_advanced_excerpt')) {
								the_advanced_excerpt('length=30&use_words=1');
							} else {
								the_excerpt();
							}
							?>
							<span class="more"><a href="<?php the_permalink() ?>" rel="bookmark">Lire la note</a></span>
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
			<section class="titled text links">
				<h1>Liens</h1>
				<ul>
					<li><a href="<?php echo get_option('home'); ?>/wp-admin/" class="action">Administration</a></li>
				</ul>
			</section>
			<?php endif; ?>

		</aside>