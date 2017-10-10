
<strong><?= $this->tr( 'First, Let\'s set you up with a Mopinion account. (Totally <strong>free</strong> of course...)');?></strong>
<p>
    <?= $this->tr( 'The username for your Mopinion-account will be the email address you are currently logged in with.');?>
    <i>(<?= wp_get_current_user()->user_email; ?>) </i>
    <br/>
    <?= $this->tr( 'After registration, you can login at'); ?>
    <a href="https://app.mopinion.com" target="_blank">https://app.mopinion.com</a>
    <br/>
    <br/>
    <?= $this->tr( 'All we need from you now is  your country and a password for your new account.'); ?>
</p>
