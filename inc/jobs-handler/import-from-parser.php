<?php

require_once(ABSPATH . "wp-load.php");

if (!function_exists('jj_import_from_parser')) {

    function jj_import_from_parser()
    {
        // Fetch data from the feed URL
        $response = wp_remote_get('https://cloud-platform-e218f50a4812967ba1215eaecede923f.s3.eu-west-2.amazonaws.com/feed-parser/moj-oleeo-structured.json');

        // Check for WP Error during the HTTP request
        if (is_wp_error($response)) {
            return false;
        }

        // Extract JSON body from the response
        $json = $response['body'];

        // Decode JSON into an associative array
        $feedDataArray = json_decode($json, true);
        
        // Check if JSON decoding was successful
        if (!$feedDataArray) {
            return false;
        }

        if(!$feedDataArray || !is_array($feedDataArray) || !array_key_exists('objectType', $feedDataArray)){
            return false;
        }
    
        if(!array_key_exists('objects', $feedDataArray) || empty($feedDataArray['objects'])){
            return false;
        }
    
        if($feedDataArray['objectType'] == 'job'){
            
            $importResult = jj_import_jobs($feedDataArray['objects']);
    
            if(!$importResult){
                return false;
            }
    
            return true;
        }




    }
}

if (!function_exists('jj_import_jobs')) {

    function jj_import_jobs($jobsArray)
    {
        $activeJobs = [];
        $maxItems = false;
    
        $count = 0;
        foreach ($jobsArray as $job) {
            if ($maxItems !== false && $count >= $maxItems) {
                break;
            }
    
            $jobPostID = jj_import_job($job);
    
            if (!is_numeric($jobPostID)) {
                continue;
            }
    
            $activeJobs[] = $jobPostID;
            $count++;
        }
    }
}

if (!function_exists('jj_import_job')) {
    function jj_import_job($job) {
        // Validate job data
        if (!array_key_exists('id', $job) || !array_key_exists('hash', $job) ||
            !array_key_exists('title', $job) || !array_key_exists('url', $job) ||
            !array_key_exists('closingDate', $job)) {
            return false;
        }

        // Extract job data
        $jobID = $job['id'];
        $jobHash = $job['hash'];
        $jobTitle = $job['title'];
        $jobURL = $job['url'];
        $closingDate = $job['closingDate'];

        // Check for empty required job data fields
        if (empty($jobID) || empty($jobHash) || empty($jobTitle) || empty($jobURL) || empty($closingDate)) {
            return false;
        }

        // Check if job exists
        $jobPostID = jj_check_job_exists($jobID);
        $jobTitle = $job['title'] . ' - ' . $jobID;
        // Insert or update job post and details
        if (!$jobPostID) {
            $jobPostID = jj_insert_job($jobID, $jobTitle);
            if (is_numeric($jobPostID)) {
                jj_update_job_details($jobPostID, $job);
            }
        } else {
            if (!jj_compare_job_hash($jobPostID, $jobHash)) {
                jj_update_job($jobPostID, $jobTitle);
                jj_update_job_details($jobPostID, $job);
            }
        }

        // Return the ID of the imported or updated job post
        return $jobPostID;
    }
}

if (!function_exists('jj_check_job_exists')) {
    function jj_check_job_exists($jobID) {
        $args = array(
            'post_type'   => 'job',
            'numberposts' => -1,
            'meta_query'  => array(
                array(
                    'key'     => 'job_id',
                    'value'   => $jobID,
                    'compare' => '=',
                )
            )
        );

        $jobsFoundArray = get_posts($args);

        if (count($jobsFoundArray) === 0) {
            return false;
        }

        $jobPostID = $jobsFoundArray[0]->ID;

        return $jobPostID;
    }
}

function jj_insert_job($jobID, $jobTitle) {
    $newJobArgs = array(
        'post_title'   => $jobTitle,
        'post_content' => ' ',
        'post_status'  => 'publish',
        'post_type'    => 'job'
    );

    // Insert the new job post
    $jobPostID = wp_insert_post($newJobArgs);

    // Check if the insertion was successful
    if (!$jobPostID) {
        return false;
    }

    // Update the job post's meta information with the provided job ID
    update_post_meta($jobPostID, 'job_id', $jobID);

    // Return the ID of the newly inserted job post
    return $jobPostID;
}

