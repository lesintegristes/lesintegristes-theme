  	<footer>
			<div>
				<section class="categories">
					<h1>Catégories</h1>
					<?php echo substr_replace(str_replace('<br />', ', ', wp_list_categories('show_count=0&exclude=31&title_li=<h1>Catégories</h1>&style=none&echo=0')) , "", -3); ?>
				</section>
				<section class="archives">
					<h1>Archives</h1>
					<ul>
					<?php
						global $wp_locale;
						$years = $wpdb->get_col("SELECT DISTINCT YEAR(post_date) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' ORDER BY post_date DESC");
						foreach($years as $year) :
					?>
						<li>
							<strong><a href="<?php echo get_year_link($year); ?>"><?php echo $year; ?></a></strong>
							<div>
							<ul>
							<?php
								$months = $wpdb->get_col("SELECT DISTINCT MONTH(post_date) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' AND YEAR(post_date) = '".$year."' ORDER BY post_date DESC");
								foreach($months as $month) :
								?>
								<li><a href="<?php echo get_month_link($year, $month); ?>"><?php echo $wp_locale->get_month($month); ?></a></li>
								<?php endforeach;?>
							</ul>
							</div>
						</li>
					<?php endforeach; ?>
					</ul>
					<p>Ou consulter <a href="<?php echo lesintegristes_get_articles_url() ?>">tous les articles</a></p>
				</section>
				<nav role="navigation">
					<p class="top"><a href="#header">Haut de la page</a></p>
					<ul>
						<li><a href="<?php bloginfo('url'); ?>/articles/">Articles</a></li>
						<li><a href="<?php bloginfo('url'); ?>/categorie/notes/">Notes</a></li>
						<li><a href="<?php bloginfo('url'); ?>/auteurs/">Auteurs</a></li>
					</ul>
				</nav>
			</div>
			<p class="bottom-line">Merci <a href="http://twitter.com/gregoiredierend" title="Grégoire Dierendonck">Grégoire</a>. Merci <a href="http://www.wordpress.org">Wordpress</a>. Merci à toutes les mamans du monde.</p>
			<?php wp_footer(); ?>
		</footer>
  </div>
	</div>
	</body>
</html>