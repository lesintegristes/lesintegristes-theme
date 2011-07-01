<?php
/*
Template Name: Links
*/

# No direct file load
if (!empty($_SERVER['SCRIPT_FILENAME']) && realpath($_SERVER['SCRIPT_FILENAME']) === realpath(__FILE__)) { die(); }
?>

<?php get_header(); ?>

<h2>Links:</h2>
<ul>
<?php wp_list_bookmarks(); ?>
</ul>

<?php get_footer(); ?>