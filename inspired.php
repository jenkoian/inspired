<?php
/*
Plugin Name: inspired
Plugin URI: http://jenkins-web.co.uk/inspired
Description: Plugin to bring in various content from social sites that have inspired you
Author: Ian Jenkins
Version: 1.0
Author URI: http://www.jenkins-web.co.uk
*/

/**
 * Admin options
 */
add_action('admin_menu', 'inspired_menu');

function inspired_menu() {
    add_options_page('inspired options', 'inspired options', 'manage_options', 'inspired-options', 'inspired_options');
}

function inspired_options() {
    if (!current_user_can('manage_options'))  {
        wp_die( __('You do not have sufficient permissions to access this page.') );
    }

    include_once 'inspired_admin.php';
}

// @todo: Tody up these includes, use a autoloader or boostrapper
include_once 'classes/InspiredController.php';
include_once 'classes/interface/Inspired.php';
include_once 'classes/api/DribbbleApi.php';
include_once 'classes/api/TumblrApi.php';
include_once 'classes/config/abstract/InspiredConfig.php';
include_once 'classes/config/DribbbleConfig.php';
include_once 'classes/config/TumblrConfig.php';
include_once 'classes/factory/InspiredFactory.php';

/**
 * Front end function
 */

/**
 * [inspired]
 * 
 * @param type $atts 
 * @todo Ditch the bespoke config for each site, just use $config->site = 'Dribbble' or similar
 */
function inspired_func() {
    
    $inspiredObj = new InspiredController();
    if ($dribbbleUsername = get_option('inspired_dribbble_username')) {
        $dribbbleConfig = new DribbbleConfig();
        $dribbbleConfig->url = 'http://api.dribbble.com/';
        $dribbbleConfig->username = $dribbbleUsername;
        $inspiredObj->addSiteConfig($dribbbleConfig);
    }
    if ($tumblrUsername = get_option('inspired_tumblr_username')) {
        $tumblrConfig = new TumblrConfig();
        $tumblrConfig->url = 'http://'.$tumblrUsername.'.tumblr.com/api/read';
        $tumblrConfig->username = $tumblrUsername;
        $inspiredObj->addSiteConfig($tumblrConfig);
    }      
    
    $items = $inspiredObj->getItems();
    
    echo '<pre>';
    print_r($items);
}

add_shortcode('inspired', 'inspired_func');

// Add shortcode support for widgets
//add_filter('widget_text', 'do_shortcode');
?>
