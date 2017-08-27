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
 * Add Custom Fields
 * Uses Advanced Custom Fields to create custom fields
 *
 * @since 0.2.0
 *
 * @uses register_field_group()
 *
 * @return void
 */
if( function_exists( 'register_field_group' ) ){
 	register_field_group( array(
 		'id' => 'acf_profiles',
 		'title' => __( 'Profiles', 'cvar-core' ),
 		'fields' => array(
 			array (
 				'key' => 'field_profile_title',
 				'label' => __( 'Title', 'cvar-core' ),
 				'name' => 'profile_title',
 				'type' => 'text',
 				'default_value' => '',
 				'placeholder' => '',
 				'prepend' => '',
 				'append' => '',
 				'formatting' => 'html',
 				'maxlength' => '',
 			),
 		),
 		'location' => array(
 			array(
 				array(
 					'param' => 'post_type',
 					'operator' => '==',
 					'value' => 'profile',
 					'order_no' => 0,
 					'group_no' => 0,
 				),
 			),
 		),
 		'options' => array(
 			'position' => 'acf_after_title',
 			'layout' => 'no_box',
 			'hide_on_screen' => array(),
 		),
 		'menu_order' => 0,
 	));
}
