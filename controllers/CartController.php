<?php

namespace app\controllers;

use app\components\AccessControl;
use app\components\Controller;
use app\models\Cart;
use app\models\forms\PromoCodeForm;
use app\models\User;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Cookie;

class CartController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'statuses' => [
                            User::STATUS_ACTIVE,
                        ],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'remove-item', 'remove-promo', 'add-item', 'add-promo'],
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'remove-item' => ['post'],
                    'remove-promo' => ['post'],
                    'add-item' => ['post'],
                    'add-promo' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $products = [];
        $promoCode = new PromoCodeForm();

        $cookies = Yii::$app->request->cookies;
        $cart = json_decode($cookies->get('cart'), true);
        $pCode = json_decode($cookies->get('promo'), true);

        if (count($cart) > 0) {

            if ($promoCode->load(Yii::$app->request->post()) && $promoCode->validate()) {
                $promoCode->setPromoCode();
                $this->redirect(['cart/index']);
            }

            $ids = array_column($cart, 'id');

            $products = Cart::getProducts($ids, $cart, $pCode);
        }

        return $this->render('index', [
            'products' => $products,
            'promoCode' => $promoCode
        ]);
    }

    public function actionRemoveItem($id)
    {
        $cookies = Yii::$app->request->cookies;

        if (($cart = $cookies->get('cart')) !== null) {
            $cart = json_decode($cart, true);

            foreach ($cart as $key => $c) {
                if ($c['id'] == $id) {
                    unset($cart[$key]);
                }
            }

            $cart = array_values($cart);
        }

        $cartCookie = new Cookie([
            'name' => 'cart',
            'value' => json_encode($cart),
            'expire' => time() + 60 * 60 * 24 * 7, // 7 days
        ]);

        Yii::$app->response->cookies->add($cartCookie);

        $this->redirect(['cart/index']);
    }

    public function actionAddItem()
    {
        $request = Yii::$app->request;

        if ($request->post()) {
            $id = $request->post('id');
            $qty = $request->post('qty');

            $cookies = Yii::$app->request->cookies;

            if (($cart = $cookies->get('cart')) !== null) {
                $cart = json_decode($cart, true);

                foreach ($cart as $key => $c) {
                    if ($c['id'] == $id) {

                        if ($qty > 0) {
                            $cart[$key]['qty'] = $qty;
                        } else {
                            unset($cart[$key]);
                        }
                    }
                }

                $cart = array_values($cart);
            }

            $cartCookie = new Cookie([
                'name' => 'cart',
                'value' => json_encode($cart),
                'expire' => time() + 60 * 60 * 24 * 7, // 7 days
            ]);

            Yii::$app->response->cookies->add($cartCookie);
        }
    }

    public function actionRemovePromo()
    {
        $cartCookie = new Cookie([
            'name' => 'promo',
            'value' => json_encode([]),
            'expire' => time() + 60 * 60 * 24 * 7, // 7 days
        ]);

        Yii::$app->response->cookies->add($cartCookie);

        $this->redirect(['cart/index']);
    }

    public function actionSummary()
    {
        $cookies = Yii::$app->request->cookies;
        $cart = json_decode($cookies->get('cart'), true);
        $pCode = json_decode($cookies->get('promo'), true);

        if (count($cart) == 0) {
            $this->redirect(['cart/index']);
        }

        $ids = array_column($cart, 'id');

        $products = Cart::getProducts($ids, $cart, $pCode);

        return $this->render('summary', [
            'products' => $products,
        ]);
    }
}