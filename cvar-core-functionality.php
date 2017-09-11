<?php
/**
 * Plugin Name:     CVAR Core Functionality Plugin
 * Plugin URI:      https://github.com/misfist/cvar-core-functionality
 * Description:     Contains the site's core functionality
 *
 * Author:          Pea <pea@misfist.com>
 * Author URI:      https://github.com/misfist
 *
 * Text Domain:     cvar-core
 * Domain Path:     /languages
 *
 * Version:         0.2.1
 *
 * @package         Core_Functionality
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Plugin Directory
 *
 * @since 0.1.0
 */
define( 'CVAR_CORE_DIR', dirname( __FILE__ ) );
define( 'CVAR_CORE_DIR_URL', plugin_dir_url( __FILE__ ) );

require_once( 'includes/customization.php' );
require_once( 'includes/enqueue.php' );
require_once( 'includes/helpers.php' );
require_once( 'includes/custom-post-types.php' );
require_once( 'includes/custom-fields.php' );
require_once( 'includes/shortcodes.php' );
