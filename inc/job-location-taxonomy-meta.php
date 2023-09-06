<?php

//Fixes issue that when a job location is created by script that the acf map meta field is not populated
add_action( 'created_job_location', 'jj_set_location_lng_and_lat');
function jj_set_location_lng_and_lat() {
    $arguments = func_get_args();

    if(is_array($arguments) && is_numeric($arguments[0])){
        $term_id = $arguments[0];

        $term = get_term_by('id', $term_id, 'job_location');

        $job_location = get_field('the_job_location', $term);

        if(empty($job_location) == true){

            $map_key = get_field('google_maps_api_key_location_lookup', 'option');

            if (strlen($map_key) > 0) {
                $maps_endpoint = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $term->name . "&key=" . $map_key . "&components=country:UK";
                $request = wp_remote_get($maps_endpoint);

                if (is_wp_error($request)) {
                    $result["error"] = WP_Error::get_error_message();
                } else {

                    $body = wp_remote_retrieve_body($request);

                    $lookup_response = json_decode($body);

                    if (is_array($lookup_response->results) && count($lookup_response->results) > 0) {

                        $lookup_result = $lookup_response->results[0];

                        $lat = $lookup_result->geometry->location->lat;
                        $lng = $lookup_result->geometry->location->lng;
                        $zoom = 16; //zoom not used

                        $value = array("address" => $term->name, "lat" => $lat, "lng" => $lng, "zoom" => $zoom);
                        update_field('the_job_location', $value, "job_location_".$term_id);



                    }
                }
            }

        }

    }

}