<?php
/**
 * CVAR Core Enqueue functions
 *
 * @package    CVAR_Core
 * @subpackage CVAR_Core\Includes
 * @since      0.2.0
 * @license    GPL-2.0+
 */

 function cvar_core_enqueue_scripts() {
   wp_register_script( 'petfinder-api', CVAR_CORE_DIR_URL . 'vendor/petfinder/dist/js/petfinderAPI4everybody.min.js', array(), null, true );
   wp_register_script( 'petfinder-sort', CVAR_CORE_DIR_URL . 'vendor/petfinder/dist/js/petfinderSort.min.js', array(), null, true );
   wp_enqueue_script( 'petfinder-api' );
   wp_enqueue_script( 'petfinder-sort' );
 }
 add_action( 'wp_enqueue_scripts', 'cvar_core_enqueue_scripts' );
