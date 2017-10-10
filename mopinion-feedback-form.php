<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://mopinion.com/author/kees-wolters/
 * @since             1.0.0
 * @package           Mopinion_Feedback_Form
 *
 * @wordpress-plugin
 * Plugin Name:       Mopinion Feedback Form
 * Plugin URI:        https://wordpress.org/plugins/mopinion-feedback-form/
 * Description:       The Mopinion Feedback Form plugin displays a feedback button and feedback form on your website to collect valuable user feedback.
 * Version:           1.1.0
 * Author:            Kees Wolters
 * Author URI:        https://mopinion.com/author/kees-wolters/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mopinion-feedback-form
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define('PLUGIN_VERSION', '1.0.1');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mopinion-feedback-form-activator.php
 */
function activate_mopinion_feedback_form() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mopinion-feedback-form-activator.php';
	Mopinion_Feedback_Form_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mopinion-feedback-form-deactivator.php
 */
function deactivate_mopinion_feedback_form() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mopinion-feedback-form-deactivator.php';
	Mopinion_Feedback_Form_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_mopinion_feedback_form' );
register_deactivation_hook( __FILE__, 'deactivate_mopinion_feedback_form' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-mopinion-feedback-form.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_mopinion_feedback_form() {

	$plugin = new Mopinion_Feedback_Form();
    $plugin->run();
}

run_mopinion_feedback_form();
