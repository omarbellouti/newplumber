<?php
/*
Plugin Name: Live Visitor Counter
Plugin URI: http://visitorplugin.com
Description: Adds a widget showing the visitor how many live visitors is on the page.
Version: 2.1
Author: Adam Z
Stable tag: 2.1
*/

//error_reporting(E_ALL);
//ini_set('display_errors', 'On');


// core initiation
if (!class_Exists('vooMainVisitorsClass')) {
    class vooMainVisitorsClass
    {
        var $locale;

        function __construct($locale, $includes, $path)
        {
            $this->locale = $locale;

            // include files
            foreach ($includes as $single_path) {
                require_once($path . $single_path);
            }

            register_activation_hook(__FILE__, array($this, 'plugin_activated'));

            // calling localization
            add_action('init', array($this, 'plugin_init'));
        }

        function plugin_init()
        {
            $languages_dir = basename(dirname(__FILE__)) . '/languages';
            load_plugin_textdomain("wvw", false, $languages_dir);
        }

        function plugin_activated()
        {
            global $wpdb;
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

            $visitors_stat = 'visitors_stat';
            $table = $wpdb->prefix . $visitors_stat;

            $sql = "CREATE TABLE IF NOT EXISTS {$table} (
				`id` mediumint(9) NOT NULL AUTO_INCREMENT,
				`time` varchar(12) NOT NULL,
				`ip` varchar(25) NOT NULL,
				UNIQUE KEY `id` (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

            dbDelta($sql);
        }
    }

    function wvw_uninstall()
    {
        global $wpdb;

        $visitors_stat = 'visitors_stat';
        $table = $wpdb->prefix . $visitors_stat;
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        $wpdb->query("DROP TABLE {$table}");
    }

    register_uninstall_hook(__FILE__, 'wvw_uninstall');
}


// initiate main class
new vooMainVisitorsClass('wvw', array(
    'modules/scripts.php',
    'modules/hooks.php',
    'modules/shortcodes.php',
    'modules/widgets.php',
    'modules/functions.php',
), dirname(__FILE__) . '/');

?>