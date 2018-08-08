<?php

namespace app\modules\admin\components;

use app\components\AccessControl;
use app\modules\admin\models\User;


/**
 * Basic controller for admin panel.
 *
 * @author Damian Brończyk <damian.bronczyk@gmail.com.pl>
 */
class Controller extends \app\components\Controller
{
    /**
     * {@inheritdoc}
     */
    public $layout = 'admin';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [
                            User::ROLE_ADMIN,
                        ],
                        'statuses' => [
                            User::STATUS_ACTIVE,
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @param \yii\base\Action $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
   /* public function beforeAction($action)
    {
        $this->view->registerJs('menuActive("' . $this->uniqueId . '");');
        return parent::beforeAction($action);
    }*/
}
