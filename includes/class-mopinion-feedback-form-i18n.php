<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://mopinion.com/author/kees-wolters/
 * @since      1.0.0
 *
 * @package    Mopinion_Feedback_Form
 * @subpackage Mopinion_Feedback_Form/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Mopinion_Feedback_Form
 * @subpackage Mopinion_Feedback_Form/includes
 * @author     Kees Wolters <kees@mopinion.com>
 */
class Mopinion_Feedback_Form_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'mopinion-feedback-form',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
