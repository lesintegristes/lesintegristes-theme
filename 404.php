<?php
# No direct file load
if (!defined('WP_USE_THEMES')) return;

get_header(); ?>
<div id="content" role="main">
	<p>Oh non&nbsp;!</p>
	<div>
		<h1>Erreur 404&nbsp;: la page demandée n’a pas été trouvée.</h1>
	</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>