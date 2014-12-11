<?php
defined('C5_EXECUTE') or die('Access denied.');

/** @var \Concrete\Core\Form\Service\Form $form */
$form = Core::make('helper/form');
$config = Package::getByHandle('ec_recaptcha')->getConfig();
?>

<p><?= t('A site key and secret key must be provided. They can be obtained from the <a href="%s" target="_blank">reCAPTCHA website</a>.', 'https://www.google.com/recaptcha/admin') ?></p>

<div class="form-group">
    <?= $form->label('site', t('Site Key')) ?>
    <?= $form->text('site', $config->get('captcha.site_key', '')) ?>
</div>

<div class="form-group">
    <?= $form->label('secret', t('Secret Key')) ?>
    <?= $form->text('secret', $config->get('captcha.secret_key', '')) ?>
</div>

<div class="form-group">
    <?= $form->label('theme', t('Theme')) ?>
    <?= $form->select('theme', array('light' => t('Light'), 'dark' => t('Dark')), $config->get('captcha.theme', 'light')) ?>
</div>

<div class="form-group">
    <?= $form->label('language', t('Language')) ?>
    <?= $form->select(
        'language',
        array(
            'auto' => t('Auto-Detect'),
            'ar' => t('Arabic'),
            'bg' => t('Bulgarian'),
            'ca' => t('Catalan'),
            'zh-CN' => t('Chinese (Simplified)'),
            'zh-TW' => t('Chinese (Traditional)'),
            'hr' => t('Croatian'),
            'cs' => t('Czech'),
            'da' => t('Danish'),
            'nl' => t('Dutch'),
            'en-GB' => t('English (UK)'),
            'en' => t('English (US)'),
            'fil' => t('Filipino'),
            'fi' => t('Finnish'),
            'fr' => t('French'),
            'fr-CA' => t('French (Canadian)'),
            'de' => t('German'),
            'de-AT' => t('German (Austria)'),
            'de-CH' => t('German (Switzerland)'),
            'el' => t('Greek'),
            'iw' => t('Hebrew'),
            'hi' => t('Hindi'),
            'hu' => t('Hungarain'),
            'id' => t('Indonesian'),
            'it' => t('Italian'),
            'ja' => t('Japanese'),
            'ko' => t('Korean'),
            'lv' => t('Latvian'),
            'lt' => t('Lithuanian'),
            'no' => t('Norwegian'),
            'fa' => t('Persian'),
            'pl' => t('Polish'),
            'pt' => t('Portuguese'),
            'pt-BR' => t('Portuguese (Brazil)'),
            'pt-PT' => t('Portuguese (Portugal)'),
            'ro' => t('Romanian'),
            'ru' => t('Russian'),
            'sr' => t('Serbian'),
            'sk' => t('Slovak'),
            'sl' => t('Slovenian'),
            'es' => t('Spanish'),
            'es-' => t('Spanish (Latin America)'),
            'sv' => t('Swedish'),
            'th' => t('Thai'),
            'tr' => t('Turkish'),
            'uk' => t('Ukrainian'),
            'vi' => t('Vietnamese'),
        ),
        $config->get('captcha.language', 'auto')) ?>
</div>