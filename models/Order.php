<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\Cookie;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property int $id
 * @property string $hash
 * @property int $buyer_id
 * @property string $price
 * @property int $currency_id
 * @property string $currency_rate
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property GameKey[] $gameKeys
 * @property User $buyer
 * @property Currency $currency
 * @property OrderGame[] $orderGames
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
            [['hash', 'buyer_id', 'price', 'currency_id', 'currency_rate'], 'required'],
            [['buyer_id', 'currency_id', 'status'], 'integer'],
            [['price', 'currency_rate'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['hash'], 'string', 'max' => 255],
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
            'hash' => 'Hash',
            'buyer_id' => 'Buyer ID',
            'price' => 'Price',
            'currency_id' => 'Currency ID',
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
        return $this->hasOne(Game::className(), ['id' => 'game_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderGames()
    {
        return $this->hasMany(OrderGame::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
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

    public static function placeAnOrder($products)
    {
        $currency = Currency::getCurrentCurrency();

        $order = new Order();

        $order->hash = $order->generateUniqueRandomString();
        $order->buyer_id = Yii::$app->user->identity->id;

        if (isset($products['total-promo'])) {
            $order->price = $products['total-promo'];
        } else {
            $order->price = $products['total'];
        }

        $order->currency_id = $currency['id'];
        $order->currency_rate = $currency['rate'];
        $order->status = Order::STATUS_NEW;

        $order->save();

        foreach ($products['items'] as $product) {
            $order_game = new OrderGame();
            $order_game->game_id = $product['id'];
            $order_game->order_id = $order->id;

            $keys = [];

            foreach (range(1, $product['quantity']) as $number) {
                $keys[] = strtoupper(Yii::$app->getSecurity()->generateRandomString(5) . '-' . Yii::$app->getSecurity()->generateRandomString(5) .
                    '-' . Yii::$app->getSecurity()->generateRandomString(5) . '-' . Yii::$app->getSecurity()->generateRandomString(5));
            }

            $order_game->keys = json_encode($keys);

            $order_game->save();

            if($order_game->errors){
                die(var_dump($order_game->errors));
            }

        }

        $cartCookie = new Cookie([
            'name' => 'cart',
            'value' => json_encode([]),
            'expire' => time() + 60 * 60 * 24 * 7, // 7 days
        ]);

        $promoCookie = new Cookie([
            'name' => 'promo',
            'value' => json_encode([]),
            'expire' => time() + 60 * 60 * 24 * 7, // 7 days
        ]);

        Yii::$app->response->cookies->add($cartCookie);
        Yii::$app->response->cookies->add($promoCookie);

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
}
