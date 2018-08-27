<?php

namespace app\components;


use app\models\Currency;
use Yii;

class Price
{
    public static function get($price, $precision = 2)
    {
        /* @var $currency Currency */
        $currency = Currency::find()
            ->where(['code' => Yii::$app->params['currency']])
            ->andWhere(['status' => Currency::STATUS_ACTIVE])->one();

        if (empty($currency)) {
            $currency = Currency::find()
                ->where(['code' => Yii::$app->params['default_currency']])
                ->andWhere(['status' => Currency::STATUS_ACTIVE])->one();
        }

        if ($currency->side == Currency::SIDE_RIGHT) {
            $price = round(($price * $currency->rate), $precision) .' '. $currency->short_name;
        } else {
            $price = $currency->short_name .' '. round(($price * $currency->rate), $precision);
        }

        return $price;
    }
}