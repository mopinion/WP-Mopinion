<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://mopinion.com/author/kees-wolters/
 * @since      1.0.0
 *
 * @package    Mopinion_Feedback_Form
 * @subpackage Mopinion_Feedback_Form/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Mopinion_Feedback_Form
 * @subpackage Mopinion_Feedback_Form/public
 * @author     Kees Wolters <kees@mopinion.com>
 */
class Mopinion_Feedback_Form_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mopinion_Feedback_Form_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mopinion_Feedback_Form_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mopinion-feedback-form-public.css', array(), $this->version, 'all' );

	}


	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mopinion_Feedback_Form_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mopinion_Feedback_Form_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/mopinion-feedback-form-public.js', array( 'jquery' ), $this->version, false );

	}


	public function wp_footer(  ) {

		//build the mopinion pastease tag
		//to test, replace get_option with this test key: "pqum8a3kgvlsvhocheye5gcnkiuydj6wyl0"
		$mopinionkey = get_option('mopinion_feedback_form_mopinionkey');

		$position = get_option( 'mopinion_feedback_form_position' );

		if ($position == 'mopinioninfooter' && !empty($mopinionkey)){
		echo '<!-- Mopinion Pastea.se  start -->
		<script type="text/javascript">(function(){var id="'.$mopinionkey.'";var js=document.createElement("script");js.setAttribute("type","text/javascript");js.setAttribute("src","//deploy.mopinion.com/js/pastease.js");js.async=true;document.getElementsByTagName("head")[0].appendChild(js);var t=setInterval(function(){try{new Pastease.load(id);clearInterval(t)}catch(e){}},50)})();</script>
		<!-- Mopinion Pastea.se end -->';
		}

	}

}
