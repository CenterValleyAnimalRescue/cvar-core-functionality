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
 * Version:         0.1.0
 *
 * @package         Core_Functionality
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Plugin Directory
 *
 * @since 0.1.0
 */
define( 'JACOBIN_CORE_DIR', dirname( __FILE__ ) );

require_once( 'includes/helpers.php' );

// Load plugin libraries
require_once( 'includes/lib/class-wordpress-plugin-template-post-type.php' );
require_once( 'includes/lib/class-wordpress-plugin-template-taxonomy.php' );

// Load plugin class files
require_once( 'admin/class-cvar-core-admin.php' );
require_once( 'includes/class-cvar-core.php' );
require_once( 'includes/class-cvar-core-shortcodes.php' );

/**
 * Returns the main instance of CVAR_Core to prevent the need to use globals.
 *
 * @since  0.1.0
 * @return object CVAR_Core
 */
function CVAR_Core () {
	$instance = CVAR_Core::instance( __FILE__, '0.1.0' );

	return $instance;
}


CVAR_Core();

/**
 * Register Custom Post types
 *
 * @since  0.1.0
 */
CVAR_Core()->register_post_type(
    'form',
    __( 'Forms', 'cvar-core' ),
    __( 'Form', 'cvar-core' )
);

CVAR_Core()->register_post_type(
    'board-member',
    __( 'Board Members', 'cvar-core' ),
    __( 'Board Member', 'cvar-core' )
);

/**
 * Register Custom Taxonomy
 *
 * @since  0.1.0
 */
CVAR_Core()->register_taxonomy(
    'type',
    __( 'Types', 'cvar-core' ),
    __( 'Type', 'cvar-core' ),
    'form'
);

CVAR_Core()->register_taxonomy(
    'role',
    __( 'Roles', 'cvar-core' ),
    __( 'Role', 'cvar-core' ),
    'board-member'
);
