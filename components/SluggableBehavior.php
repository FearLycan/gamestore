<?php

namespace app\components;

use yii\behaviors\SluggableBehavior as Slug;

class SluggableBehavior extends Slug
{
    /**
     * @param array $slugParts
     * @return string
     */
    protected function generateSlug($slugParts)
    {
        return Inflector::slug(implode('-', $slugParts));
    }
}