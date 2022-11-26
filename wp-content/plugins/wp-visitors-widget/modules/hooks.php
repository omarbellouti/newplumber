<?php
ini_set('session.gc-maxlifetime', DAY_IN_SECONDS); // extend PHP session time

add_filter('wp_loaded', 'wvw_init');
function wvw_init()
{
    global $wpdb;

    $visitors_stat = 'visitors_stat';
    $visitors_stat = $wpdb->prefix . $visitors_stat;

    if (!session_id()) {
        session_start();
    }
    if (!isset($_SESSION['visit_trace_ip'])) {
        $_SESSION['visit_trace_ip'] = $_SERVER['REMOTE_ADDR'];
        $wpdb->insert(
            $visitors_stat,
            array(
                'time' => current_time('timestamp', false),
                'ip' => $_SERVER['REMOTE_ADDR']
            ),
            array(
                '%s',
                '%s'
            )
        );
    }
}