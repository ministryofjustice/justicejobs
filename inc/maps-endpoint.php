<?php

add_action("wp_ajax_get_location_coordinates", "jj_get_location_coordinates");
add_action("wp_ajax_nopriv_get_location_coordinates", "jj_get_location_coordinates");

function jj_get_location_coordinates() {
    $result = array ("error" => false);
    $location = sanitize_text_field($_REQUEST['location']);

    if(! empty($location)) {

        $map_key = get_field('google_maps_api_key_location_lookup', 'option');

        if (strlen($map_key) > 0) {
            
            $maps_endpoint = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $location . "&key=" . $map_key . "&components=country:UK";
            $request = wp_remote_get($maps_endpoint);

            if (is_wp_error($request)) {
                $result["error"] = WP_Error::get_error_message();
            } else {
                $body = wp_remote_retrieve_body($request);

                $lookup_response = json_decode($body);

                if (is_array($lookup_response->results) && count($lookup_response->results) > 0) {

                    $lookup_result = $lookup_response->results[0];

                    $result['lat'] = $lookup_result->geometry->location->lat;
                    $result['lng'] = $lookup_result->geometry->location->lng;
                } else {
                    $result["error"] = 'Bad results';
                }
            }
        } else {
            $result["error"] = 'Map key missing';
        }
    } else {
        $result["error"] = 'Location not supplied';
    }

    $encoded_response = json_encode($result);

    echo $encoded_response;

    die();
}

