<?php

namespace app\modules\admin\models\forms;

use app\modules\admin\models\Game;

class GameForm extends Game
{
    public $genre;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['discount', 'status'], 'integer'],
            [['price', 'status'], 'required'],
            [['price'], 'number'],
            ['genre', 'each', 'rule' => ['integer']],
        ];
    }
}