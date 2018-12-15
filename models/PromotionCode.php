<?php

namespace app\models;

use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "{{%promotion_code}}".
 *
 * @property int $id
 * @property string $code
 * @property int $value
 * @property string $expiration
 * @property string $created_at
 * @property string $updated_at
 */
class PromotionCode extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%promotion_code}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'value'], 'required'],
            [['value'], 'integer'],
            [['expiration', 'created_at', 'updated_at'], 'safe'],
            [['code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'value' => 'Value',
            'expiration' => 'Expiration',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function getRandomCode()
    {
        $code = PromotionCode::find()
        ->where(['>=', 'expiration', date("Y-m-d H:i:s")])
        ->orderBy(new Expression('rand()'))
        ->one();

        return $code;
    }
}
