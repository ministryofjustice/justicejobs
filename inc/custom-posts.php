<?php
// Register Agency Post Type
function add_agency_post_type() {

	$labels = array(
		'name'                  => _x( 'Agencies', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Agency', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Agencies', 'text_domain' ),
		'name_admin_bar'        => __( 'Agency', 'text_domain' ),
		'archives'              => __( 'Agency Archives', 'text_domain' ),
		'attributes'            => __( 'Agency Attributes', 'text_domain' ),
		'parent_item_colon'     => __( '', 'text_domain' ),
		'all_items'             => __( 'All Agencies', 'text_domain' ),
		'add_new_item'          => __( 'Add New Agency', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Agency', 'text_domain' ),
		'edit_item'             => __( 'Edit Agency', 'text_domain' ),
		'update_item'           => __( 'Update Agency', 'text_domain' ),
		'view_item'             => __( 'View Agency', 'text_domain' ),
		'view_items'            => __( 'View Agencies', 'text_domain' ),
		'search_items'          => __( 'Search Agency', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into Agency', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Agency', 'text_domain' ),
		'items_list'            => __( 'Agencies list', 'text_domain' ),
		'items_list_navigation' => __( 'Agencies list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter Agencies list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Agency', 'text_domain' ),
		'description'           => __( 'Agency Description', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'custom-fields' ),
		// 'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'							=> 'dashicons-building',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'agency', $args );

}
add_action( 'init', 'add_agency_post_type', 0 );


// Register Job Post Type
function add_job_post_type() {

	$labels = array(
		'name'                  => _x( 'Jobs', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Job', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Jobs', 'text_domain' ),
		'name_admin_bar'        => __( 'Job', 'text_domain' ),
		'archives'              => __( 'Job Archives', 'text_domain' ),
		'attributes'            => __( 'Job Attributes', 'text_domain' ),
		'parent_item_colon'     => __( '', 'text_domain' ),
		'all_items'             => __( 'All Jobs', 'text_domain' ),
		'add_new_item'          => __( 'Add New Job', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Job', 'text_domain' ),
		'edit_item'             => __( 'Edit Job', 'text_domain' ),
		'update_item'           => __( 'Update Job', 'text_domain' ),
		'view_item'             => __( 'View Job', 'text_domain' ),
		'view_items'            => __( 'View Jobs', 'text_domain' ),
		'search_items'          => __( 'Search Job', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into job', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this job', 'text_domain' ),
		'items_list'            => __( 'Jobs list', 'text_domain' ),
		'items_list_navigation' => __( 'Jobs list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter jobs list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Job', 'text_domain' ),
		'description'           => __( 'Job Post Type', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-portfolio',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'job', $args );

}
add_action( 'init', 'add_job_post_type', 0 );

// Register Campaign Post Type
function add_campaign_post_type() {

	$labels = array(
		'name'                  => _x( 'Campaigns', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Campaign', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Campaigns', 'text_domain' ),
		'name_admin_bar'        => __( 'Campaign', 'text_domain' ),
		'archives'              => __( 'Campaign Archives', 'text_domain' ),
		'attributes'            => __( 'Campaign Attributes', 'text_domain' ),
		'parent_item_colon'     => __( '', 'text_domain' ),
		'all_items'             => __( 'All Campaigns', 'text_domain' ),
		'add_new_item'          => __( 'Add New Campaign', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New Campaign', 'text_domain' ),
		'edit_item'             => __( 'Edit Campaign', 'text_domain' ),
		'update_item'           => __( 'Update Campaign', 'text_domain' ),
		'view_item'             => __( 'View Campaign', 'text_domain' ),
		'view_items'            => __( 'View Campaigns', 'text_domain' ),
		'search_items'          => __( 'Search Campaign', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into Campaign', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Campaign', 'text_domain' ),
		'items_list'            => __( 'Campaigns list', 'text_domain' ),
		'items_list_navigation' => __( 'Campaigns list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter Campaigns list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Campaign', 'text_domain' ),
		'description'           => __( 'Campaign Post Type', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title' ),
		//'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-lightbulb',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
        'rewrite' => array('slug' => 'role','with_front' => false)
	);
	register_post_type( 'campaign', $args );

}
add_action( 'init', 'add_campaign_post_type', 0 );
