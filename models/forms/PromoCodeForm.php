<?php

namespace app\models\forms;


use app\models\PromotionCode;
use Yii;
use yii\web\Cookie;

class PromoCodeForm extends PromotionCode
{
    public $code;

    public function rules()
    {
        return [
            [['code'], 'required'],
            [['code'], 'checkCode'],
        ];
    }

    public function checkCode($attribute)
    {
        $code = PromotionCode::find()
            ->where(['code' => $this->code])
            ->one();

        if (empty($code)) {
            $this->addError($attribute, 'Invalid promo code');
        } else {
            if ($code->expiration <= date("Y-m-d H:i:s")) {
                $this->addError($attribute, 'Promo code is out of date');
            }
        }

    }

    public function getCode()
    {
        $code = PromotionCode::find()
            ->where(['code' => $this->code])
            ->one();

        return $code;
    }

    public function setPromoCode()
    {
        $code = PromotionCode::find()
            ->where(['code' => $this->code])
            ->one();

        $cartCookie = new Cookie([
            'name' => 'promo',
            'value' => json_encode([
                'code' => $code->code,
                'value' => $code->value
            ]),
            'expire' => time() + 60 * 60 * 24 * 7, // 7 days
        ]);

        Yii::$app->response->cookies->add($cartCookie);

        return $code;
    }
}