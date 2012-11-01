<?php

# No direct file load
if (!defined('ABSPATH')) return;

/* Feedburner counter in the Dashboard */
function lesintegristes_dashboard_feedburner() {
  echo '<p>Blog : <a href="http://feeds.feedburner.com/lesintegristes"><img src="http://feeds.feedburner.com/~fc/lesintegristes?bg=F9F9F9&amp;fg=333333&amp;anim=0" height="26" width="88" style="border:0;vertical-align:middle;" alt="" /></a></p>';
  echo '<p>Veille : <a href="http://feeds.feedburner.com/lesintegristes/veille"><img src="http://feeds.feedburner.com/~fc/lesintegristes/veille?bg=F9F9F9&amp;fg=333333&amp;anim=0" height="26" width="88" style="border:0;vertical-align:middle;" alt="" /></a></p>';
}

/* Dashboard widgets */
function lesintegristes_dashboard_widgets() {
  wp_add_dashboard_widget('lesintegristes_dashboard_feedburner', 'Statistiques Feedburner', 'lesintegristes_dashboard_feedburner');
}
add_action('wp_dashboard_setup', 'lesintegristes_dashboard_widgets' );

/* User profile: additional fields */
$lesintegristes_additional_fields = array(
  'description_by' => array(
    'name' => 'Description par',
    'help' => 'Auteur de votre description / bio',
    'placeholder' => 'Éric Le Bihan'
  ),
  'profession' => array(
    'name' => 'Profession',
    'help' => 'Votre profession',
    'placeholder' => 'Front-end Developer'
  ),
  'twitter' => array(
    'name' => 'Twitter',
    'help' => 'Votre compte Twitter, sans @',
    'placeholder' => 'lesintegristes'
  ),
);

function lesintegristes_add_profile_fields($user) {
  global $lesintegristes_additional_fields;
  echo <<<EOD
<h3>Champs additionnels</h3>
<table class="form-table">
EOD;

  foreach ($lesintegristes_additional_fields as $field_id => $field) {
    $value_attr = esc_attr(get_the_author_meta('lesintegristes-'.$field_id, $user->ID));
    echo <<<EOD
  <tr>
    <th>
      <label for="lesintegristes-{$field['name']}">{$field['name']}</label>
    </th>
    <td>
    <input type="text" placeholder="{$field['placeholder']}" name="lesintegristes-{$field_id}" id="lesintegristes-{$field_id}" value="{$value_attr}" class="regular-text lesintegristes-text" /><br />
      <span class="description">{$field['help']}</span>
    </td>
  </tr>
EOD;
  }
  echo <<<EOD
</table>
<style>
  .lesintegristes-text::-webkit-input-placeholder{color:#999;font-style:italic;}
  .lesintegristes-text:-moz-placeholder{color:#999;font-style:italic;}
 </style>
EOD;
}

function lesintegristes_save_profile_fields($user_id) {
  global $lesintegristes_additional_fields;
  if (!current_user_can('edit_user', $user_id)) {
    return FALSE;
  }
  foreach ($lesintegristes_additional_fields as $field_id => $field) {
    update_user_meta($user_id, 'lesintegristes-'.$field_id, $_POST['lesintegristes-'.$field_id]);
  }
}
add_action('show_user_profile', 'lesintegristes_add_profile_fields');
add_action('edit_user_profile', 'lesintegristes_add_profile_fields');
add_action('personal_options_update', 'lesintegristes_save_profile_fields');
add_action('edit_user_profile_update', 'lesintegristes_save_profile_fields');