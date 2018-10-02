<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%log_error_page}}".
 *
 * @property int $id
 * @property string $url
 * @property string $IP
 * @property int $type
 * @property string $description
 * @property string $created_at
 */
class LogErrorPage extends \yii\db\ActiveRecord
{
    const TYPE_ERROR_404 = 1;
    const TYPE_ERROR_404_AUTH = 2;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%log_error_page}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IP'], 'required'],
            [['type'], 'integer'],
            [['created_at'], 'safe'],
            [['url', 'description'], 'string', 'max' => 255],
            [['IP'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'IP' => 'Ip',
            'type' => 'Type',
            'description' => 'Description',
            'created_at' => 'Created At',
        ];
    }

    public static function log($type)
    {
        $log = new LogErrorPage();
        $log->type = $type;
        $log->IP = Yii::$app->getRequest()->getUserIP();

        if ($type == LogErrorPage::TYPE_ERROR_404_AUTH) {
            $log->description = 'UserID: ' . Yii::$app->user->getId();
        }

        $log->url = Yii::$app->request->url;
        $log->save();
    }
}
