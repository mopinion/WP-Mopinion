<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 * It should primarily consist of HTML with a little bit of PHP.
 *
 * @link       https://mopinion.com/author/kees-wolters/
 * @since      1.0.0
 *
 * @package    Mopinion_Feedback_Form
 * @subpackage Mopinion_Feedback_Form/admin/partials
 */


$mopinionkey = $this->get_option('mopinionkey', false);
$position = $this->get_option( 'position', 'false');
$creator = $this->get_option('account_creator', false);
?>

<script>
    var form_pos_val = "<?=$position; ?>";
</script>

<div class="wrap mopinion-feedback-form">
    <h2><?= esc_html( get_admin_page_title() ); ?></h2>

        <?php $this->showMessages(); ?>

        <form method="post">
            <?php
                settings_fields( $this->plugin_name );
                do_settings_sections( $this->plugin_name );
                submit_button();
            ?>
        </form>

      <?php if ($position === 'after' && $mopinionkey):?>
        <hr>
        <h3><?= $this->tr("Your Mopinion tag");?></h3>
        <p style="font-size:13px">
            <?=$this->tr('If you chose to implement Mopinion with an external Tag Management solution, copy the following code and paste on your website after the closing <code><strong>body</strong></code> tag, or add it to your Tag Manager.')?>
        </p>

        <textarea id="pasteaseContent" class="mopinion-code-block" readonly="true"><!-- Mopinion Pastea.se start -->
<script type="text/javascript">(function(){var id="<?=$mopinionkey;?>";var js=document.createElement("script");js.setAttribute("type","text/javascript");js.setAttribute("src","//deploy.mopinion.com/js/pastease.js");js.async=true;document.getElementsByTagName("head")[0].appendChild(js);var t=setInterval(function(){try{new Pastease.load(id);clearInterval(t)}catch(e){}},50)})();</script>
<!-- Mopinion Pastea.se end --></textarea>
      <?php endif; ?>

      <br>

      <hr>

      <div style="background-color: #FFF;padding:1px 12px; border-left:4px solid #00a0d2; margin:5px 0; ">
        <p><?= sprintf( $this->tr("If you want to change the questions, triggers or design of your feedback form, please visit %s"), '<a href="https://app.mopinion.com/survey/manage" target="_blank">app.mopinion.com</a>');?>
        <?php if ($creator):?>
          <br>
          <?=sprintf($this->tr("Your Mopinion account is owned by user: <i>%s</i>"), $creator) ; ?></i>.
        <?php endif; ?>
        </p>
      </div>

      <h3>Support</h3>
      <?= $this->tr("Having issues with your install?");?>
      <?= $this->tr("Don't hesitate to contact");?> <a href="mailto:support@mopinion.com">support@mopinion.com</a>.
</div>

<?php

if (!$mopinionkey):
  $countryPreference = $this->getLocalePreferences();
?>
<script>

  if(jQuery("#country_selector")){
      jQuery("#country_selector").countrySelect({
            defaultCountry: "<?= $countryPreference['default'];?>",
            preferredCountries: ['<?= implode('\',\'', $countryPreference['preferred']); ?>']
        });
    }
  <?php if($_POST && isset($_POST['mopinion_feedback_form_country'])):?>
    jQuery("#country_selector").countrySelect("selectCountry", "<?=$_POST['mopinion_feedback_form_country'];?>");
  <?php endif; ?>

</script>
<?php endif; ?>
