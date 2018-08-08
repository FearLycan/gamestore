<?php

namespace app\controllers;

use app\components\AccessControl;
use app\models\forms\RegistrationForm;
use app\models\User;
use Yii;
use app\components\Controller;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;
use app\models\forms\LoginForm;

class AuthController extends Controller
{

    /**
     * @inheritdoc
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
                    [
                        'allow' => true,
                        'actions' => [
                            'login'
                        ],
                        'roles' => ['?'],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            Yii::$app->user->identity->last_login_at = date('Y-m-d H:i:s');
            Yii::$app->user->identity->save(false, ['last_login_at']);

            return $this->goHome();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Action logout current user.
     *
     * @return Response
     */
    public function actionLogout()
    {
        if (!Yii::$app->user->isGuest) {
            Yii::$app->user->logout();
        }

        return $this->goHome();
    }


    public function actionRegistration()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $status = false;
        $model = new RegistrationForm();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->password = User::hashPassword($model->password_first);
            $model->auth_key = User::generateUniqueRandomString();
            $model->verification_code = User::generateUniqueRandomString();
            $model->save();
            //$model->sendEmail();
            $status = true;
        }

        return $this->render('registration', [
            'model' => $model,
            'status' => $status,
        ]);
    }

    public function actionReset()
    {
        return $this->render('reset', [
            // 'model' => $model,
        ]);
    }

    public function actionActivation($code)
    {
        /* @var $user User */
        $user = User::find()->where(['verification_code' => $code, 'status' => User::STATUS_INACTIVE])->one();

        $confirm = false;

        if (!empty($user)) {
            $user->status = User::STATUS_ACTIVE;
            $user->save();
            $confirm = true;
        }

        return $this->render('activation', [
            'confirm' => $confirm,
            'user' => $user,
        ]);
    }
}