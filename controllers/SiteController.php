<?php

namespace app\controllers;

use app\components\Helpers;
use app\models\Game;
use app\models\Genre;
use app\models\Language;
use app\models\Platform;
use Yii;
use yii\filters\AccessControl;
use app\components\Controller;
use yii\helpers\Url;
use yii\web\Cookie;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'language' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionJson($phrase)
    {
        if (strlen($phrase) >= 3) {

            $platforms = Platform::find()
                ->where(['like', 'name', $phrase])
                ->orderBy(['name' => SORT_DESC])
                ->limit(5)
                ->all();

            $genres = Genre::find()
                ->where(['like', 'name', $phrase])
                ->orderBy(['name' => SORT_DESC])
                ->limit(5)
                ->all();

            $titleDelimiters = [
                '{',
                '}',
                '\\',
                '/',
                '–',
                '_',
                ':',
                '\'',
                '.',
                ',',
                '!',
                '?',
                '[',
                ']',
                '(',
                ')',
                '&',
                '#',
                '-',
                '+',
            ];

            $results = [];
            /*$where[] = 'OR';
            $phrase = str_replace($titleDelimiters, ' ', $phrase);
            if (strpos($phrase, ' ') !== false) {

                $phrases = explode(' ', $phrase);
                foreach ($phrases as $word) {
                    $where[] = ['like', 'name', $word];
                }
            } else {
                $where[] = ['like', 'name', $phrase];
            }*/

            $games = Game::find()
                ->where(['status' => Game::STATUS_ACTIVE])
                ->andWhere(['like', 'name', $phrase])
                ->orderBy(['name' => SORT_DESC])
                ->limit(10)
                ->all();


            /* @var $platform Platform */
            foreach ($platforms as $platform) {
                $results[] = [
                    'id' => $platform->id,
                    'name' => $platform->name . ' - Games',
                    'link' => Url::to(['games/' . $platform->slug], true),
                    'img' => 'http://via.placeholder.com/58x58',
                    'type' => 'platform',
                ];
            }

            /* @var $genre Genre */
            foreach ($genres as $genre) {
                $results[] = [
                    'id' => $genre->id,
                    'name' => $genre->name . ' - Games',
                    'link' => Url::to(['games/' . $genre->slug], true),
                    'img' => 'http://via.placeholder.com/58x58',
                    'type' => 'genre',
                ];
            }

            /* @var $game Game */
            foreach ($games as $game) {
                $results[] = [
                    'id' => $game->id,
                    'name' => Helpers::cutThis($game->name, 50),
                    'link' => Url::to(['game/view', 'slug' => $game->slug], true),
                    'img' => $game->thumbnail,
                    'price' => $game->price,
                    'type' => 'game',
                ];
            }

            Yii::$app->response->format = Response::FORMAT_JSON;
            return $results;

        } else {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [];
        }


    }

    /**
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionLanguage()
    {
        if (Yii::$app->request->post()) {
            $language = Yii::$app->request->post('language');

            $lang = Language::find()->where(['short_name' => $language])->one();

            if ($lang === null) {
                throw new NotFoundHttpException('The requested page does not exist.');
            } else {
                Yii::$app->language = $language;

                $languageCookie = new Cookie([
                    'name' => 'language',
                    'value' => $language,
                    'expire' => time() + 60 * 60 * 24 * 30, // 30 days
                ]);
                Yii::$app->response->cookies->add($languageCookie);
                $this->redirect(Yii::$app->request->referrer);
            }
        }
    }
}
