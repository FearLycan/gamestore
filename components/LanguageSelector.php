<?php

namespace app\components;

use app\models\Language;
use yii\base\BootstrapInterface;

class LanguageSelector implements BootstrapInterface
{
    public $supportedLanguages = [];

    public function bootstrap($app)
    {
        $this->supportedLanguages = Language::getSupportedLanguages();

        $preferredLanguage = isset($app->request->cookies['language']) ? (string)$app->request->cookies['language'] : null;

        if (empty($preferredLanguage)) {
            $preferredLanguage = $app->request->getPreferredLanguage($this->supportedLanguages);
        }

        $app->language = $preferredLanguage;
    }
}