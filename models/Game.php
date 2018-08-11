<?php

namespace app\models;

use Yii;

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
 * @property int $region_id
 * @property string $developer
 * @property string $publisher
 * @property int $platform_id
 * @property string $restrictions
 * @property string $requirements
 * @property string $videos
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Platform $platform
 * @property Region $region
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
            [['g2a_id', 'type', 'qty', 'discount', 'region_id', 'platform_id', 'status'], 'integer'],
            [['name', 'type', 'slug', 'min_price', 'price'], 'required'],
            [['min_price', 'price'], 'number'],
            [['description', 'requirements', 'videos'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'slug', 'thumbnail', 'smallImage', 'developer', 'publisher', 'restrictions'], 'string', 'max' => 255],
            [['platform_id'], 'exist', 'skipOnError' => true, 'targetClass' => Platform::className(), 'targetAttribute' => ['platform_id' => 'id']],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['region_id' => 'id']],
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
            'region_id' => 'Region ID',
            'developer' => 'Developer',
            'publisher' => 'Publisher',
            'platform_id' => 'Platform ID',
            'restrictions' => 'Restrictions',
            'requirements' => 'Requirements',
            'videos' => 'Videos',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlatform()
    {
        return $this->hasOne(Platform::className(), ['id' => 'platform_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }
}
