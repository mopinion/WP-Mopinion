<?php

class MopinionBase
{
    private $messages = array(
        'success' => [],
        'info'    => [],
        'warning' => [],
        'error'   => [],
    );

    private $text_domain;

    /**
     * The prefix for the plugins options
     *
     * @since   1.0.0
     * @access  protected
     * @var     string      $option_prefix    Option prefix of this plugin
     */
    protected $option_prefix = 'mopinion_feedback_form';


    public function __construct($plugin_name)
    {
        $this->text_domain = $plugin_name;
    }


    public function get_option($name, $fallback=null)
    {
        return get_option($this->option_prefix.'_'.$name, $fallback);
    }


    public function update_option($name, $value)
    {
        return update_option($this->option_prefix.'_'.$name, $value);
    }


    protected function addSuccessMessage($message)
    {
        $this->messages['success'][] = $message;
    }


    protected function addInfoMessage($message)
    {
        $this->messages['info'][] = $message;
    }


    protected function addWarningMessage($message)
    {
        $this->messages['warning'][] = $message;
    }


    protected function addErrorMessage($message)
    {
        $this->messages['error'][] = $message;
    }


    protected function showMessages()
    {
        $types = array('success', 'info', 'warning', 'error');

        foreach($types as $type){
            if(!empty($this->messages[$type])){
                foreach($this->messages[$type] as $m){
                    echo  $this->notice($m, $type);
                }
            }
        }
    }


    protected function notice($message='', $type='info',$dismissible=true)
    {
        $classes=array('notice', 'notice-'.$type);
        if($dismissible){
            $classes[] = 'is-dismissible';
        }

        $notice = "<div class=\"".implode(' ', $classes)."\">
            <p>{$message}</p>
        </div>";

        return $notice;
    }


    /**
     * Translate helper function
     * @param  string $string String to translate
     * @return string         Translated string
     */
    protected function tr($string)
    {
        return __($string, $this->text_domain);
    }

    protected function getLocalePreferences()
    {
      $locale = get_locale();

      $localeSettings = array(
        'nl_NL' => array(
          'default' => "nl",
          'preferred' => ['nl', 'be', 'de', 'sr'],
        ),
        'nl_BE' => array(
          'default' => "be",
          'preferred' => ['be', 'nl',  'de', 'sr'],
        ),
        'en_GB' => array(
          'default' => "gb",
          'preferred' => ['gb', 'us', 'ca', 'au'],
        ),
        'en_US' => array(
          'default' => "us",
          'preferred' => ['us', 'ca', 'gb', 'au'],
        ),
      );

      if($locale && in_array($locale, array_keys($localeSettings))){

         return $localeSettings[$locale];
      }

      return array(
        'default' => 'us',
        'preferred' => ['us', 'ca', 'gb', 'nl']
      );

    }
}
