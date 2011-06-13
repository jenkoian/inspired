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
include_once 'classes/api/LastfmApi.php';
include_once 'classes/config/abstract/InspiredConfig.php';
include_once 'classes/config/DribbbleConfig.php';
include_once 'classes/config/TumblrConfig.php';
include_once 'classes/config/LastfmConfig.php';
include_once 'classes/factory/InspiredFactory.php';

/**
 * Front end function
 */

/**
 * [inspired]
 * @todo Move the following stuff into a class?
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
    if ($lastfmUsername = get_option('inspired_lastfm_username')) {
        $lastfmConfig = new LastfmConfig();
        $lastfmConfig->url = 'http://ws.audioscrobbler.com/2.0/?method=user.getlovedtracks';
        $lastfmConfig->username = $lastfmUsername;
        $lastfmConfig->key = get_option('inspired_lastfm_key');
        $inspiredObj->addSiteConfig($lastfmConfig);        
        
    }
    
// @todo
//    if ($orderbyDate = get_option('inspired_orderby_date')) {
//        $inspiredObj->orderByDate($orderByDate);
//    }
    $items = $inspiredObj->getItems();    
    
    foreach ($items as $k=>$item) {            
        echo '<h2>'.$k.'</h2>';
        echo '<div id="inspired">';
        echo '<ul class="inspired-items">';
        
        foreach ($item as $i=>$subitem) {
            echo '<li><a href="'.$subitem['url'].'" target="_blank"><img src="'.$subitem['image_url'].'" alt="'.$subitem['url'].'" /></a></li>';
        }
        
        echo '</ul>';
        echo '</div>';
    }
}

// Enqueue scripts and styles
function inspired_scripts() {  
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js');
    wp_enqueue_script( 'jquery' );    
    wp_enqueue_script('masonry', WP_PLUGIN_URL.'/inspired/js/jquery.masonry.min.js',array('jquery'),'2.0.110526',false);
    wp_enqueue_script('inspired', WP_PLUGIN_URL.'/inspired/js/inspired.js',array('jquery'),'1.0',false);
    wp_enqueue_style('inspired', WP_PLUGIN_URL.'/inspired/css/inspired.css',false,'1.0');    
}

add_action('init', 'inspired_scripts');
add_shortcode('inspired', 'inspired_func');

// Add shortcode support for widgets
//add_filter('widget_text', 'do_shortcode');
?>
