<?php
/**
 * Created by PhpStorm.
 * User: Damian Brończyk
 * Date: 22.08.2018
 * Time: 09:09
 */

namespace app\components;

use yii\base\BootstrapInterface;

class LanguageSelector implements BootstrapInterface
{
    public $supportedLanguages = [];

    public function bootstrap($app)
    {
        $preferredLanguage = $app->request->getPreferredLanguage($this->supportedLanguages);
        $app->language = $preferredLanguage;
    }
}