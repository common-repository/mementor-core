<?php
/**
* Plugin Name: Mementor Core
* Plugin URI: https://www.mementor.no/plugins/mementor-core
* Description: Mementor Core is a plugin built for Mementor's clients, which optimises WordPress' functionality.
* Version: 1.0.6
* Author: Mementor AS
* Author URI: https://www.mementor.no/
* WC requires at least: 4.4.1
* WC tested up to: 5.6.0
*/

if (!defined('ABSPATH')) {
  exit;
}

define('mementor_core_path', plugin_dir_path(__FILE__));

if (!class_exists('mementor_core')) {

  class mementor_core {

    public $version = '1.0.5';
    public $url;
    protected static $_instance = null;

    public static function instance() {
      if (null == self::$_instance) {
        self::$_instance = new self();
      }
      return self::$_instance;
    }

    public function __construct() {

      // Disable password change notifications for admins.
      if (!function_exists('wp_password_change_notification')) {
        function wp_password_change_notification($user) {
          return;
        }
      }

      add_action('plugins_loaded', array($this, 'init'));
      add_action('admin_head', array($this, 'scripts'));

      $this->url = plugin_dir_url(__FILE__);
      $this->language();

  	}

    public function scripts() {

      /* The scripts */
      wp_enqueue_script('select2', mementor_core()->url.'assets/js/select2.full.min.js', array('jquery'), $this->version, true);
      wp_enqueue_script('mementor_core_admin', mementor_core()->url.'assets/js/admin.js');

      /* The styles */
      wp_enqueue_style('select2', mementor_core()->url.'assets/css/select2.min.css');
      wp_enqueue_style('mementor_core_admin', mementor_core()->url.'assets/css/admin.css');

    }

    public function init() {
      require_once 'inc/admin.php';
      require_once 'inc/functions.php';
      if (class_exists('WooCommerce')) {
        // require_once 'inc/woocommerce.php';
      }
    }

    public function language() {
      load_plugin_textdomain('mementor-core', false, basename(dirname(__FILE__)).'/lang');
    }

  }

  function mementor_plugins_class($classes) {
    global $post;
    $classes .= ' mementor-plugin';
    return $classes;
  }

  function mementor_core() {
  	return mementor_core::instance();
  }

  mementor_core();
}
