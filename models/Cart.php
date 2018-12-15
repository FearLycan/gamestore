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

    public static function getProducts($ids, $cart, $pCode)
    {
        $total = 0;

        $products['items'] = Game::find()
            ->joinWith(['platform platform', 'region region'])
            ->select(['game.id', 'game.name', 'game.description', 'game.slug', 'game.qty', 'game.smallImage', 'game.region_id', 'game.platform_id',
                'game.price', 'region.name region', 'platform.name platform'])
            ->where(['in', 'game.id', $ids])
            ->andWhere(['game.status' => Game::STATUS_ACTIVE])
            ->asArray()
            ->all();

        foreach ($products['items'] as $key => $product) {
            foreach ($cart as $c) {
                if ($product['id'] == $c['id']) {
                    $products['items'][$key]['quantity'] = $c['qty'];
                    $total += ($products['items'][$key]['quantity'] * $products['items'][$key]['price']);
                }
            }
        }

        $products['total'] = $total;

        if (!empty($pCode)) {
            $products['promo-code'] = [
                'code' => $pCode['code'],
                'value' => $pCode['value'],
            ];

            $products['total-promo'] = ($total * (100 - $pCode['value'])) / 100;
        }


        return $products;
    }
}