<?php

# No direct file load
if (!defined('ABSPATH')) return;

# Setup theme
require_once get_template_directory().'/inc/setup.php';

# Load custom post types and taxonomies
require_once get_template_directory().'/inc/custom-post-types.php';

# Load front scripts and styles
require_once get_template_directory().'/inc/front-js-styles.php';

# Load template's helpers
require_once get_template_directory().'/inc/template-helpers.php';

# Setup admin
require_once get_template_directory().'/inc/setup-admin.php';