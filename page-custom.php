<?php
/*
Template Name: Custom
*/

# No direct file load
if (!empty($_SERVER['SCRIPT_FILENAME']) && realpath($_SERVER['SCRIPT_FILENAME']) === realpath(__FILE__)) { die(); }
?>
<?php get_header(); ?>

<?php get_footer(); ?>