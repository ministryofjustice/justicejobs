<?php

$value = get_option('jobs-cron-switch-input', '1'); // catches first time use and turns the CRON on

$checked = '';
if ($value === '1') {
    $checked = ' checked="checked"';
}

// options
$is_running = get_option('jobs_request_cron_is_running');
$jobs_available = get_option('jobs_request_has_updated');
$next_schedule = wp_next_scheduled('save_xml_cron_hook');
$next_import = wp_next_scheduled('update_jobs_cron_hook');

echo '<h1>Jobs CRON Settings</h1>
            <h2 style="color:#cc0000"><em>Settings on this page can adversely affect the site.</em></h2>
            <p>Use this page to switch on/off the job feeds CRON.<br>Please be careful.</p>
            ' . jobs_cron_display_notice($value) . '
            <form method="POST">
                <label for="jobs_cron_switch_input">Jobs CRON activate? </label>
                <input type="checkbox" name="jobs_cron_switch_input" id="jobs_cron_switch_input" value="1" ' . $checked . '>
                <input type="hidden" name="jobs_cron_checker" value="1">
                <br><br><button type="submit" value="Save" class="button button-primary button-large">Save</button>
            </form>
            <br>
            <hr>
            <div>
                <h2>Current Settings</h2>
                <table>
                <thead>
                    <tr>
                        <th style="text-align: left">Description</th>
                        <th style="text-align: left">Value</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Is the jobs save cron running? </td><td><strong>' . ($is_running == true ? 'Yes' : 'No') . '</strong></td></tr>
                    <tr><td>Are jobs ready to import? </td><td><strong>' . ($jobs_available == true ? 'Yes' : 'No') . '</strong></td></tr>
                    <tr><td>Hours when jobs save occurs: </td><td><strong>' . implode(', ', jj_scheduled_hours()) . '</strong></td></tr>
                    <tr><td>Save XML CRON will run at: </td><td><strong>' . date("H:i:s", $next_schedule) . '</strong></td></tr>
                    <tr><td>Update Jobs CRON will run at: </td><td><strong>' . date("H:i:s", $next_import) . '</strong></td></tr>
                </tbody>
                </table>
            </div>';
