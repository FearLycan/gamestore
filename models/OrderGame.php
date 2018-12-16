<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%order_game}}".
 *
 * @property int $id
 * @property int $game_id
 * @property int $order_id
 * @property string $keys
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Game $game
 * @property Order $order
 */
class OrderGame extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%order_game}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['game_id', 'order_id', 'keys'], 'required'],
            [['game_id', 'order_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['keys'], 'string'],
            [['game_id'], 'exist', 'skipOnError' => true, 'targetClass' => Game::className(), 'targetAttribute' => ['game_id' => 'id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'game_id' => 'Game ID',
            'order_id' => 'Order ID',
            'keys' => 'Keys',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGame()
    {
        return $this->hasOne(Game::className(), ['id' => 'game_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }
}
