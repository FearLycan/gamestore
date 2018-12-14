<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\Expression;

class Cart extends ActiveRecord
{
    public static function getCross($id)
    {
        $game = Game::findOne($id);

        if (!empty($game)) {
            $cross = Game::find()
                ->where(['platform_id' => $game->platform_id])
                ->orderBy(new Expression('rand()'))
                ->limit(3)
                ->all();

            return $cross;
        }

        return false;
    }
}