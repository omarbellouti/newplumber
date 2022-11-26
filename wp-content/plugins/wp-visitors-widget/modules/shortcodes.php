<?php
add_shortcode('visitors_widget', 'wvw_visitors_widget');
function wvw_visitors_widget($atts, $content = null)
{
    global $wpdb;

    $widget_rand = rand(999, 10000);

    $out = '<input type="hidden" class="random_prefix_val" value="' . $widget_rand . '" />';

    $type = $atts['type'];
    $colors = $atts['colors'];
    $shadow = $atts['shadow'];
    $initial_value = (int)$atts['initial_value'];

    if (in_array($type, ["3", "5"])) {
        add_Action('wp_footer', function () {
            ?>
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <link href="https://fonts.googleapis.com/css?family=Exo+2" rel="stylesheet">
            <?php
        });
    }

    $data_1_param = $atts['data_1'];
    $data_2_param = $atts['data_2'];
    $data_3_param = $atts['data_3'];


    $visitors_stat = 'visitors_stat';
    $visitors_stat = $wpdb->prefix . $visitors_stat;

    $logo_image = plugins_url('/images/logo-dark-copy-2.png', __FILE__);
    $plugin_url = 'https://visitorplugin.com/';

    // get visitors per day
    $current_timestamp = current_time('timestamp', false);
    $beginOfDay = strtotime("midnight", $current_timestamp);
    $endOfDay = strtotime("tomorrow", $beginOfDay) - 1;

    $all_today_visitors = $wpdb->get_var("SELECT COUNT(*) FROM $visitors_stat WHERE time BETWEEN $beginOfDay AND $endOfDay ");

    // get all visitors total
    $all_total_visitors = $wpdb->get_var("SELECT COUNT(*) FROM $visitors_stat ") + $initial_value;

    // get last active users
    $start_time = $current_timestamp - 5 * HOUR_IN_SECONDS;
    $end_time = $current_timestamp;
    $all_active_users = count($wpdb->get_col("SELECT DISTINCT ip FROM $visitors_stat WHERE time BETWEEN $start_time AND $end_time "));


    // graph info

    $out_graph = "";
    switch ($data_1_param) {
        case "visit_today":
            $text_1 = __('Visitors Today', "wvw");
            $data_1 = $all_today_visitors;
            $out_graph = wvw_get_graph_array("visit_today", $widget_rand);

            break;
        case "visit_total":
            $text_1 = __("Total Visitors", "wvw");
            $data_1 = $all_total_visitors;
            $out_graph = wvw_get_graph_array("visit_total", $widget_rand);
            break;
        case "visit_live":
            $text_1 = '<div class="pulsing_overlap_small"><div class="pulsating-circle"></div></div>' . __("Live visitors", "wvw");
            $data_1 = $all_active_users;
            $out_graph = wvw_get_graph_array("visit_live", $widget_rand);
            break;
    }
    switch ($data_2_param) {
        case "visit_today":
            $text_2 = __('Visitors Today', "wvw");
            $data_2 = $all_today_visitors;

            break;
        case "visit_total":
            $text_2 = __("Total Visitors", "wvw");
            $data_2 = $all_total_visitors;
            break;
        case "visit_live":
            $text_2 = '<div class="pulsing_overlap_small"><div class="pulsating-circle"></div></div>' . __("Live visitors", "wvw");
            $data_2 = $all_active_users;
            break;
    }
    switch ($data_3_param) {
        case "visit_today":
            $text_3 = '<div>' . __("Visitors", "wvw") . '</div> <div>' . __("Today", "wvw") . '</div>';
            $data_3 = $all_today_visitors;

            break;
        case "visit_total":
            $text_3 = '<div>' . __("Total", "wvw") . '</div> <div>' . __("Visitors", "wvw") . '</div>';
            $data_3 = $all_total_visitors;
            break;
        case "visit_live":
            //$text_3 = '<div>Live</div> <div>visitors</div>';
            $text_3 = '<div class="pulsing_overlap_small"><div class="pulsating-circle"></div></div>' . __("Live visitors", "wvw");
            $data_3 = $all_active_users;
            break;
    }


    // graph info
    $out .= $out_graph;

    switch ($type) {
        case "1":
            $out .= '
			<style>';
            if ($shadow) {

                switch ($colors) {
                    case "light":
                        $out .= '
						.widget_type_1.visitor_widget{
							box-shadow: 0px 25px 46px 0 rgba(51, 59, 69, 0.15);
						}
						';
                        break;
                    case "light_transparent":
                        $out .= '
						.widget_type_1.visitor_widget{
							box-shadow: 0px 25px 46px 0 rgba(51, 59, 69, 0.15);
						}
						';
                        break;
                    case "dark_transparent":
                        $out .= '
						.widget_type_1.visitor_widget{
							box-shadow: 0px 15px 40px 0 rgba(42, 64, 145, 0.35);
						}
						';
                        break;
                }


            }

            switch ($colors) {
                case "light":
                    $bg_color = '#ffffff';
                    $fontcolor = '#354052';
                    $border_color = '#e6eaee';
                    break;
                case "light_transparent":
                    $bg_color = 'transparent';
                    $fontcolor = '#354052';
                    $border_color = '#e6eaee';
                    break;
                case "dark_transparent":
                    $bg_color = 'transparent';
                    $fontcolor = '#f4f6fc';
                    $border_color = '#171717';
                    break;
                default:
                    $bg_color = '#ffffff';
                    $fontcolor = '#354052';
                    $border_color = '#e6eaee';
                    break;
            }


            $out .= '
			.widget_type_1{
				border:1px solid ' . $border_color . ';
				border-radius: 4px;
				max-width:176px;
				background-color: ' . $bg_color . ';
				position:relative;
			}
			.widget_type_1 .type_1_big{
				font-family: "Exo 2", sans-serif;
				  font-size: 42px;
				  font-weight: 300;
				  font-style: normal;
				  font-stretch: normal;
				  line-height: normal;
				  letter-spacing: normal;
				  text-align: center;
				  color: ' . $fontcolor . ';
				  margin-top:30px;
				margin-bottom: 5px;
			}
			.widget_type_1 .type_1_small{
				font-size: 11px;
				  font-weight: 600;
				  font-style: normal;
				  font-stretch: normal;
				  margin-bottom: 50px;
				  letter-spacing: 0.8px;
				  text-align: center;
				  color: #b7c0cd;
				  text-transform:uppercase;
			}
			.widget_type_1 .bottom_branding{
				position:absolute;
				bottom:0px;
				left:0px;
				right:0px;
				padding:5px;
				text-align:center;
			}
			</style>
			<div class="visitor_widget widget_type_1">
				<div class="type_1_big">' . $data_1 . '</div>
				<div class="type_1_small">' . $text_1 . '</div>
				<div class="bottom_branding">				 
                    <a href="' . $plugin_url . '">
                        <img src="' . $logo_image . '" width="80" />
                    </a> 			 
				</div>
			</div>
			';
            break;
        case "2":
            $out .= '
			<style>';
            if ($shadow) {

                switch ($colors) {
                    case "light":
                        $out .= '
						.widget_type_2.visitor_widget{
							box-shadow: 0px 25px 46px 0 rgba(51, 59, 69, 0.15);
						}
						';
                        break;
                    case "light_transparent":
                        $out .= '
						.widget_type_2.visitor_widget{
							box-shadow: 0px 25px 46px 0 rgba(51, 59, 69, 0.15);
						}
						';
                        break;
                    case "dark_transparent":
                        $out .= '
						.widget_type_2.visitor_widget{
							box-shadow: 0px 15px 40px 0 rgba(42, 64, 145, 0.35);
						}
						';
                        break;
                }


            }

            switch ($colors) {
                case "light":
                    $bg_color = '#ffffff';
                    $fontcolor = '#354052';
                    $border_color = '#e6eaee';
                    break;
                case "light_transparent":
                    $bg_color = 'transparent';
                    $fontcolor = '#354052';
                    $border_color = '#e6eaee';
                    break;
                case "dark_transparent":
                    $bg_color = 'transparent';
                    $fontcolor = '#f4f6fc';
                    $border_color = '#171717';
                    break;
                default:
                    $bg_color = '#ffffff';
                    $fontcolor = '#354052';
                    $border_color = '#e6eaee';
                    break;
            }
            $out .= '
			.widget_type_2{
				border:1px solid ' . $border_color . ';
				border-radius: 4px;
				max-width:176px;
				background-color: ' . $bg_color . ';
				position:relative;
				font-family: "Exo 2", sans-serif;
			}
			.widget_type_2 .type_2_row_1{
		 
				  font-size: 36px;
				  font-weight: 300;
				  font-style: normal;
				  font-stretch: normal;
				  line-height: normal;
				  letter-spacing: normal;
				  text-align: center;
				  color: ' . $fontcolor . ';
					margin-top:20px;
					margin-bottom: 5px;
			}
			.widget_type_2 .type_2_row_2{
				font-size: 11px;
				line-height: 11px;
				font-weight: 600;
				font-style: normal;
				font-stretch: normal;
				text-transform:uppercase;
				letter-spacing: 0.8px;
				text-align: center;
				color: #b7c0cd;
				margin-bottom: 20px;
			}
			.widget_type_2 .type_2_row_3{
				font-size: 20px;
				  font-weight: 300;
				  font-style: normal;
				  font-stretch: normal;
				  line-height: normal;
				  letter-spacing: normal;
				  text-align: center;
				  color: ' . $fontcolor . ';
			}
			.widget_type_2 .type_2_row_4{
				font-size: 11px;
				  font-weight: 600;
				  font-style: normal;
				  font-stretch: normal;
				  letter-spacing: 0.8px;
				  text-align: center;
				  color: #b7c0cd;
				  margin-bottom:40px;
				  text-transform:uppercase;
			}
			.widget_type_2 .bottom_branding{
				position:absolute;
				bottom:0px;
				left:0px;
				right:0px;
				padding:5px;
				text-align:center;
			}
			</style>
			<div class="visitor_widget widget_type_2">
				<div class="type_2_row_1">' . $data_1 . '</div>
				<div class="type_2_row_2">' . $text_1 . '</div>
				<div class="type_2_row_3">' . $data_2 . '</div>
				<div class="type_2_row_4">' . $text_2 . '</div>
				<div class="bottom_branding">
                    <a href="' . $plugin_url . '">
                        <img src="' . $logo_image . '" width="80" />
                    </a>
				</div>
			</div>
			';
            break;
        case "3":
            $out .= '
			<style>';
            if ($shadow) {

                switch ($colors) {
                    case "light":
                        $out .= '
						.widget_type_3.visitor_widget{
							box-shadow: 0px 25px 46px 0 rgba(51, 59, 69, 0.15);
						}
						';
                        break;
                    case "light_transparent":
                        $out .= '
						.widget_type_3.visitor_widget{
							box-shadow: 0px 25px 46px 0 rgba(51, 59, 69, 0.15);
						}
						';
                        break;
                    case "dark_transparent":
                        $out .= '
						.widget_type_3.visitor_widget{
							box-shadow: 0px 15px 40px 0 rgba(42, 64, 145, 0.35);
						}
						';
                        break;
                }


            }

            switch ($colors) {
                case "light":
                    $bg_color = '#ffffff';
                    $fontcolor = '#354052';
                    $border_color = '#e6eaee';
                    break;
                case "light_transparent":
                    $bg_color = 'transparent';
                    $fontcolor = '#354052';
                    $border_color = '#e6eaee';
                    break;
                case "dark_transparent":
                    $bg_color = 'transparent';
                    $fontcolor = '#f4f6fc';
                    $border_color = '#171717';
                    break;
                default:
                    $bg_color = '#ffffff';
                    $fontcolor = '#354052';
                    $border_color = '#e6eaee';
                    break;
            }
            $out .= '
			.widget_type_3{
				border:1px solid ' . $border_color . ';
				border-radius: 4px;
				max-width:176px;
				background-color: ' . $bg_color . ';
				position:relative;
			}
			.widget_type_3 .type_1_big{
				font-family: "Exo 2", sans-serif;
				  font-size: 42px;
				  font-weight: 300;
				  font-style: normal;
				  font-stretch: normal;
				  line-height: normal;
				  letter-spacing: normal;
				  text-align: center;
				  color: ' . $fontcolor . ';
				  margin-top:10px;
				margin-bottom: 5px;
			}
			.widget_type_3 .type_1_graph{
				overflow: hidden;
				height: 80px;
			}
			.widget_type_3 .type_1_graph #chart_div{
				height: 100px;
			}
			.widget_type_3 .type_1_small{
				font-size: 11px;
				  font-weight: 600;
				  font-style: normal;
				  font-stretch: normal;
				  margin-bottom1: 40px;
				  letter-spacing: 0.8px;
				  text-align: center;
				  color: #b7c0cd;
				  text-transform:uppercase;
			}
			.widget_type_3 .bottom_branding{
				position:absolute;
				bottom:0px;
				left:0px;
				right:0px;
				padding:5px;
				text-align:center;
			}
			</style>
			<div class="visitor_widget widget_type_3">
				<div class="type_1_big">' . $data_1 . '</div>
				<div class="type_1_small">' . $text_1 . '</div>
				<div class="type_1_graph"> <div id="chart_div_' . $widget_rand . '"></div></div>
				<div class="bottom_branding">
                    <a href="' . $plugin_url . '">
                        <img src="' . $logo_image . '" width="80" />
                    </a>
				</div>
			</div>
			';
            break;
        case "4":
            $out .= '
			<style>';
            if ($shadow) {

                switch ($colors) {
                    case "light":
                        $out .= '
						.widget_type_4.visitor_widget{
							box-shadow: 0px 25px 46px 0 rgba(51, 59, 69, 0.15);
						}
						';
                        break;
                    case "light_transparent":
                        $out .= '
						.widget_type_4.visitor_widget{
							box-shadow: 0px 25px 46px 0 rgba(51, 59, 69, 0.15);
						}
						';
                        break;
                    case "dark_transparent":
                        $out .= '
						.widget_type_4.visitor_widget{
							box-shadow: 0px 15px 40px 0 rgba(42, 64, 145, 0.35);
						}
						';
                        break;
                }


            }

            switch ($colors) {
                case "light":
                    $bg_color = '#ffffff';
                    $fontcolor = '#354052';
                    $border_color = '#e6eaee';
                    break;
                case "light_transparent":
                    $bg_color = 'transparent';
                    $fontcolor = '#354052';
                    $border_color = '#e6eaee';
                    break;
                case "dark_transparent":
                    $bg_color = 'transparent';
                    $fontcolor = '#f4f6fc';
                    $border_color = '#171717';
                    break;
                default:
                    $bg_color = '#ffffff';
                    $fontcolor = '#354052';
                    $border_color = '#e6eaee';
                    break;
            }
            $out .= '
			.widget_type_4{
				border:1px solid ' . $border_color . ';
				border-radius: 4px;
				max-width:176px;
				background-color: ' . $bg_color . ';
				position:relative;
				font-family: "Exo 2", sans-serif;
			}
			.widget_type_4 .type_4_row_1{
		 
					font-size: 11px;
					font-weight: 600;
					font-style: normal;
					font-stretch: normal;
					text-transform:uppercase;
					letter-spacing: 0.8px;
					text-align: center;
					color: #b7c0cd;
					margin-top:30px;
					 
			}
			.widget_type_4 .type_4_row_2{
		 
					font-size: 32px;
					line-height: 32px;
					  font-weight: 300;
					  font-style: normal;
					  font-stretch: normal;
					 
					  letter-spacing: normal;
					  text-align: center;
					  color: ' . $fontcolor . ';
					 
					margin-bottom: 30px;
			}
			.widget_type_4 .type_4_row_3{
		 
					font-size: 18px;
					  font-weight: 300;
					  font-style: normal;
					  font-stretch: normal;
					  line-height: normal;
					  letter-spacing: normal;
					  text-align: center;
					  color: ' . $fontcolor . ';
					margin-top:5px;
					margin-bottom: 0px;
			}
			.widget_type_4 .type_4_row_4{
		 
					font-size: 10px;
					  font-weight: 600;
					  font-style: normal;
					  font-stretch: normal;
					  text-transform: uppercase;
					  letter-spacing: 0.5px;
					  text-align: center;
					  color: #b7c0cd;
					margin-top:0px;
					margin-bottom: 30px;
			}
			.widget_type_4 .type_4_row_5{
		 
					font-size: 18px;
					  font-weight: 300;
					  font-style: normal;
					  font-stretch: normal;
					  line-height: normal;
					  letter-spacing: normal;
					  text-align: center;
					  color: ' . $fontcolor . ';
					margin-top:5px;
					margin-bottom: 0px;
			}
			.widget_type_4 .type_4_row_6{
		 
					 font-size: 10px;
					  font-weight: 600;
					  font-style: normal;
					  font-stretch: normal;
					  text-transform: uppercase;
					  letter-spacing: 0.5px;
					  text-align: center;
					  color: #b7c0cd;
					margin-top:0px;
					margin-bottom: 50px;
			}
			 
			.widget_type_4 .bottom_branding{
				position:absolute;
				bottom:0px;
				left:0px;
				right:0px;
				padding:5px;
				text-align:center;
			}
			</style>
			<div class="visitor_widget widget_type_4">
				<div class="type_4_row_1">' . $text_1 . '</div>
				<div class="type_4_row_2">' . $data_1 . '</div>
				<div class="type_4_row_3">' . $data_2 . '</div>
				<div class="type_4_row_4">' . $text_2 . '</div>
				<div class="type_4_row_5">' . $data_3 . '</div>
				<div class="type_4_row_6">' . $text_3 . '</div>
				 
				<div class="bottom_branding">
                    <a href="' . $plugin_url . '">
                        <img src="' . $logo_image . '" width="80" />
                    </a>
				</div>
			</div>
			';
            break;

        case "5":
            $out .= '
			<style>';
            if ($shadow) {

                switch ($colors) {
                    case "light":
                        $out .= '
						.widget_type_5.visitor_widget{
							box-shadow: 0px 25px 46px 0 rgba(51, 59, 69, 0.15);
						}
						';
                        break;
                    case "light_transparent":
                        $out .= '
						.widget_type_5.visitor_widget{
							box-shadow: 0px 25px 46px 0 rgba(51, 59, 69, 0.15);
						}
						';
                        break;
                    case "dark_transparent":
                        $out .= '
						.widget_type_5.visitor_widget{
							box-shadow: 0px 15px 40px 0 rgba(42, 64, 145, 0.35);
						}
						';
                        break;
                }


            }

            switch ($colors) {
                case "light":
                    $bg_color = '#ffffff';
                    $fontcolor = '#354052';
                    $border_color = '#e6eaee';
                    break;
                case "light_transparent":
                    $bg_color = 'transparent';
                    $fontcolor = '#354052';
                    $border_color = '#e6eaee';
                    break;
                case "dark_transparent":
                    $bg_color = 'transparent';
                    $fontcolor = '#f4f6fc';
                    $border_color = '#171717';
                    break;
                default:
                    $bg_color = '#ffffff';
                    $fontcolor = '#354052';
                    $border_color = '#e6eaee';
                    break;
            }
            $out .= '
			.widget_type_5{
				border:1px solid ' . $border_color . ';
				border-radius: 4px;
				max-width:176px;
				background-color: ' . $bg_color . ';
				position:relative;
				font-family: "Exo 2", sans-serif;
			}
			.widget_type_5 .type_5_row_1{
		 
					font-size: 11px;
					font-weight: 600;
					font-style: normal;
					font-stretch: normal;
					text-transform:uppercase;
					letter-spacing: 0.8px;
					text-align: center;
					color: #b7c0cd;
					margin-top:30px;
					 
			}
			.widget_type_5 .type_5_row_2{
		 
					font-size: 32px;
					line-height: 32px;
					  font-weight: 300;
					  font-style: normal;
					  font-stretch: normal;
					 
					  letter-spacing: normal;
					  text-align: center;
					  color: ' . $fontcolor . ';
					 
					margin-bottom: 10px;
			}
			.widget_type_5 .type_4_row_3{
		 
					font-size: 18px;
					  font-weight: 300;
					  font-style: normal;
					  font-stretch: normal;
					  line-height: normal;
					  letter-spacing: normal;
					  text-align: center;
					  color: ' . $fontcolor . ';
					margin-top:10px;
					margin-bottom: 10px;
			}
			.widget_type_5 .type_5_row_4{
		 
					font-size: 10px;
					  font-weight: 600;
					  font-style: normal;
					  font-stretch: normal;
					  text-transform: uppercase;
					  letter-spacing: 0.5px;
					  text-align: center;
					  color: #b7c0cd;
					margin-top:0px;
					margin-bottom: 30px;
			}
			.widget_type_5 .type_5_row_3{
				overflow: hidden;
				height: 100px;
			}
			.widget_type_5 .type_5_row_3 #chart_div_5{
				height: 100px;
			}
			.widget_type_5 .type_5_row_5{
		 
					font-size: 18px;
					  font-weight: 300;
					  font-style: normal;
					  font-stretch: normal;
					  line-height: normal;
					  letter-spacing: normal;
					  text-align: center;
					  color: ' . $fontcolor . ';
					margin-top:5px;
					margin-bottom: 0px;
			}
			.widget_type_5 .type_5_row_6{
		 
					 font-size: 10px;
					  font-weight: 600;
					  font-style: normal;
					  font-stretch: normal;
					  text-transform: uppercase;
					  letter-spacing: 0.5px;
					  text-align: center;
					  color: #b7c0cd;
					margin-top:0px;
					margin-bottom: 50px;
			}
			 
			.widget_type_5 .bottom_branding{
				position:absolute;
				bottom:0px;
				left:0px;
				right:0px;
				padding:5px;
				text-align:center;
			}
			</style>';

            $out .= '
			<div class="visitor_widget widget_type_5">
				<div class="type_5_row_1">' . $text_1 . '</div>
				<div class="type_5_row_2">' . $data_1 . '</div>
				<div class="type_5_row_3"><div id="chart_div_' . $widget_rand . '"></div></div>
				 
				<div class="type_5_row_5">' . $data_2 . '</div>
				<div class="type_5_row_6">' . $text_2 . '</div>
				 
				<div class="bottom_branding">
                    <a href="' . $plugin_url . '">
                        <img src="' . $logo_image . '" width="80" />
                    </a>
				</div>
			</div>
			';
            break;
        case "6":

            switch ($data_1_param) {
                case "visit_today":

                    $text_1 = '<div>' . __("Visitors", "wvw") . '</div> <div>' . __("Today", "wvw") . '</div>';
                    $data_1 = $all_today_visitors;

                    break;
                case "visit_total":

                    $text_1 = '<div>' . __("Total", "wvw") . '</div> <div>' . __("Visitors", "wvw") . '</div>';
                    $data_1 = $all_total_visitors;
                    break;
                case "visit_live":

                    $text_1 = '<div>' . __("Live", "wvw") . '</div> <div>' . __("visitors", "wvw") . '</div>';
                    $data_1 = $all_active_users;
                    break;
            }

            $out .= '<style>';

            if ($shadow) {

                switch ($colors) {
                    case "light":
                        $out .= '
						.widget_type_6.visitor_widget{
							box-shadow: 0px 25px 46px 0 rgba(51, 59, 69, 0.15);
						}
						';
                        break;
                    case "light_transparent":
                        $out .= '
						.widget_type_6.visitor_widget{
							box-shadow: 0px 25px 46px 0 rgba(51, 59, 69, 0.15);
						}
						';
                        break;
                    case "dark_transparent":
                        $out .= '
						.widget_type_6.visitor_widget{
							box-shadow: 0px 15px 40px 0 rgba(42, 64, 145, 0.35);
						}
						';
                        break;
                }


            }

            switch ($colors) {
                case "light":
                    $bg_color = '#f5f8fa';
                    $fontcolor = '#354052';
                    $border_color = '#e6eaee';
                    break;
                case "light_transparent":
                    $bg_color = 'transparent';
                    $fontcolor = '#354052';
                    $border_color = '#e6eaee';
                    break;
                case "dark_transparent":
                    $bg_color = 'transparent';
                    $fontcolor = '#f4f6fc';
                    $border_color = '#171717';
                    break;
                default:
                    $bg_color = '#f5f8fa';
                    $fontcolor = '#354052';
                    $border_color = '#e6eaee';
                    break;
            }
            $out .= '
			.widget_type_6{
				overflow:hidden;
				border:1px solid ' . $border_color . ';
				border-radius: 4px;
				max-width:176px;
				background-color: ' . $bg_color . ';
				position:relative;
				font-family: "Exo 2", sans-serif;
			}
			.widget_type_6 .left_col{
				width:50%;
				float:left;
			}
			.widget_type_6 .right_col{
				width:50%;
				float:left;
				padding-top: 2px;
			}
			.widget_type_6 .left_col .count_num{
				float:left;
				 margin-right: 5px;
				     padding: 5px;
				  font-size: 14px;
				  font-weight: 300;
				  font-style: normal;
				  font-stretch: normal;
				  line-height: normal;
				  letter-spacing: normal;
				  text-align: left;
				  color: ' . $fontcolor . ';
			}
			.widget_type_6 .left_col .count_text{
					font-size: 8px;
				  font-weight: 500;
				  font-style: normal;
				  font-stretch: normal;
				text-transform:uppercase;
				  letter-spacing: 0.8px;
				  text-align: left;
				  color: #b7c0cd;
			}
			</style>
			<div class="visitor_widget widget_type_6">
				<div class="left_col">
					<div class="count_num">
						' . $data_1 . '
					</div>
					<div class="count_text">
						' . $text_1 . '
					</div>
				</div>
				<div class="right_col">
                    <a href="' . $plugin_url . '">
                        <img src="' . $logo_image . '" width="80" />
                    </a>
				</div>
			</div>
			';
            break;
    }

    return $out;
}


?>