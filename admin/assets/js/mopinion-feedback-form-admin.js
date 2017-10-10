(function( $ ) {
    'use strict';

    /**
     * All of the code for your admin-facing JavaScript source
     * should reside in this file.
     *
     * Note: It has been assumed you will write jQuery code here, so the
     * $ function reference has been prepared for usage within the scope
     * of this function.
     */

    $( function() {

        if(typeof(form_pos_val) != 'undefined'){
            $("input:radio[name=mopinion_feedback_form_position][value="+form_pos_val+"]").prop('checked', true);
        }

        $("#mopinion_feedback_form_password_toggle").on('click', function($this){

            var $btn = $($this.delegateTarget);
            var $btn_text = $btn.find('span.text');
            var $btn_icon = $btn.find('span.dashicons');

            var $showIcon = 'dashicons-visibility';
            var $hideIcon = 'dashicons-hidden';

            var $input = $("input[name=mopinion_feedback_form_password]");
            var $type = $input.prop('type');
            if($type == 'password'){
                $input.attr('type', 'text');

                $btn_icon.removeClass($showIcon).addClass($hideIcon);
                $btn_text.html('Hide');
            }else{
                $input.attr('type', 'password');

                $btn_icon.removeClass($hideIcon).addClass($showIcon);
                $btn_text.html('Show');
            }
        });
    });

})( jQuery );
