<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%game}}".
 *
 * @property int $id
 * @property string $g2a_id
 * @property string $name
 * @property int $type
 * @property string $slug
 * @property int $qty
 * @property string $min_price
 * @property string $price
 * @property int $discount
 * @property string $thumbnail
 * @property string $smallImage
 * @property string $description
 * @property string $developer
 * @property string $publisher
 * @property string $restrictions
 * @property string $requirements
 * @property string $videos
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Region $region
 * @property Platform $platform
 */
class Game extends \yii\db\ActiveRecord
{

    //statusy
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    //typy
    const TYPE_KEY = 1; //klucz
    const TYPE_OTHER = 0;

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
        return '{{%game}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['g2a_id', 'type', 'qty', 'discount', 'region', 'platform', 'status'], 'integer'],
            [['name', 'type', 'slug', 'min_price', 'price', 'region', 'platform'], 'required'],
            [['min_price', 'price'], 'number'],
            [['description', 'videos', 'requirements'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'slug', 'thumbnail', 'smallImage', 'developer', 'publisher', 'restrictions'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'g2a_id' => 'G2a ID',
            'name' => 'Name',
            'type' => 'Type',
            'slug' => 'Slug',
            'qty' => 'Qty',
            'min_price' => 'Min Price',
            'price' => 'Price',
            'discount' => 'Discount',
            'thumbnail' => 'Thumbnail',
            'smallImage' => 'Small Image',
            'description' => 'Description',
            'region' => 'Region',
            'developer' => 'Developer',
            'publisher' => 'Publisher',
            'platform' => 'Platform',
            'restrictions' => 'Restrictions',
            'requirements' => 'Requirements',
            'videos' => 'Videos',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return string[]
     */
    public static function getTypesNames()
    {
        return [
            static::TYPE_KEY => 'Aktywny',
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

    /**
     * @return ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPlatform()
    {
        return $this->hasOne(Platform::className(), ['id' => 'platform']);
    }
}
