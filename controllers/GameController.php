<?php

namespace app\controllers;

use app\models\forms\CartForm;
use app\models\Genre;
use app\models\Platform;
use Yii;
use app\models\Game;
use app\models\searches\GameSearch;
use app\components\Controller;
use yii\web\NotFoundHttpException;

/**
 * GameController implements the CRUD actions for Game model.
 */
class GameController extends Controller
{
    /**
     * Lists all Game models.
     * @return mixed
     */
    public function actionIndex($data = null)
    {
        $link['link'] = '/games';

        if (!empty($data)) {

            $genre = Genre::find()->where(['slug' => $data])->one();

            if (empty($genre)) {

                $platform = Platform::find()->where(['slug' => $data])->one();

                if (!empty($platform)) {
                    $link['platform'] = $platform;
                    $link['name'] = $platform->name;
                } else {
                    $this->notFound('The requested page does not exist.');
                }
            } else {
                $link['genre'] = $genre;
                $link['name'] = $genre->name;
            }
        }

        $searchModel = new GameSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $link);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'link' => $link,
        ]);
    }

    /**
     * Displays a single Game model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($slug, $success = false)
    {
        $model = $this->findModel($slug);

        $cart = new CartForm();
        $cart->qty = 1;
        $cart->max_qty = $model->qty;
        $cart->id = $model->id;

        if ($cart->load(Yii::$app->request->post()) && $cart->validate()) {
            $cart->addToCart();

            Yii::$app->session->setFlash('cart-success');

            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->render('view', [
            'model' => $model,
            'cart' => $cart,
        ]);
    }

    /**
     * Finds the Game model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Game the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($slug)
    {
        $model = Game::find()->where(['slug' => $slug])->one();

        if ($model !== null) {
            return $model;
        }

        $this->notFound('The requested page does not exist.');
    }
}
