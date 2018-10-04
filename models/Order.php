<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property int $id
 * @property string $g2a_order_id
 * @property string $g2a_game_id
 * @property string $hash
 * @property int $buyer_id
 * @property string $price
 * @property string $selling_price
 * @property string $currency_id
 * @property string $currency_rate
 * @property int $status
 * @property string $g2a_transaction_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $buyer
 * @property Game $game
 * @property Currency $currency
 * @property GameKey $gameKey
 */
class Order extends ActiveRecord
{
    const STATUS_NEW = 1;
    const STATUS_PENDING = 2;
    const STATUS_COMPLATE = 3;
    const STATUS_ERROR = 4;
    const STATUS_PAID = 5;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

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
    public function rules()
    {
        return [
            [['hash', 'buyer_id', 'price', 'selling_price', 'currency_rate'], 'required'],
            [['buyer_id', 'status'], 'integer'],
            [['price', 'selling_price', 'currency_rate'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['g2a_order_id', 'g2a_game_id', 'hash', 'g2a_transaction_id'], 'string', 'max' => 255],
            [['buyer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['buyer_id' => 'id']],
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::className(), 'targetAttribute' => ['currency_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'g2a_order_id' => 'G2a Order ID',
            'g2a_game_id' => 'G2a Game ID',
            'hash' => 'Hash',
            'buyer_id' => 'Buyer ID',
            'price' => 'Price',
            'selling_price' => 'Selling Price',
            'currency_id' => 'Currency',
            'currency_rate' => 'Currency Rate',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuyer()
    {
        return $this->hasOne(User::className(), ['id' => 'buyer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGame()
    {
        return $this->hasOne(Game::className(), ['g2a_id' => 'g2a_game_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGameKey()
    {
        return $this->hasOne(GameKey::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
    }

    public static function placeAnOrder($g2a_game_id, $user_id, $price)
    {
        $order = new Order();
        $order->g2a_game_id = $g2a_game_id;
        $order->hash = $order->generateUniqueRandomString();
        $order->buyer_id = $user_id;
        $order->price = $price;

        $currency = Currency::getCurrentCurrency();

        $order->currency_id = $currency['id'];
        $order->currency_rate = $currency['rate'];
        $order->status = Order::STATUS_NEW;

        $g2a = G2APay::addOrder($g2a_game_id);

        $order->selling_price = $g2a['price'];
        $order->g2a_order_id = $g2a['order_id'];

        $order->save();

        return $order;
    }

    public static function generateUniqueRandomString($n = 50)
    {
        $code = Yii::$app->getSecurity()->generateRandomString($n);

        $verification_code = static::find()
            ->where(['hash' => $code])
            ->one();

        if (empty($verification_code)) {
            return $code;
        } else {
            return static::generateUniqueRandomString();
        }
    }

    /**
     * @return string[]
     */
    public static function getStatusNames()
    {
        return [
            static::STATUS_NEW => 'Nowy',
            static::STATUS_PENDING => 'Oczekujący',
            static::STATUS_COMPLATE => 'Zakończony',
            static::STATUS_ERROR => 'Błąd',
            static::STATUS_PAID => 'Opłacono',
        ];
    }

    /**
     * @return string
     */
    public function getStatusName()
    {
        return static::getStatusNames()[$this->status];
    }
}
