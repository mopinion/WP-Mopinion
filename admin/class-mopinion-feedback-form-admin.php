<div></div><?php

include 'includes/mopinion-base.php';
include 'includes/mopinion-api.php';

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://mopinion.com/author/kees-wolters/
 * @since      1.0.0
 *
 * @package    Mopinion_Feedback_Form
 * @subpackage Mopinion_Feedback_Form/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mopinion_Feedback_Form
 * @subpackage Mopinion_Feedback_Form/admin
 * @author     Kees Wolters <kees@mopinion.com>
 */
class Mopinion_Feedback_Form_Admin extends MopinionBase{

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

    private $api;

    protected $user;
    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version )
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;

        $this->api = new MopinionApiHandler();

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

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

        wp_enqueue_style(
            $this->plugin_name,
            plugin_dir_url( __FILE__ ) . 'css/mopinion-feedback-form-admin.css',
            array(),
            $this->version,
            'all'
        );

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

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

        wp_enqueue_script(
            $this->plugin_name,
            plugin_dir_url( __FILE__ ) . 'js/mopinion-feedback-form-admin.js',
            array( 'jquery' ),
            $this->version,
            false
        );

    }


    /**
     * Add an options page under the Settings submenu
     *
     * @since  1.0.0
     */
    public function add_options_page()
    {
        $this->plugin_screen_hook_suffix = add_options_page(
            __( 'Mopinion Feedback Form Settings', 'mopinion-feedback-form' ),
            __( 'Mopinion Feedback Form', 'mopinion-feedback-form' ),
            'manage_options',
            $this->plugin_name,
            array( $this, 'display_options_page' )
        );
    }


    /**
     * Register all related settings of this plugin
     *
     * @since  1.0.0
     */
    public function register_setting()
    {
        $this->user = wp_get_current_user();

        // if we can get a mopinion org-id from the db,
        // registration must be completed
        $organisation_id = $this->get_option('organisation_id');
        $registration_complete = !empty($organisation_id);

        if($registration_complete){

            // Section: General Settings
            add_settings_section(
                $this->option_prefix . '_general',
                __( 'General', 'mopinion-feedback-form' ),
                array( $this, $this->option_prefix . '_general_cb' ),
                $this->plugin_name
            );

            //add setting field radio button
            add_settings_field(
                $this->option_prefix . '_position',
                __( 'Select how you want the Mopinion tag to be implemented:', 'mopinion-feedback-form' ),
                array( $this, $this->option_prefix . '_position_cb' ),
                $this->plugin_name,
                $this->option_prefix . '_general',
                array( 'label_for' => $this->option_prefix . '_position' )
            );

            register_setting( $this->plugin_name, $this->option_prefix . '_position', array( $this, $this->option_prefix . '_sanitize_position' ) );


        }else{

            // Section: Registration to Mopinion
            add_settings_section(
                $this->option_prefix . '_registration',
                __( 'Registration', 'mopinion-feedback-form' ),
                array( $this, $this->option_prefix . '_registration_cb' ),
                $this->plugin_name
            );

            // add a textfield
            add_settings_field(
                $this->option_prefix . '_password',
                __( 'Set your Mopinion account password', 'mopinion-feedback-form' ),
                array( $this, $this->option_prefix . '_password_cb' ),
                $this->plugin_name,
                $this->option_prefix . '_registration',
                array( 'label_for' => $this->option_prefix . '_password' )
            );
        }
    }



    /**
     * Render the radio input field for position option
     *
     * @since  1.0.0
     */
    public function mopinion_feedback_form_position_cb()
    {
        $position = $this->get_option('position');
        $position_name = $this->option_prefix . '_position';

        echo
            '<fieldset>
                <label>
                    <input type="radio" name="'.$position_name.'" value="mopinioninfooter">'
                    .__( 'Append to WordPress footer (Recommended) ', 'mopinion-feedback-form' )
                .'</label>
                <br>
                <span class="mopinion-option-note">
                    The Mopinion tag is injected directly into the WordPress <code>&lt;footer&gt;</code>-tag. No further action is required.
                    </span>
                <br>
                <label style="padding-top:25px;">
                    <input type="radio" name="'.$position_name.'" value="after">'
                    .__( 'Use an external Tag Management solution', 'mopinion-feedback-form' )
                .'</label>
                <br>
                <span class="mopinion-option-note">
                    With this option you need to paste the Mopinion tag (below) in your Tag Management solution of choice. Read more about that <a href="http://support.mopinion.com/knowledge_base/topics/how-do-i-install-mopinion-with-google-tag-manager?from_search=true" target="_blank">here</a>.
                </span>
                <br>
            </fieldset>';
    }

    /**
     * Render the text for the Registration section
     *
     * @since  1.0.0
     */
    public function mopinion_feedback_form_registration_cb()
    {
        include('partials/registration-header.php');
    }

    /**
     * Render the password input for this plugin
     *
     * @since  1.0.0
     */
    public function mopinion_feedback_form_password_cb()
    {
        echo '
        <div class="wp-pwd">
            <span class="password-input-wrapper">
                <input type="password" name="'.$this->option_prefix . '_password" id="'.$this->option_prefix . '_password"
                class="regular-text strong" value="" autocomplete="off">
            </span>
            <button type="button" class="button wp-hide-pw" aria-label="Show password" id="'.$this->option_prefix . '_password_toggle">
                <span class="dashicons dashicons-visibility"></span>
                <span class="text">Show</span>
            </button>
            <!--div style="" id="pass-strength-result" aria-live="polite" class="strong">Strong</div-->
        </div>';
    }

    /**
     * Render the text for the general section -> Settings / General
     *
     * @since  1.0.0
     */
    public function mopinion_feedback_form_general_cb()
    {
        echo '<p>' . __( 'Please change the settings accordingly.', 'mopinion-feedback-form' ) . '  </p>';
    }


    /**
     * Render the options page for plugin
     *
     * @since  1.0.0
     */
    public function display_options_page()
    {
        // if we can get a mopinion org-id from the db,
        // registration must be completed
        $organisation_id = $this->get_option('organisation_id');
        $registration_complete = !empty($organisation_id);
        $success = $created = false;

        if(!empty($_POST)){

            if(!$registration_complete){
                $password = $_POST['mopinion_feedback_form_password'];

                if(empty($password)){
                    $this->addErrorMessage('Password cannot be empty');

                }else{

                    $options = array('password' => $password);

                    $headers = array();
                    $params = array(
                        'headers' => $headers,
                        'body'    => $this->newOrganisationPayload($options),
                        'query'   => array('direct_verify' => 1),
                    );

                    $response = $this->api->post('/organisations', $params);

                    if(isset($response->error_code)){

                        $error = $response->title;

                        if(property_exists($response, 'details')){
                            $error .= ' ('.implode(', ', $response->details).')';
                        }

                        $this->addErrorMessage($error);

                    }else{

                        if($response->_meta->code===201
                            && !empty($response->organisation->id)
                            && !empty($response->deployment->key)
                        ){
                            $this->update_option('organisation_id', $response->organisation->id);
                            $this->update_option('mopinionkey', $response->deployment->key);
                            $this->update_option('account_creator', $this->user->user_email);
                            $this->update_option('position', 'mopinioninfooter');
                            $success = $created = true;
                        }
                    }
                }
            }else{
                if(isset($_POST['mopinion_feedback_form_position'])){
                    $this->update_option('position', $_POST['mopinion_feedback_form_position']);
                    $success = true;
                }
            }

            if($success){
                $this->addSuccessMessage("Success!");
            }
        }

        if($created){
            // just show confirmation
            require_once 'partials/account-created.php';
        }else{

            // add options page
            require_once 'partials/mopinion-feedback-form-admin-display.php';
        }
    }


    /**
     * Sanitize the text position value mopinioninfooter being saved to database
     *
     * @param  string $position $_POST value
     * @since  1.0.0
     * @return string           Sanitized value
     */
    public function mopinion_feedback_form_sanitize_position( $position )
    {
        if ( in_array( $position, array( 'mopinioninfooter', 'after' ), true ) ) {
            return $position;
        }
    }


    private function newOrganisationPayload(array $options=array())
    {
        $site_name = get_bloginfo( 'name' );;
        $user = $this->user;

        $firstname = $user->user_firstname?:$user->nickname;
        $lastname  = $user->user_lastname?:'';

        $headers = array();
        $payload = array(
            'organisation' => array(
                'name'=> $site_name,
                'country_code'=> "us",

            ),
            'report' => array(
                'name'=> $site_name,
            ),
            'user' => array(
                'firstname' => $firstname,
                'lastname' => $lastname,
                'password' => $options['password'],
                'email' => $user->user_email,
            ),
            'deployment' => array(
                'name' =>  $site_name
            ),
        );

        return $payload;
    }

}
