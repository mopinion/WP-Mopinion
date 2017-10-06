<?php

class MopinionBase
{

    private $messages = array(
        'success' => [],
        'info'    => [],
        'warning' => [],
        'error'   => [],
    );

    /**
     * The prefix for the plugins options
     *
     * @since   1.0.0
     * @access  protected
     * @var     string      $option_prefix    Option prefix of this plugin
     */
    protected $option_prefix = 'mopinion_feedback_form';


    public function __construct()
    {}


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
}
