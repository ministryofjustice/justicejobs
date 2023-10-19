<?php

// Register Job Role Type Custom Taxonomy
function job_role_type_custom_taxonomy() {

	$labels = array(
		'name'                       => 'Role Types',
		'singular_name'              => 'Role Type',
		'menu_name'                  => 'Role Types',
		'all_items'                  => 'All Types',
		'parent_item'                => 'Parent Type',
		'parent_item_colon'          => 'Parent Type:',
		'new_item_name'              => 'New Type Name',
		'add_new_item'               => 'Add New Type',
		'edit_item'                  => 'Edit Type',
		'update_item'                => 'Update Type',
		'view_item'                  => 'View Type',
		'separate_items_with_commas' => 'Separate types with commas',
		'add_or_remove_items'        => 'Add or remove types',
		'choose_from_most_used'      => 'Choose from the most used',
		'popular_items'              => 'Popular Types',
		'search_items'               => 'Search Types',
		'not_found'                  => 'Not Found',
		'no_terms'                   => 'No types',
		'items_list'                 => 'Types list',
		'items_list_navigation'      => 'Types list navigation',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'role_type', array( 'job' ), $args );

}
add_action( 'init', 'job_role_type_custom_taxonomy', 0 );


// Register Salary Range Custom Taxonomy
function salary_range_custom_taxonomy() {

	$labels = array(
		'name'                       => 'Salary Ranges',
		'singular_name'              => 'Salary Range',
		'menu_name'                  => 'Salary Ranges',
		'all_items'                  => 'All Ranges',
		'parent_item'                => 'Parent Range',
		'parent_item_colon'          => 'Parent Range:',
		'new_item_name'              => 'New Range Name',
		'add_new_item'               => 'Add New Range',
		'edit_item'                  => 'Edit Range',
		'update_item'                => 'Update Range',
		'view_item'                  => 'View Range',
		'separate_items_with_commas' => 'Separate ranges with commas',
		'add_or_remove_items'        => 'Add or remove ranges',
		'choose_from_most_used'      => 'Choose from the most used',
		'popular_items'              => 'Popular Ranges',
		'search_items'               => 'Search Ranges',
		'not_found'                  => 'Not Found',
		'no_terms'                   => 'No ranges',
		'items_list'                 => 'Ranges list',
		'items_list_navigation'      => 'Ranges list navigation',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'salary_range', array( 'job' ), $args );

}
//add_action( 'init', 'salary_range_custom_taxonomy', 0 );


// Register Working Pattern Custom Taxonomy
function working_pattern_custom_taxonomy() {

	$labels = array(
		'name'                       => 'Working Patterns',
		'singular_name'              => 'Working Pattern',
		'menu_name'                  => 'Working Patterns',
		'all_items'                  => 'All Patterns',
		'parent_item'                => 'Parent Pattern',
		'parent_item_colon'          => 'Parent Pattern:',
		'new_item_name'              => 'New Pattern Name',
		'add_new_item'               => 'Add New Pattern',
		'edit_item'                  => 'Edit Pattern',
		'update_item'                => 'Update Pattern',
		'view_item'                  => 'View Pattern',
		'separate_items_with_commas' => 'Separate patterns with commas',
		'add_or_remove_items'        => 'Add or remove patterns',
		'choose_from_most_used'      => 'Choose from the most used',
		'popular_items'              => 'Popular Patterns',
		'search_items'               => 'Search Patterns',
		'not_found'                  => 'Not Found',
		'no_terms'                   => 'No patterns',
		'items_list'                 => 'Patterns list',
		'items_list_navigation'      => 'Patterns list navigation',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'working_pattern', array( 'job' ), $args );

}
add_action( 'init', 'working_pattern_custom_taxonomy', 0 );


// Register Job Locations Custom Taxonomy
function job_locations_custom_taxonomy() {

	$labels = array(
		'name'                       => 'Job Locations',
		'singular_name'              => 'Job Location',
		'menu_name'                  => 'Job Location',
		'all_items'                  => 'All Locations',
		'parent_item'                => 'Parent Location',
		'parent_item_colon'          => 'Parent Location:',
		'new_item_name'              => 'New Location Name',
		'add_new_item'               => 'Add New Location',
		'edit_item'                  => 'Edit Location',
		'update_item'                => 'Update Location',
		'view_item'                  => 'View Location',
		'separate_items_with_commas' => 'Separate locations with commas',
		'add_or_remove_items'        => 'Add or remove locations',
		'choose_from_most_used'      => 'Choose from the most used',
		'popular_items'              => 'Popular Locations',
		'search_items'               => 'Search Locations',
		'not_found'                  => 'Not Found',
		'no_terms'                   => 'No locations',
		'items_list'                 => 'Locations list',
		'items_list_navigation'      => 'Locations list navigation',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'job_location', array( 'job' ), $args );

}
add_action( 'init', 'job_locations_custom_taxonomy', 0 );
