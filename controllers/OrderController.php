<?php

namespace app\controllers;

use app\components\AccessControl;
use app\components\Controller;
use app\models\Cart;
use app\models\G2APay;
use app\models\Game;
use app\models\GameKey;
use app\models\Order;
use app\models\searches\OrderSearch;
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
//                    'pay' => ['POST'],
//                    'create' => ['POST'],
//                    'get_key' => ['POST'],
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

    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPlaceAnOrder()
    {
        $cookies = Yii::$app->request->cookies;
        $cart = json_decode($cookies->get('cart'), true);
        $pCode = json_decode($cookies->get('promo'), true);

        if (count($cart) == 0) {
            $this->redirect(['cart/index']);
        }

        $ids = array_column($cart, 'id');

        $products = Cart::getProducts($ids, $cart, $pCode);

        $order = Order::placeAnOrder($products);

        if (!$order) {
            //redircet to error page
        }

        return $this->redirect(['order/success', 'hash' => $order->hash]);

    }

    public function actionSuccess($hash)
    {
        $order = Order::find()
            ->where(['hash' => $hash])
            ->andWhere(['buyer_id' => Yii::$app->user->id])
            ->one();

        if ($order !== null) {
            return $this->render('success', [
                'order' => $order,
            ]);
        }

        $this->notFound('The requested page does not exist.');
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
