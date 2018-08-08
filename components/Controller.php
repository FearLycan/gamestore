<?php

namespace app\components;

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
            $message = 'Strona, której szukasz nie istnieje.';
        }
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
            $message = 'Nie jesteś uprawniony do przeglądania tej strony.';
        }
        throw new ForbiddenHttpException($message);
    }
}