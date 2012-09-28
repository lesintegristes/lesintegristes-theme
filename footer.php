<?php
# No direct file load
if (!empty($_SERVER['SCRIPT_FILENAME']) && realpath($_SERVER['SCRIPT_FILENAME']) === realpath(__FILE__)) { die(); }
?>
	<footer id="footer">
			<div>
				
				<div class="categories-rss-container">
					<section class="categories">
						<h1>Catégories</h1>
						<p><?php echo substr_replace(str_replace('<br />', ', ', wp_list_categories('show_count=0&title_li=<h1>Catégories</h1>&style=none&echo=0')) , "", -3); ?></p>
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
						<li><a href="<?php echo lesintegristes_get_articles_url() ?>">Articles</a></li>
						<li><a href="<?php echo lesintegristes_get_notes_url() ?>">Notes</a></li>
						<li><a href="<?php bloginfo('url'); ?>/auteurs/">Auteurs</a></li>
					</ul>
				</nav>
			</div>
			<p class="bottom-line">
				Thème WordPress réalisé par Grégoire Dierendonck (design) et Les intégristes (code).<br />
				Le code source est également <a href="https://github.com/lesintegristes/lesintegristes-theme">disponible sur GitHub</a> sous licence MIT.<br />
				Merci <a href="http://www.wordpress.org" title="WordPress, Blog Tool and Publishing Platform" lang="en">Wordpress</a>, <a href="http://jquery.com/" title="jQuery: The Write Less, Do More, JavaScript Library" lang="en">jQuery</a>, <a href="http://php.net/" title="PHP: Hypertext Preprocessor" lang="en">PHP</a> et <a href="http://httpd.apache.org/" title="The Apache HTTP Server Project" lang="en">Apache</a>.
			</p>
		</footer>
	</div>
	</div>
	<?php wp_footer(); ?>
	<?php if (defined('GOOGLE_ANALYTICS_ID')): // Define this in wp-config.php ?>
	<script>
	var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
	document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
	</script>
	<script>
	try {
	var pageTracker = _gat._getTracker("<?php echo GOOGLE_ANALYTICS_ID ?>");
	pageTracker._trackPageview();
	} catch(err) {}</script>
	<?php endif ?>
	</body>
</html>