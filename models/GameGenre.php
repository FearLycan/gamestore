<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%game_genre}}".
 *
 * @property int $game_id
 * @property int $genre_id
 *
 * @property Game $game
 * @property Genre $genre
 */
class GameGenre extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%game_genre}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['game_id', 'genre_id'], 'required'],
            [['game_id', 'genre_id'], 'integer'],
            [['game_id', 'genre_id'], 'unique', 'targetAttribute' => ['game_id', 'genre_id']],
            [['game_id'], 'exist', 'skipOnError' => true, 'targetClass' => Game::className(), 'targetAttribute' => ['game_id' => 'id']],
            [['genre_id'], 'exist', 'skipOnError' => true, 'targetClass' => Genre::className(), 'targetAttribute' => ['genre_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'game_id' => 'Game ID',
            'genre_id' => 'Genre ID',
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
    public function getGenre()
    {
        return $this->hasOne(Genre::className(), ['id' => 'genre_id']);
    }

    public static function removeAllByGameID($game_id)
    {
        GameGenre::deleteAll(['game_id' => $game_id]);
    }

    public static function makeConnection($game_id, $genres)
    {
        self::removeAllByGameID($game_id);

        foreach ($genres as $genre_id) {
            $genre = new GameGenre();
            $genre->game_id = $game_id;
            $genre->genre_id = $genre_id;
            $genre->save();

            unset($genre);
        }
    }
}
