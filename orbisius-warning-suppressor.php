<?php
/*
Plugin Name: Orbisius Warning Suppressor
Plugin URI: https://orbisius.com/products/wordpress-plugins/orbisius-warning-suppressor/
Description: Suppresses 'Declaration ... should be compatible' warnings in php 7
Version: 1.0.2
Author: Svetoslav Marinov (Slavi)
Author URI: http://orbisius.com
*/

/*  Copyright 2017-3000 Svetoslav Marinov (Slavi) <slavi@orbisius.com>

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// We need this called as soon as possible.
// hooking into init may be too late
orbisius_warning_suppressor_supress_warnings();

// Set up plugin
add_action('admin_menu', 'orbisius_warning_suppressor_setup_admin');
add_action('wp_footer', 'orbisius_warning_suppressor_add_plugin_credits', 1000);

/**
 * Installs an error handler that will be called only for php E_WARNING
 * @package Orbisius Warning Suppressor
 * @since 1.0
 */
function orbisius_warning_suppressor_supress_warnings() {
    // How to turn it off via wp-config.php
    if ( (!defined('ORBISIUS_WARNING_SUPPRESSOR_ENABLED') || ORBISIUS_WARNING_SUPPRESSOR_ENABLED > 0) 
            && version_compare(phpversion(), 7, '>=')) {
        // https://stackoverflow.com/questions/36079651/silence-declaration-should-be-compatible-warnings-in-php-7
        set_error_handler('orbisius_warning_suppressor_suppress_bad_warnings', E_WARNING);
    }
}

/**
 * Suppress the weird messages about the wrong/incorrect declaration.
 * @param int $err_no
 * @param str $err_str
 * @return bool
 */
function orbisius_warning_suppressor_suppress_bad_warnings($err_no, $err_str, $errfile = '', $errline = '') {
    // If the function returns FALSE then the normal error handler continues.
    $contains_stupid_warning = stripos($err_str, 'Declaration of') !== false;
    return $contains_stupid_warning;
}

/**
 * Set up administration
 *
 * @package Orbisius Warning Suppressor
 * @since 0.1
 */
function orbisius_warning_suppressor_setup_admin() {
    // In case of white labelling
    $render_settings_link = apply_filters('orbisius_warning_suppressor_render_settings_link', true);
    
    if ($render_settings_link) {
        add_options_page( 'Orbisius Warning Suppressor', 'Orbisius Warning Suppressor', 'manage_options', 
            'orbisius_warning_suppressor_options', 'orbisius_warning_suppressor_settings_page' );
    }
    
    // when plugins are show add a settings link near my plugin for a quick access to the settings page.
    add_filter('plugin_action_links', 'orbisius_warning_suppressor_add_plugin_settings_link', 10, 2);
}

// Add the ? settings link in Plugins page very good
function orbisius_warning_suppressor_add_plugin_settings_link($links, $file) {
    if ($file == plugin_basename(__FILE__)) {
        $prefix = admin_url('options_general.php?page=' . plugin_basename(__FILE__));
        $dashboard_link = "<a href=\"{$prefix}\">" . 'Create a Child Theme' . '</a>';
        array_unshift($links, $dashboard_link);
    }

    return $links;
}

// Generates Options for the plugin
function orbisius_warning_suppressor_settings_page() {
    ?>
    <div class="wrap orbisius_warning_suppressor_container">
        <h2>Orbisius Warning Suppressor</h2>

        <div>
            <h3>What does this plugin do?</h3>
<pre>
Suppresses php 7 warnings that show up when a method has different parameters
than the same method in the parent class.

<strong>PHP Warning:  Declaration of ... should be compatible with ...</strong>

Those warnings are useless and fill up your log files.
</pre>
        </div>
        
        <div class="updated0"><p>
            <h3>Usage</h3>       
<pre>
You just need to keep the plugin active & meditate ;)
</pre>
        </p></div>
        
<!--        <h2>Video Demo</h2>

        <p class="orbisius_warning_suppressor_demo_video hide00">
            <?php if (0) : ?>
                <iframe width="560" height="315" src="http://www.youtube.com/embed/BZUVq6ZTv-o" 
                        frameborder="0" allowfullscreen></iframe>
                <br/>Video Link: <a href="www.youtube.com/watch?v=BZUVq6ZTv-o"
                                    target="_blank">www.youtube.com/watch?v=BZUVq6ZTv-o</a>
            <?php else : ?>
                TODO
            <?php endif; ?>
         </p>-->
        
        <h2>Support & Feature Requests</h2>
        <div class="updated000"><p>
            ** NOTE: ** Support is handled on our site: <a href="http://orbisius.com/support/" target="_blank" title="[new window]">http://orbisius.com/support/</a>.
            Please do NOT use the WordPress forums or other places to seek support.
        </p></div>

        <div style="background: #ffffcc;padding:5px;">
            <h2>Free Staging Site</h2>
            <p>
                Do you have a test site that you can use to play with themes and plugin? 
                No? Then try <a href="http://qsandbox.com/?utm_source=orbisius-warning-suppressor&utm_medium=settings_screen&utm_campaign=product"
                        target="_blank" title="[new window]">http://qsandbox.com</a> now and have your test 
                WordPress site set up in seconds. The best part is No technical knowledge is required.
            </p>
        </div>
        
        <h2>Mailing List</h2>
        <p>
            Get the latest news and updates about this and future cool
                <a href="//profiles.wordpress.org/lordspace/"
                    target="_blank" title="Opens a page with the pugins we developed. [New Window/Tab]">plugins we develop</a>.
        </p>

        <p>
            <!-- // MAILCHIMP SUBSCRIBE CODE \\ -->
            <a href="http://eepurl.com/guNzr" target="_blank">Subscribe to our newsletter</a>
            <!-- \\ MAILCHIMP SUBSCRIBE CODE // -->
        </p>
    </div>
    <?php
}

/**
 * Returns some plugin data such name and URL. This info is inserted as HTML
 * comment surrounding the embed code.
 * @return array
 */
function orbisius_warning_suppressor_get_plugin_data() {
    // pull only these vars
    $default_headers = array(
        'Name' => 'Plugin Name',
        'PluginURI' => 'Plugin URI',
        'Description' => 'Description',
    );

    $plugin_data = get_file_data(__FILE__, $default_headers, 'plugin');

    $url = $plugin_data['PluginURI'];
    $name = $plugin_data['Name'];

    $data['name'] = $name;
    $data['url'] = $url;

    $data = array_merge($data, $plugin_data);

    return $data;
}


/**
* adds some HTML comments in the page so people would know that this plugin powers their site.
*/
function orbisius_warning_suppressor_add_plugin_credits() {
    // pull only these vars
    $default_headers = array(
        'Name' => 'Plugin Name',
        'PluginURI' => 'Plugin URI',
    );

    $plugin_data = get_file_data(__FILE__, $default_headers, 'plugin');

    $url = $plugin_data['PluginURI'];
    $name = $plugin_data['Name'];
    
    printf(PHP_EOL . PHP_EOL . '<!-- ' . "Powered by $name | URL: $url " . '-->' . PHP_EOL . PHP_EOL);
}
