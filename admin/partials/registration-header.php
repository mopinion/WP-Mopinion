
<strong><?= __( 'First, Let\'s set you up with a Mopinion account. (Totally <strong>free</strong> of course...)', 'mopinion-feedback-form' );?></strong>
<p>
    <?= __( 'The username for your Mopinion-account will be the email address you are currently logged in with.', 'mopinion-feedback-form' );?>
    <i>(<?= wp_get_current_user()->user_email; ?>) </i>
    <br/>
    <?= __( 'After registration, you can login at', 'mopinion-feedback-form'); ?>
    <a href="https://app.mopinion.com" target="_blank">https://app.mopinion.com</a>
    <br/>
    <br/>
    <?= __( 'All we need from you now is a password for your new account', 'mopinion-feedback-form' ); ?>
</p>
