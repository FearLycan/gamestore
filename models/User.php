<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $email
 * @property string $password
 * @property integer $role
 * @property integer $status
 * @property string $registered_at
 * @property string $last_login_at
 * @property string $last_seen
 * @property string $auth_key
 * @property string $verification_code
 *
 */
class User extends ActiveRecord implements IdentityInterface
{
    //statusy
    const STATUS_INACTIVE = 0; //użytkownik zarejestrował się ale nie potwierdził danych z forum.
    const STATUS_ACTIVE = 1;   //aktywny użytkownik
    const STATUS_BAN = 3;

    //role
    const ROLE_USER = 1;
    const ROLE_MODERSTOR = 2;
    const ROLE_ADMIN = 10;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role', 'status'], 'integer'],
            [['registered_at', 'last_name_at', 'last_seen'], 'safe'],
            [['name', 'email', 'password', 'auth_key', 'verification_code'], 'string', 'max' => 255],
            [['email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nazwa',
            'slug' => 'Slug',
            'email' => 'E-mail',
            'password' => 'Hasło',
            'role' => 'Role',
            'status' => 'Status',
            'registered_at' => 'Registered At',
            'last_login_at' => 'Last Login At',
            'last_seen' => 'Last Seen',
            'auth_key' => 'Auth Key',
            'verification_code' => 'Verification Code',
        ];
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
                    ActiveRecord::EVENT_BEFORE_INSERT => ['registered_at'],
                ],
                'value' => date("Y-m-d H:i:s"),
            ],
            'slug' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
            ],
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
            static::STATUS_BAN => 'BAN',
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
     * @return string[]
     */
    public static function getRolesNames()
    {
        return [
            static::ROLE_USER => 'Użytkownik',
            static::ROLE_MODERSTOR => 'Moderator',
            static::ROLE_ADMIN => 'Administrator',
        ];
    }

    /**
     * @return string
     */
    public function getRoleName()
    {
        return static::getRolesNames()[$this->role];
    }

    /**
     * @return array
     */
    public static function getAdministratorRoles()
    {
        return [
            static::ROLE_ADMIN,
        ];
    }

    /**
     * @return bool
     */
    public function isAdministrator()
    {
        return in_array($this->role, static::getAdministratorRoles()) && $this->isActive();
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->status == static::STATUS_ACTIVE;
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return User
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return User
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @param $password
     * @return bool
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    public static function hashPassword($password)
    {
        return Yii::$app->getSecurity()->generatePasswordHash($password);
    }

    public function sendEmail()
    {
        Yii::$app->mailer
            ->compose("welcome-message", [
                'user' => $this,
            ])
            ->setFrom([Yii::$app->params['site-email'] => Yii::$app->name])
            ->setTo([$this->email => $this->name])
            ->setSubject('Your account has been created')
            ->send();
    }

    public static function generateUniqueRandomString()
    {
        $code = Yii::$app->getSecurity()->generateRandomString(32);

        $verification_code = static::find()
            ->where(['verification_code' => $code])
            ->orWhere(['auth_key' => $code])
            ->one();

        if (empty($verification_code)) {
            return $code;
        } else {
            return static::generateUniqueRandomString();
        }
    }
}
