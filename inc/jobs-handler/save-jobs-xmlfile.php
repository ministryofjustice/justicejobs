<?php
// bootstrap WP
require_once(ABSPATH . "wp-load.php");

function save_jobs_xml_file($force_pull = false)
{
    // check admin hasn't switch the cron off, default is on
    if (get_option('jobs-cron-switch-input', '1') != '1') {
        return false;
    }

    // get admin email for messaging
    $to = get_option('admin_email');

    // should we run?
    if (!inside_schedule_window() && !$force_pull) {
        // fix potential broken 'cron is running' flag (due to nginx 504 timeout bug)
        if (is_2_hours_past_window() && get_option('jobs_request_cron_is_running') == true) {
            update_option('jobs_request_cron_is_running', false);
            jj_simple_mail($to, [
                '[Justice Jobs] Fixed broken flag',
                'BROKEN -> the jobs schedule was repaired.'
            ]);
        }
        return false;
    }

    if ($force_pull) {
        update_option('jobs_request_cron_is_running', false);
    }

    // check if this script is already running, bail if it is. Default to 'not running'.
    if (get_option('jobs_request_cron_is_running', false) == true) {
        jj_simple_mail($to, [
            '[Justice Jobs] Job script already running',
            'WARNING -> the jobs script is already running. A request to refresh the job list has failed.'
        ]);
        return false;
    }

    // we are ready to start, lock the script...
    update_option('jobs_request_cron_is_running', true);

    // get the uploads directory path
    $upload_dir = wp_get_upload_dir();

    $url = "https://justicejobs.tal.net/vx/mobile-0/appcentre-1/brand-2/candidate/jobboard/vacancy/3/feed/structured";
    $tmp = get_temp_dir() . "jobs.xml";
    $file = $upload_dir['basedir'] . "/job-feed/jobs.xml";

    $response = wp_remote_get($url, [
        'timeout' => 1800,
        'stream' => true,
        'filename' => $tmp
    ]);

    if (is_wp_error($response)) {
        jj_simple_mail($to, [
            '[Justice Jobs] Getting remote data',
            'WARNING -> We did not receive jobs data from the remote server. This could be a temporary error'
        ]);
        return false;
    }

    // let's check the data is xml
    if (!simplexml_load_file($tmp)) {
        // inform admin
        jj_simple_mail($to, [
            "[Justice Jobs] Security: error detected in jobs XML feed",
            "Please check the following URL for errors. The job feed load process failed in " . __FUNCTION__ . "\n\n" . $url
        ]);

        return false;
    }

    // copy the tmp file contents to system file
    if (copy($tmp, $file)) {
        // set flag to notify import process that data is refreshed
        update_option('jobs_request_has_updated', true);
        // clean up tmp file
        unlink($tmp);
    } else {
        jj_simple_mail($to, [
            '[Justice Jobs] Copying data',
            'WARNING -> jobs have not been saved successfully. The job save process has not completed which means the import process will not take place.'
        ]);
        return false;
    }

    // unlock this script for next schedule window
    update_option('jobs_request_cron_is_running', false);

    return true;
}
