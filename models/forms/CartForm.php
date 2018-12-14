<?php

namespace app\models\forms;


use Yii;
use yii\db\ActiveRecord;
use yii\web\Cookie;

class CartForm extends ActiveRecord
{
    const MIN_QTY = 1;

    public $id;
    public $max_qty;
    public $qty;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['qty'], 'integer'],
            [['qty'], 'required'],
            [['qty'], 'checkQty'],
        ];
    }

    public function checkQty($attribute)
    {
        if ($this->qty <= 0) {
            $this->addError($attribute, 'Incorrect quantity');
        }

        if ($this->qty > $this->max_qty) {
            $this->addError($attribute, 'Max quantity: ' . $this->max_qty);
        }
    }

    public function addToCart()
    {
        $cookies = Yii::$app->request->cookies;
        $cart = $cookies->get('cart');

        $item = [
            'id' => $this->id,
            'qty' => $this->qty
        ];

        if ($cart !== null) {
            $cart = json_decode($cart, true);
        }else{
            $cart = [];
        }

        $cart[] = $item;

        $cartCookie = new Cookie([
            'name' => 'cart',
            'value' => json_encode($cart),
            'expire' => time() + 60 * 60 * 24 * 7, // 7 days
        ]);

        Yii::$app->response->cookies->add($cartCookie);
    }


}