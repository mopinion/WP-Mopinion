<div class="wrap">
    <h2><?= esc_html( get_admin_page_title() ); ?></h2>

    <?php $this->showMessages(); ?>

    <h3><?=$this->tr('A new Mopinion account has been created');?>!</h3>

    <?= sprintf($this->tr('You can access your account by visiting %s to further customize your feedback form.'),'<a href="https://app.mopinion.com/survey/manage" target="_blank">https://app.mopinion.com</a>'); ?>
    <br>
    <br>
    <button class="button button-primary" onclick="document.location.reload();"><?=$this->tr('Continue');?></button>
</div>
