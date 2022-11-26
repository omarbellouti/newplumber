<?php
function wvw_get_graph_array($visitor_type, $prefix_number)
{
    global $wpdb;

    $visitors_stat = 'visitors_stat';
    $visitors_stat = $wpdb->prefix . $visitors_stat;

    $out_array[] = array('', '');
    $current_time = current_time('timestamp', false);
    $beginOfDay = strtotime("midnight", $current_time);

    switch ($visitor_type) {
        case "visit_today":

            $slot_1_begin = $beginOfDay;
            $slot_1_end = $beginOfDay + (6 * HOUR_IN_SECONDS);
            $slot_1_amount = $wpdb->get_var("SELECT COUNT(*) FROM $visitors_stat WHERE time BETWEEN $slot_1_begin AND $slot_1_end ");
            $out_array[] = array(0, (int)$slot_1_amount);


            $slot_2_begin = $slot_1_end;
            $slot_2_end = $slot_1_end + (6 * HOUR_IN_SECONDS);
            $slot_2_amount = $wpdb->get_var("SELECT COUNT(*) FROM $visitors_stat WHERE time BETWEEN $slot_2_begin AND $slot_2_end ");
            $out_array[] = array(6, (int)$slot_2_amount);

            $slot_3_begin = $slot_2_end;
            $slot_3_end = $slot_2_end + (6 * HOUR_IN_SECONDS);
            $slot_3_amount = $wpdb->get_var("SELECT COUNT(*) FROM $visitors_stat WHERE time BETWEEN $slot_3_begin AND $slot_3_end ");
            $out_array[] = array(12, (int)$slot_3_amount);

            $slot_4_begin = $slot_3_end;
            $slot_4_end = $slot_3_end + (6 * HOUR_IN_SECONDS);
            $slot_4_amount = $wpdb->get_var("SELECT COUNT(*) FROM $visitors_stat WHERE time BETWEEN $slot_4_begin AND $slot_4_end ");

            $out_array[] = array(18, (int)$slot_4_amount);

            return '<input type="hidden" id="graph_info_' . $prefix_number . '" value=\'' . json_encode($out_array) . '\' />';

            break;
        case "visit_total":

            $slot_1_begin = time() - 4 * 30 * HOUR_IN_SECONDS;
            $slot_1_end = time() - 3 * 30 * HOUR_IN_SECONDS;
            $slot_1_amount = $wpdb->get_var("SELECT COUNT(*) FROM $visitors_stat WHERE time BETWEEN $slot_1_begin AND $slot_1_end ");
            $out_array[] = array('', (int)$slot_1_amount);


            $slot_2_begin = time() - 3 * 30 * HOUR_IN_SECONDS;
            $slot_2_end = time() - 2 * 30 * HOUR_IN_SECONDS;
            $slot_2_amount = $wpdb->get_var("SELECT COUNT(*) FROM $visitors_stat WHERE time BETWEEN $slot_2_begin AND $slot_2_end ");
            $out_array[] = array('', (int)$slot_2_amount);

            $slot_3_begin = time() - 2 * 30 * HOUR_IN_SECONDS;
            $slot_3_end = time() - 1 * 30 * HOUR_IN_SECONDS;
            $slot_3_amount = $wpdb->get_var("SELECT COUNT(*) FROM $visitors_stat WHERE time BETWEEN $slot_3_begin AND $slot_3_end ");
            $out_array[] = array('', (int)$slot_3_amount);

            $slot_4_begin = time() - 1 * 30 * HOUR_IN_SECONDS;
            $slot_4_end = time();
            $slot_4_amount = $wpdb->get_var("SELECT COUNT(*) FROM $visitors_stat WHERE time BETWEEN $slot_4_begin AND $slot_4_end ");

            $out_array[] = array('', (int)$slot_4_amount);

            return '<input type="hidden" id="graph_info_' . $prefix_number . '" value=\'' . json_encode($out_array) . '\' />';

            break;
        case "visit_live":

            $slot_1_begin = $beginOfDay;
            $slot_1_end = $beginOfDay + (6 * HOUR_IN_SECONDS);
            $slot_1_amount = count($wpdb->get_col("SELECT DISTINCT ip FROM $visitors_stat WHERE time BETWEEN $slot_1_begin AND $slot_1_end "));
            $out_array[] = array(0, (int)$slot_1_amount);


            $slot_2_begin = $slot_1_end;
            $slot_2_end = $slot_1_end + (6 * HOUR_IN_SECONDS);
            $slot_2_amount = count($wpdb->get_col("SELECT DISTINCT ip FROM $visitors_stat WHERE time BETWEEN $slot_2_begin AND $slot_2_end "));
            $out_array[] = array(6, (int)$slot_2_amount);

            $slot_3_begin = $slot_2_end;
            $slot_3_end = $slot_2_end + (6 * HOUR_IN_SECONDS);
            $slot_3_amount = count($wpdb->get_col("SELECT DISTINCT ip FROM $visitors_stat WHERE time BETWEEN $slot_3_begin AND $slot_3_end "));
            $out_array[] = array(12, (int)$slot_3_amount);

            $slot_4_begin = $slot_3_end;
            $slot_4_end = $slot_3_end + (6 * HOUR_IN_SECONDS);
            $slot_4_amount = count($wpdb->get_col("SELECT DISTINCT ip FROM $visitors_stat WHERE time BETWEEN $slot_4_begin AND $slot_4_end "));

            $out_array[] = array(18, (int)$slot_4_amount);

            return '<input type="hidden" id="graph_info_' . $prefix_number . '" value=\'' . json_encode($out_array) . '\' />';
            break;
    }
}

?>