function jj_compare_job_hash($jobPostID, $newjobHash) {
    // Retrieve the old job hash from post meta
    $oldJobHash = get_post_meta($jobPostID, 'job_content_hash', true);
    return false;
    // Compare the old job hash with the new job hash
    if ($oldJobHash != $newjobHash) {
        return false;
    }

    // Return true if the hashes match
    return true;
}

function jj_update_job($jobPostID, $jobTitle) {
    $updateJobArgs = array(
        'ID'          => $jobPostID,
        'post_title'  => $jobTitle
    );

    // Update the job post with the new title
    $updateResult = wp_update_post($updateJobArgs);

    // Check if the update was successful
    if (!$updateResult) {
        return false;
    }

    // Return true if the update was successful
    return true;
}

function jj_update_job_details($jobPostID, $job){

    update_post_meta($jobPostID, 'job_content_hash', $job['hash']);
    update_post_meta($jobPostID, 'application_link', $job['url']);
    update_post_meta($jobPostID, 'closing_date', $job['closingDate']);

    $fields = [
        [
            'type' => 'meta',
            'jsonKey' => 'salaryMin',
            'metaKey' => 'salary_min'
        ],
        [
            'type' => 'meta',
            'jsonKey' => 'salaryMax',
            'metaKey' => 'salary_max'
        ],
        [
            'type' => 'meta',
            'jsonKey' => 'salaryLondon',
            'metaKey' => 'salary_london'
        ],
        [
            'type' => 'city',
            'jsonKey' => 'cities',
            'metaKey' => 'location'
        ],
        [
            'type' => 'tax',
            'jsonKey' => 'roleTypes',
            'taxKey' => 'role_type'
        ],
        [
            'type' => 'tax',
            'jsonKey' => 'contractTypes',
            'taxKey' => 'working_pattern',
        ],
        [
            'type' => 'tax',
            'jsonKey' => 'addresses',
            'taxKey' => 'job_location',
        ]
    ];

    // content
    // additional content
    // salary_range
    foreach($fields as $field){
    
        if(!array_key_exists('jsonKey', $field) || !array_key_exists('type', $field) || empty($field['jsonKey']) || empty($field['type'])){
            continue;
        }
        
        $jsonKey = $field['jsonKey'];

        if($field['type'] == 'meta'){

            if(!array_key_exists('metaKey', $field) || empty($field['metaKey'])){
                continue;
            }

            if(array_key_exists($jsonKey, $job) && !empty($job[$jsonKey])){

                if($field['metaKey'] == 'salary_min' || $field['metaKey'] == 'salary_max' || $field['metaKey'] == 'salary_london'){
                    if(!is_numeric($job[$jsonKey])){
                        $job[$jsonKey] = 0;
                    }
                }
                update_post_meta($jobPostID, $field['metaKey'], $job[$jsonKey]);
            }
            else {
                delete_post_meta($jobPostID, $field['metaKey']);
            }
        }
        else if($field['type'] == 'city'){
            
            if(!array_key_exists('metaKey', $field) || empty($field['metaKey'])){
                continue;
            }

            if(array_key_exists($jsonKey, $job) && !empty($job[$jsonKey])){

                if (count($job[$jsonKey]) > 1) {
                    $job_city = 'Multiple Locations';
                } else {
                    $job_city = $job[$jsonKey][0];
                }
                update_post_meta($jobPostID, $field['metaKey'], $job_city);
            }
            else {
                delete_post_meta($jobPostID, $field['metaKey']);
            }

        }
        else if($field['type'] == 'tax'){

            if(!array_key_exists('taxKey', $field) || empty($field['taxKey'])){
                continue;
            }

            if(array_key_exists($jsonKey, $job) && !empty($job[$jsonKey])){
                wp_set_object_terms($jobPostID, $job[$jsonKey], $field['taxKey']);
            }
            else {
                wp_set_object_terms($jobPostID, false, $field['taxKey']);
            }
        }
    }
}