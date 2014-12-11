<?php
/** @var \Concrete\Core\Form\Service\Form $form */
$form = Core::make('helper/form');
$config = Package::getByHandle('ec_recaptcha')->getConfig();
?>

<p><?= t('A site key and secret key must be provided. They can be obtained from the <a href="https://www.google.com/recaptcha/admin" target="_blank">reCAPTCHA website</a>.') ?></p>

<div class="form-group">
    <?= $form->label('site', t('Site Key')) ?>
    <?= $form->text('site', $config->get('captcha.site_key', '')) ?>
</div>

<div class="form-group">
    <?= $form->label('secret', t('Secret Key')) ?>
    <?= $form->text('secret', $config->get('captcha.secret_key', '')) ?>
</div>