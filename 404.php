<?php
# No direct file load
if (!empty($_SERVER['SCRIPT_FILENAME']) && realpath($_SERVER['SCRIPT_FILENAME']) === realpath(__FILE__)) { die(); }

get_header(); ?>
<div id="content" role="main">
	<p>Oh non&nbsp;!</p>
	<div>
		<h1>Erreur 404&nbsp;: la page demandée n’a pas été trouvée.</h1>
	</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>