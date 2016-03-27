<?php
/* 
 * Plugin Name: IMITHEMES Listing
 * Plugin URI:  http://www.imithemes.com
 * Description: Creates listing post types for theme
 * Author:      imithemes
 * Version:     1.0.5
 * Author URI:  http://www.imithemes.com
 * Licence:     GPLv2
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Copyright:   (c) 2015 imithemes. All rights reserved
 */

// Do not allow direct access to this file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
$path = plugin_dir_path( __FILE__ );
//Load language text domain
add_action('after_setup_theme', 'imic_plugin_setup');
function imic_plugin_setup() {
    load_theme_textdomain('imic-listing', plugin_dir_path( __FILE__ ) . '/language');
}
/* CUSTOM POST TYPES
================================================== */
require_once $path . '/imic-post-type-permalinks.php';
require_once $path . '/custom-post-types/cars-type.php';
require_once $path . '/custom-post-types/plan-type.php';
require_once $path . '/custom-post-types/user-type.php';
require_once $path . '/custom-post-types/testimonial-type.php';
require_once $path . '/custom-post-types/gallery-type.php';
require_once $path . '/custom-post-types/team-type.php';