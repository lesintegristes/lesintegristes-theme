<?php
# No direct file load
if (!defined('WP_USE_THEMES')) return; ?>
<form method="get" id="searchform" action="<?php echo bloginfo('url'); ?>/" role="search">
	<div>
		<label class="screen-reader-text" for="s">Recherche pour:</label>
		<input type="text" value="<?php the_search_query(); ?>" name="s" id="s" />
		<button type="submit"><span><span>Rechercher</span></span></button>
	</div>
</form>