<?php
/**
 * CVAR Custom Field
 *
 * @package    CVAR_Core
 * @subpackage CVAR_Core\Includes
 * @since      0.2.0
 * @license    GPL-2.0+
 */

/**
 * Add Shortcode
 * Default usage: [petfinder-sidebar]
 * To customize: `[petfinder-sidebar class="custom-class-name"]`
 *
 * @since 0.2.0
 *
 * @param array $atts
 * @return string
 */
function cvar_core_petfinder_sidebar_shortcode( $atts ) {

  $atts = shortcode_atts(
    array(
      'class' => 'pet-filter widget',
    ),
    $atts
  );

  return sprintf( '<aside data-petfinder="aside" class="%s"></aside>',
    esc_html( $atts['class'] )
  );
}
add_shortcode( 'petfinder-sidebar', 'cvar_core_petfinder_sidebar_shortcode' );

/**
 * Add Shortcode
 * Default usage: `[petfinder-list]`
 * To customize: `[petfinder-list class="custom-class-name" shelter="my-shelter-id" text="My Link Text"]`
 *
 * @since 0.2.0
 *
 * @param array $atts
 * @return string
 */
function cvar_core_petfinder_listshortcode( $atts ) {

  $atts = shortcode_atts(
    array(
      'class'   => 'grid',
      'shelter' => 'WA142',
      'text'    => 'View our adoptable pets on Petfinder.'
    ),
    $atts
  );

  return sprintf( '<div data-petfinder="main" class="%s"><a href="%s">%s</a></div>',
    esc_html( $atts['class'] ),
    esc_url( "https://awos.petfinder.com/shelters/{$atts['shelter']}.html" ),
    __( $atts['text'], 'cvar' )
  );
}
add_shortcode( 'petfinder-list', 'cvar_core_petfinder_listshortcode' );
