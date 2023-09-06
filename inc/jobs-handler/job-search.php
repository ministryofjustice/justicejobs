<?php

/**
 * Register job search vars
 *
 * @link https://codex.wordpress.org/Plugin_API/Filter_Reference/query_vars
 */
function job_search_register_query_vars( $vars ) {
    $vars[] = 'role-type';
    $vars[] = 'salary-min';
    $vars[] = 'working-pattern';
    $vars[] = 'location';
    $vars[] = 'radius';
    $vars[] = 'locations-relevant';


    return $vars;
}
add_filter( 'query_vars', 'job_search_register_query_vars' );
