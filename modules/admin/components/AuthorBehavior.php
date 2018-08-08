<?php

namespace app\modules\admin\components;

use yii\base\Behavior;
use yii\db\ActiveRecord;

/*
 *  @author Damian Brończyk <damian.bronczyk@gmail.com.pl>
 */

class AuthorBehavior extends Behavior
{
    public $field = 'author_id';

    public $value;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

    }

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
        ];
    }

    public function beforeInsert($event)
    {
        $this->owner->{$this->field} = $this->getValue();
    }

    public function getValue()
    {
        if (empty($this->value)) {
            return \Yii::$app->user->id;
        } else {
            return $this->value;
        }
    }

}