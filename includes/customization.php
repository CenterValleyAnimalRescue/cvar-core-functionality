<?php
/**
 * CVAR Customization
 *
 * @package    CVAR_Core
 * @subpackage CVAR_Core\Includes
 * @since      0.2.0
 * @license    GPL-2.0+
 */


add_filter( 'widget_text', 'do_shortcode' );
add_filter( 'widget_text', 'shortcode_unautop' );
