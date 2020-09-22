<?php
/**
 * Plugin Name: WooCommerce Product Meta
 * Description: Add a simple line to product / order item meta
 * Author: Toml Broucke
 * Author URI: https://tombroucke.be
 * Version: 1.0
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wc-product-meta
 * Domain Path: languages
 * Network: false
 */

namespace Otomaties\WooCommerce_Product_meta;

defined( 'ABSPATH' ) || exit;

class Plugin {

	private static $_instance = null;

	public static function instance() {
		if ( ! isset( self::$_instance ) ) {
			self::$_instance = new self;
		}

		return self::$_instance;
	}

	private function __construct() {
		$this->includes();
		$this->init();
	}

	private function includes() {
		include 'includes/class-admin.php';
	}

	private function init() {
		new Admin();
	}
}

add_action( 'woocommerce_init', 'Otomaties\\WooCommerce_Product_meta\\Plugin::instance' );