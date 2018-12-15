<?php

namespace app\controllers;

use app\components\Controller;
use app\models\Game;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Cookie;

class CartController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'remove-item' => ['post'],
                    'add-item' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $products = [];

        $cookies = Yii::$app->request->cookies;
        $cart = json_decode($cookies->get('cart'), true);

        if (count($cart) > 0) {
            $total = 0;


            $ids = array_column($cart, 'id');

            $products['items'] = Game::find()
                ->joinWith(['platform platform', 'region region'])
                ->select(['game.id', 'game.name', 'game.description', 'game.slug', 'game.qty', 'game.smallImage', 'game.region_id', 'game.platform_id',
                    'game.price', 'region.name region', 'platform.name platform'])
                ->where(['in', 'game.id', $ids])
                ->andWhere(['game.status' => Game::STATUS_ACTIVE])
                ->asArray()
                ->all();

            foreach ($products['items'] as $key => $product) {
                foreach ($cart as $c) {
                    if ($product['id'] == $c['id']) {
                        $products['items'][$key]['quantity'] = $c['qty'];
                        $total += ($products['items'][$key]['quantity'] * $products['items'][$key]['price']);
                    }
                }
            }

            $products['total'] = $total;
        }

        return $this->render('index', [
            'products' => $products
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
}