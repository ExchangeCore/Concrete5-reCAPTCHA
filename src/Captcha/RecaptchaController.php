<?php

namespace Concrete\Package\EcRecaptcha\Src\Captcha;

use Concrete\Core\Captcha\Controller as CaptchaController;
use Concrete\Core\Http\ResponseAssetGroup;
use Concrete\Core\Package\Package;
use Concrete\Core\Utility\IPAddress;
use Config;
use Core;

/**
 * Provides a reCAPTCHA captcha for Concrete5
 * @author Chris Hougard <chris@exchangecore.com>
 * @package Concrete\Package\EcRecaptcha\Src\Captcha
 */
class RecaptchaController extends CaptchaController
{
    public function saveOptions($data)
    {
        $config = Package::getByHandle('ec_recaptcha')->getConfig();
        $config->save('captcha.site_key', $data['site']);
        $config->save('captcha.secret_key', $data['secret']);
        $config->save('captcha.theme', $data['theme']);
    }

    /**
     * Shows an input for a particular captcha library
     */
    function showInput()
    {
        $config = Package::getByHandle('ec_recaptcha')->getConfig();

        $rag = ResponseAssetGroup::get();
        $rag->addFooterAsset('<script src="https://www.google.com/recaptcha/api.js"></script>');

        echo '<div class="g-recaptcha" data-sitekey="' . $config->get('captcha.site_key') . '" data-theme="' . $config->get('captcha.theme') . '"></div>';
        echo '<noscript>
          <div style="width: 302px; height: 352px;">
            <div style="width: 302px; height: 352px; position: relative;">
              <div style="width: 302px; height: 352px; position: absolute;">
                <iframe src="https://www.google.com/recaptcha/api/fallback?k=' . $config->get('captcha.site_key') . '"
                        frameborder="0" scrolling="no"
                        style="width: 302px; height:352px; border-style: none;">
                </iframe>
              </div>
              <div style="width: 250px; height: 80px; position: absolute; border-style: none;
                          bottom: 21px; left: 25px; margin: 0; padding: 0; right: 25px;">
                <textarea id="g-recaptcha-response" name="g-recaptcha-response"
                          class="g-recaptcha-response"
                          style="width: 250px; height: 80px; border: 1px solid #c1c1c1;
                                 margin: 0; padding: 0; resize: none;" value=""></textarea>
              </div>
            </div>
          </div>
        </noscript>';
    }

    /**
     * Displays the graphical portion of the captcha
     */
    function display()
    {
        return '';
    }

    /**
     * Displays the label for this captcha library
     */
    function label()
    {
        return '';
    }

    /**
     * Verifies the captcha submission
     * @return bool
     */
    public function check()
    {
        $config = Package::getByHandle('ec_recaptcha')->getConfig();
        /** @var \Concrete\Core\Permission\IPService $iph */
        $iph = Core::make('helper/validation/ip');

        $qsa = http_build_query(
            array(
                'secret' => $config->get('captcha.secret_key'),
                'response' => $_REQUEST['g-recaptcha-response'],
                'remoteip' => $iph->getRequestIP()->getIp(IPAddress::FORMAT_IP_STRING)
            )
        );

        $ch = curl_init('https://www.google.com/recaptcha/api/siteverify?' . $qsa);

        if (Config::get('concrete.proxy.host') != null) {
            curl_setopt($ch, CURLOPT_PROXY, Config::get('concrete.proxy.host'));
            curl_setopt($ch, CURLOPT_PROXYPORT, Config::get('concrete.proxy.port'));

            // Check if there is a username/password to access the proxy
            if (Config::get('concrete.proxy.user') != null) {
                curl_setopt(
                    $ch,
                    CURLOPT_PROXYUSERPWD,
                    Config::get('concrete.proxy.user') . ':' . Config::get('concrete.proxy.password')
                );
            }
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        if ($response !== false) {
            $data = json_decode($response, true);
            return $data['success'];
        } else {
            return false;
        }
    }
}