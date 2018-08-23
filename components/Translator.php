<?php
/**
 * Created by PhpStorm.
 * User: Damian Brończyk
 * Date: 23.08.2018
 * Time: 14:58
 */

namespace app\components;


use app\models\Translation;
use Yii;

class Translator
{
    public static function translate($phrase)
    {
        /* @var $translate Translation */
        $translate = Translation::find()
            ->joinWith('language language')
            ->where(['translation.phrase' => $phrase])
            ->andWhere(['language.short_name' => Yii::$app->language])
            ->one();

        if (empty($translate)) {
            return $phrase;
        } else {
            return $translate->translation;
        }
    }
}