<?php

namespace Concrete\Package\EcRecaptcha;

use Package;
use \Concrete\Core\Captcha\Library as CaptchaLibrary;

/**
 * reCAPTCHA package for Concrete5
 * @author Chris Hougard <chris@exchangecore.com>
 * @package Concrete\Package\EcRecaptcha
 */
class Controller extends Package
{
    protected $pkgHandle = 'ec_recaptcha';
    protected $appVersionRequired = '5.7.0.4';
    protected $pkgVersion = '0.9.0';

    public function getPackageName()
    {
        return t('ExchangeCore reCAPTCHA');
    }

    public function getPackageDescription()
    {
        return t('Provides a Google reCAPTCHA powered captcha field.');
    }

    public function install()
    {
        $pkg = parent::install();
        CaptchaLibrary::add('recaptcha', t('reCAPTCHA'), $pkg);
        return $pkg;
    }
}