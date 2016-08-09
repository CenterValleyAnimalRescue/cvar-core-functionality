<?php
/**
 * CVAR Core Helper functions
 *
 * @package    CVAR_Core
 * @subpackage CVAR_Core\Includes
 * @since      0.1.0
 * @license    GPL-2.0+
 */

 /**
  * Get Image IDs of Images Matching terms
  *
  * @since 0.1.0
  *
  * @uses get_posts
  * @uses wp_list_pluck
  *
  * @param {string} {array} $terms
  * @return {array} $image_ids
  *
  */
function cvar_get_image_ids_by_terms( $terms = null ) {
    $terms = ( is_array( $terms ) ) ? $terms : explode( ',', $terms );

    $args = array(
        'post_type'     => 'attachment',
        'tax_query'     => array(
            array(
                'taxonomy'  => 'media_category',
                'field'     => 'term_id',
                'terms'     => $terms
            )
        )
    );

    $images = get_posts( $args );

    $image_ids = wp_list_pluck( $images, 'ID' );

    return $image_ids;
}
