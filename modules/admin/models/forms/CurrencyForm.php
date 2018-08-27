<?php

namespace app\modules\admin\models\forms;

use app\modules\admin\models\Currency;

class CurrencyForm extends Currency
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['country', 'name', 'short_name', 'code', 'rate', 'status'], 'required'],
            [['rate'], 'number'],
            [['side', 'status'], 'integer'],
            [['country', 'name', 'short_name'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 12],
        ];
    }
}