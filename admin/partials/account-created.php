<div class="wrap">
    <h2><?= esc_html( get_admin_page_title() ); ?></h2>

    <?php $this->showMessages(); ?>

    <h3>A new Mopinion account has been created!</h3>

    You can access your account by visiting <a href="https://app.mopinion.com/survey/manage" target="_blank">https://app.mopinion.com</a> to further customize your feedback form.
    <br>
    <br>
    <button class="button button-primary" onclick="document.location.reload();">Continue</button>
</div>
