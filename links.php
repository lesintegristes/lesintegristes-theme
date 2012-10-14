<?php
/*
Template Name: Links
*/

# No direct file load
if (!defined('WP_USE_THEMES')) return;
?>

<?php get_header(); ?>

<h2>Links:</h2>
<ul>
<?php wp_list_bookmarks(); ?>
</ul>

<?php get_footer(); ?>