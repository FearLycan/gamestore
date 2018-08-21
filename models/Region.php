<?php

namespace app\models;

use app\components\SluggableBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%region}}".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 */
class Region extends \yii\db\ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

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
            'sluggable' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'slugAttribute' => 'slug',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%region}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return string[]
     */
    public static function getStatusNames()
    {
        return [
            static::STATUS_ACTIVE => 'Aktywny',
            static::STATUS_INACTIVE => 'Nieaktywny',
        ];
    }

    /**
     * @return string
     */
    public function getStatusName()
    {
        return User::getStatusNames()[$this->status];
    }

    public static function check($name)
    {
        $region = Region::find()->where(['name' => $name])->one();

        if (empty($region)) {
            $region = new Region();
            $region->name = $name;
            $region->save();
        }

        return $region->id;
    }

    /**
     * @return array
     */
    public static function getRegionsNames()
    {
        $regions = Region::find()
            ->select(['id', 'name'])
            ->where(['status' => Platform::STATUS_ACTIVE])
            ->all();

        return ArrayHelper::map($regions, 'id', 'name');
    }
}
