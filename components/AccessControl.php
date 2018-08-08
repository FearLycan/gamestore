<?php
namespace app\components;
/**
 * Internal access control filter.
 */
class AccessControl extends \yii\filters\AccessControl
{
    /**
     * {@inheritdoc}
     */
    public $ruleConfig = [
        'class' => 'app\components\AccessRule',
    ];
}