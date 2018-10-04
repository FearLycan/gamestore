<?php

namespace app\controllers;

use app\components\AccessControl;
use app\components\Controller;
use app\models\G2APay;
use app\models\Game;
use app\models\GameKey;
use app\models\Order;
use app\models\User;
use Yii;
use yii\filters\VerbFilter;

class OrderController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'place-an-order' => ['POST'],
                    'pay' => ['POST'],
                    'create' => ['POST'],
                    'get_key' => ['POST'],
                ],
            ],
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
                ],
            ],
        ];
    }

    /**
     * @param $slug
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionCreate($slug)
    {
        $game = $this->findModel($slug);

        return $this->render('create', [
            'game' => $game,
        ]);
    }

    public function actionPlaceAnOrder($slug)
    {
        $game = $this->findModel($slug);

        $order = Order::placeAnOrder($game->g2a_id, Yii::$app->user->id, $game->price);

        if (!$order) {
            //redircet to error page
        }

        return $this->redirect(['view', 'hash' => $order->hash]);

//        return $this->render('place-an-order', [
//            'order' => $order,
//        ]);
    }

    public function actionView($hash)
    {
        $order = Order::find()
            ->where(['hash' => $hash])
            ->andWhere(['buyer_id' => Yii::$app->user->id])
            ->one();

        if ($order !== null) {
            return $this->render('view', [
                'order' => $order,
            ]);
        }

        $this->notFound('The requested page does not exist.');
    }

    public function actionPay($hash)
    {
        $order = $this->findModelByHash($hash);

        $payment = G2APay::makePayment($order->g2a_order_id);

        if ($payment && $payment['status']) {
            $order->g2a_transaction_id = $payment['transaction_id'];
            $order->status = $payment['transaction_id'];
            $order->save(false, ['transaction_id']);

            $key = G2APay::getOrderKey($order->g2a_order_id);

            if ($key && !isset($key['status'])) {
                $game_key = new GameKey();
                $game_key->key = $key['key'];
                $game_key->order_id = $order->id;

                if ($game_key->save()) {
                    $order->status = Order::STATUS_COMPLATE;
                    $order->save(false, ['status']);
                    return $this->redirect(['view', 'hash' => $order->hash]);
                }

            } else {
                $this->notFound('We have problem with this order. Please try again in a few minutes.');
            }

        } else {
            $this->notFound('We have problem with this order. Please try again in a few minutes.');
        }
    }

    public function actionGetKey($hash)
    {
        $order = $this->findModelByHash($hash);

        $key = G2APay::getOrderKey($order->g2a_order_id);

        if ($key && !isset($key['status'])) {
            $game_key = new GameKey();
            $game_key->key = $key['key'];
            $game_key->order_id = $order->id;

            if ($game_key->save()) {
                $order->status = Order::STATUS_COMPLATE;
                $order->save(false, ['status']);
                return $this->redirect(['view', 'hash' => $order->hash]);
            }

        } else {
            $this->notFound('We have problem with this order. Please try again in a few minutes.');
        }
    }

    /**
     * Finds the Game model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $slug
     * @return Game the loaded model
     * @throws \yii\web\NotFoundHttpException if the model cannot be found
     */
    protected function findModel($slug)
    {
        $model = Game::find()
            ->where(['slug' => $slug, 'status' => Game::STATUS_ACTIVE])
            ->one();

        if ($model !== null) {
            return $model;
        }

        $this->notFound('The requested page does not exist.');
    }

    /**
     * Finds the Game model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $hash
     * @return Order the loaded model
     * @throws \yii\web\NotFoundHttpException if the model cannot be found
     */
    protected function findModelByHash($hash)
    {
        $model = Order::find()
            ->where(['hash' => $hash])
            ->andWhere(['buyer_id' => Yii::$app->user->id])
            ->one();

        if ($model !== null) {
            return $model;
        }

        $this->notFound('The requested page does not exist.');
    }
}
