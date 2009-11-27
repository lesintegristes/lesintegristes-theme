  	<footer>
			<div>
				
				<div class="categories-rss-container">
					<section class="categories">
						<h1>Catégories</h1>
						<p><?php echo substr_replace(str_replace('<br />', ', ', wp_list_categories('show_count=0&exclude=31&title_li=<h1>Catégories</h1>&style=none&echo=0')) , "", -3); ?></p>
					</section>
					
					<section class="rss">
						<p><?php echo lesintegristes_get_feed_link(get_bloginfo('rss2_url'), 'Flux RSS du blog (articles et notes)', false) ?></p>
						<p><?php echo lesintegristes_get_feed_link(get_bloginfo("wpurl") .'/articles/feed/', 'Flux RSS des articles uniquement', false) ?></p>
					</section>
				</div>
				
				<section class="archives">
					<h1>Archives</h1>
					<ul>
					<?php
						global $wp_locale;
						$years = get_lesintegristes_archives_years_query();
						foreach($years as $year) :
					?>
						<li>
							<strong><a href="<?php echo get_year_link($year); ?>"><?php echo $year; ?></a></strong>
							<div>
							<ul>
							<?php
								$months = get_lesintegristes_archives_months_query($year);
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
		</footer>
		<?php wp_footer(); ?>
		<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/scripts/syntax-highlighter.js"></script>
		<script type="text/javascript">
			SyntaxHighlighter.all();
		</script>
  </div>
	</div>
	</body>
</html>