<?php

namespace app\components;

use app\models\LogErrorPage;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class Controller extends \yii\web\Controller
{
    /**
     * Throws NotFoundHttpException.
     *
     * @param string|null $message
     * @throws NotFoundHttpException
     */
    public function notFound($message = null)
    {
        if ($message === null) {
            $message = Translator::translate('The page you are looking for does not exist.');
        }

        LogErrorPage::log(LogErrorPage::TYPE_ERROR_404);

        throw new NotFoundHttpException($message);
    }

    /**
     * Throws ForbiddenHttpException.
     *
     * @param string|null $message
     * @throws ForbiddenHttpException
     */
    public function accessDenied($message = null)
    {
        if ($message === null) {
            $message = Translator::translate('You are not authorized to view this page.');
        }
        throw new ForbiddenHttpException($message);
    }
}