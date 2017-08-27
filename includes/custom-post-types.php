<?php
/**
 * CVAR Custom Post Types
 *
 * @package    CVAR_Core
 * @subpackage CVAR_Core\Includes
 * @since      0.2.0
 * @license    GPL-2.0+
 */

/**
 * Add Custom Post Types
 *
 * @since 0.2.0
 *
 * @return void
 */
function cvar_core_custom_post_type() {

	$labels = array(
		'name'                  => _x( 'Profiles', 'Post Type General Name', 'cvar-core' ),
		'singular_name'         => _x( 'Profile', 'Post Type Singular Name', 'cvar-core' ),
		'menu_name'             => __( 'Profiles', 'cvar-core' ),
		'name_admin_bar'        => __( 'Profile', 'cvar-core' ),
		'archives'              => __( 'Profile Archives', 'cvar-core' ),
		'attributes'            => __( 'Profile Attributes', 'cvar-core' ),
		'parent_item_colon'     => __( 'Parent Profile:', 'cvar-core' ),
		'all_items'             => __( 'All Profiles', 'cvar-core' ),
		'add_new_item'          => __( 'Add New Profile', 'cvar-core' ),
		'add_new'               => __( 'Add New', 'cvar-core' ),
		'new_item'              => __( 'New Profile', 'cvar-core' ),
		'edit_item'             => __( 'Edit Profile', 'cvar-core' ),
		'update_item'           => __( 'Update Profile', 'cvar-core' ),
		'view_item'             => __( 'View Profile', 'cvar-core' ),
		'view_items'            => __( 'View Profiles', 'cvar-core' ),
		'search_items'          => __( 'Search Profile', 'cvar-core' ),
		'not_found'             => __( 'Not found', 'cvar-core' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'cvar-core' ),
		'featured_image'        => __( 'Profile Picture', 'cvar-core' ),
		'set_featured_image'    => __( 'Set profile picture', 'cvar-core' ),
		'remove_featured_image' => __( 'Remove profile picture', 'cvar-core' ),
		'use_featured_image'    => __( 'Use as profile picture', 'cvar-core' ),
		'insert_into_item'      => __( 'Insert into profile', 'cvar-core' ),
		'uploaded_to_this_item' => __( 'Uploaded to this profile', 'cvar-core' ),
		'items_list'            => __( 'Profiles list', 'cvar-core' ),
		'items_list_navigation' => __( 'Profiles list navigation', 'cvar-core' ),
		'filter_items_list'     => __( 'Filter profiles list', 'cvar-core' ),
	);
	$args = array(
		'label'                 => __( 'Profile', 'cvar-core' ),
		'description'           => __( 'People profiles', 'cvar-core' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields' ),
		'taxonomies'            => array( 'role' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 20,
		'menu_icon'             => 'dashicons-id',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'show_in_rest'          => true,
	);
	register_post_type( 'profile', $args );

}
add_action( 'init', 'cvar_core_custom_post_type', 0 );


/**
 * Add Custom Taxonomy
 *
 * @since 0.2.0
 *
 * @return void
 */
function cvar_core_register_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Roles', 'Taxonomy General Name', 'cvar-core' ),
		'singular_name'              => _x( 'Role', 'Taxonomy Singular Name', 'cvar-core' ),
		'menu_name'                  => __( 'Role', 'cvar-core' ),
		'all_items'                  => __( 'All IRoles', 'cvar-core' ),
		'parent_item'                => __( 'Parent Role', 'cvar-core' ),
		'parent_item_colon'          => __( 'Parent Role:', 'cvar-core' ),
		'new_item_name'              => __( 'New Role Name', 'cvar-core' ),
		'add_new_item'               => __( 'Add New Role', 'cvar-core' ),
		'edit_item'                  => __( 'Edit Role', 'cvar-core' ),
		'update_item'                => __( 'Update Role', 'cvar-core' ),
		'view_item'                  => __( 'View Role', 'cvar-core' ),
		'separate_items_with_commas' => __( 'Separate role with commas', 'cvar-core' ),
		'add_or_remove_items'        => __( 'Add or remove roles', 'cvar-core' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'cvar-core' ),
		'popular_items'              => __( 'Popular Roles', 'cvar-core' ),
		'search_items'               => __( 'Search Roles', 'cvar-core' ),
		'not_found'                  => __( 'Not Found', 'cvar-core' ),
		'no_terms'                   => __( 'No items', 'cvar-core' ),
		'items_list'                 => __( 'Roles list', 'cvar-core' ),
		'items_list_navigation'      => __( 'Roles list navigation', 'cvar-core' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'show_in_rest'               => true,
	);
	register_taxonomy( 'role', array( 'profile' ), $args );

}
add_action( 'init', 'cvar_core_register_taxonomy', 0 );
