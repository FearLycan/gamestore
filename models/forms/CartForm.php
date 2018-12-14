<?php

namespace app\models\forms;

use app\models\Cart;
use Yii;
use yii\web\Cookie;

class CartForm extends Cart
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

        $product = [
            'id' => $this->id,
            'qty' => $this->qty
        ];

        if ($cart !== null) {
            $new = true;
            $cart = json_decode($cart, true);

            foreach ($cart as $key => $item) {
                if ($this->id == $item['id']) {
                    $cart[$key]['qty'] += $this->qty;
                    $new = false;
                }
            }

            if ($new) {
                $cart[] = $product;
            }

        } else {
            $cart = [];
            $cart[] = $product;
        }

        $cartCookie = new Cookie([
            'name' => 'cart',
            'value' => json_encode($cart),
            'expire' => time() + 60 * 60 * 24 * 7, // 7 days
        ]);

        Yii::$app->response->cookies->add($cartCookie);
    }


}