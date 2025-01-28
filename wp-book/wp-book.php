<?php
/**
 * Plugin Name: WP Book
 * Description: A complete plugin to manage books with custom post types, taxonomies, meta boxes, and more.
 * Version: 1.0.0
 * Author: Eleas Kanchon
 * Text Domain: wp-book
 */

 if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Define constants.
define( 'WP_BOOK_VERSION', '1.0.0' );
define( 'WP_BOOK_PATH', plugin_dir_path( __FILE__ ) );
define( 'WP_BOOK_URL', plugin_dir_url( __FILE__ ) );

// Load necessary files.
require_once WP_BOOK_PATH . 'includes/class-loader.php';

// Register activation and deactivation hooks.
register_activation_hook( __FILE__, [ 'WPBook\Includes\Activator', 'activate' ] );
register_deactivation_hook( __FILE__, [ 'WPBook\Includes\Deactivator', 'deactivate' ] );

// Initialize the plugin.
$loader = new WPBook\Includes\Loader();
$loader->run();