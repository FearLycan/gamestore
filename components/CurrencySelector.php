<?php

namespace app\components;


use app\models\Currency;
use yii\base\BootstrapInterface;

class CurrencySelector implements BootstrapInterface
{
    public $supportedCurrency = [];

    public function bootstrap($app)
    {
        $this->supportedCurrency = Currency::getSupportedCurrency();

        $preferredCurrency = isset($app->request->cookies['currency']) ? (string)$app->request->cookies['currency'] : $app->params['default_currency'];

        if (!in_array($preferredCurrency, $this->supportedCurrency)) {
            $preferredCurrency = $app->params['default_currency'];
        }

        $app->params['currency'] = $preferredCurrency;
    }
}