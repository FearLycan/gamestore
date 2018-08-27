<?php

namespace app\models;

use app\components\Translator;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%currency}}".
 *
 * @property int $id
 * @property string $country
 * @property string $name
 * @property string $short_name
 * @property string $code
 * @property string $rate
 * @property int $side
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 */
class Currency extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    const SIDE_LEFT = 0;
    const SIDE_RIGHT = 1;

    /**
     * @param bool $insert
     * @return array
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => date("Y-m-d H:i:s"),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%currency}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['country', 'name', 'short_name', 'code', 'rate', 'status'], 'required'],
            [['rate'], 'number'],
            [['side', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['country', 'name', 'short_name'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 12],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'country' => 'Country',
            'name' => 'Name',
            'short_name' => 'Short Name',
            'code' => 'Code',
            'rate' => 'Rate',
            'status' => 'Status',
            'side' => 'Side',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return string[]
     */
    public static function getSidesNames()
    {
        return [
            static::SIDE_LEFT => Translator::translate('side_left'),
            static::SIDE_RIGHT => Translator::translate('side_right'),
        ];
    }

    /**
     * @return string
     */
    public function getSidesName()
    {
        return self::getSidesNames()[$this->status];
    }

    /**
     * @return string[]
     */
    public static function getStatusNames()
    {
        return [
            static::STATUS_ACTIVE => Translator::translate('Active'),
            static::STATUS_INACTIVE => Translator::translate('Inactive'),
        ];
    }

    /**
     * @return string
     */
    public function getStatusName()
    {
        return User::getStatusNames()[$this->status];
    }

    public static function getSupportedCurrency()
    {
        $currency = ArrayHelper::map(
            Currency::find()->where(['status' => Currency::STATUS_ACTIVE])->all(),
            'id', 'code');

        return $currency;
    }
}
