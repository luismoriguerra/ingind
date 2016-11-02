<?php

use ReCaptcha\ReCaptcha;

trait CaptchaTrait {

    public function captchaCheck()
    {
        $response = Input::get('recaptcha');
        $remoteip = $_SERVER['REMOTE_ADDR'];
        $secret = Config::get("recaptcha.secret");

        $recaptcha = new ReCaptcha($secret);
        $resp = $recaptcha->verify($response, $remoteip);
        if ($resp->isSuccess()) {
            return 1;
        } else {
            return 0;
        }

    }

}
