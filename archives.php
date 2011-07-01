<?php
# No direct file load
if (!empty($_SERVER['SCRIPT_FILENAME']) && realpath($_SERVER['SCRIPT_FILENAME']) === realpath(__FILE__)) { die(); }

get_header(); ?>
<?php get_search_form(); ?>

<h2>Archives by Month:</h2>
<ul>
	<?php wp_get_archives('type=monthly'); ?>
</ul>

<h2>Archives by Subject:</h2>
<ul>
	 <?php wp_list_categories(); ?>
</ul>

<?php get_footer(); ?>