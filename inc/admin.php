<?php
if (!defined('ABSPATH')) {
  exit ();
}

/* Admin body class */
add_filter('admin_body_class', 'mementor_plugins_class');
