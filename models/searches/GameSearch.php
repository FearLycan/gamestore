<?php

namespace app\models\searches;

use app\models\Genre;
use app\models\Platform;
use app\models\Region;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Game;
use yii\helpers\ArrayHelper;

/**
 * GameSearch represents the model behind the search form of `app\models\Game`.
 *
 * @property array $genres
 * @property array $platform
 * @property array $region
 * @property double $min_price
 * @property double $max_price
 * @property string $search
 */
class GameSearch extends Game
{
    public $genre;
    public $platform;
    public $region;
    public $min_price;
    public $max_price;
    public $search;

    /**
     * Min length of phrase part.
     *
     * @var int
     */
    public $minLength = 3;

    /**
     * @var string[]
     */
    public $nameDelimiters = [
        '{',
        '}',
        '\\',
        '/',
        '–',
        '_',
        ':',
        '\'',
        '.',
        ',',
        '!',
        '?',
        '[',
        ']',
        '(',
        ')',
        '&',
        '#',
        '-',
        '+',
    ];

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // [['id', 'g2a_id', 'type', 'qty', 'discount', 'region_id', 'platform_id', 'status'], 'integer'],
            // [['name', 'slug', 'thumbnail', 'smallImage', 'description', 'developer', 'publisher', 'restrictions', 'requirements', 'videos', 'created_at', 'updated_at'], 'safe'],


            [['min_price', 'max_price'], 'number'],
            [['search'], 'string'],
            [['genre'], 'in', 'range' => array_keys(static::getGenresNames()), 'allowArray' => true],
            [['platform'], 'in', 'range' => array_keys(static::getPlatformsNames()), 'allowArray' => true],
            [['region'], 'in', 'range' => array_keys(static::getRegionNames()), 'allowArray' => true],
        ];
    }

    public function formName()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $link = null)
    {
        $query = Game::find();

        if (isset($link['platform'])) {
            $query->joinWith(['platform pp']);
            $query->andFilterWhere(['=', 'pp.id', $link['platform']->id]);
            $this->platform[] = $link['platform']->id;
        } elseif (isset($link['genre'])) {
            $query->joinWith(['genres gg']);
            $query->andFilterWhere(['=', 'gg.id', $link['genre']->id]);
            $this->genre[] = $link['genre']->id;
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 21,
            ],
        ]);


        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if (!empty($this->genre) && is_array($this->genre)) {
            $query->joinWith(['genres gg']);
            $query->andFilterWhere(['in', 'gg.id', $this->genre]);
        }

        if (!empty($this->platform) && is_array($this->platform)) {
            $query->andFilterWhere(['in', 'platform_id', $this->platform]);
        }

        if (!empty($this->region) && is_array($this->region)) {
            $query->andFilterWhere(['in', 'region_id', $this->region]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'g2a_id' => $this->g2a_id,
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'game.name', $this->search]);

        //die(var_dump($this->titleSearch($this->search)));
        //  $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere($this->priceMinMaxFilter());

        return $dataProvider;
    }

    /**
     * @return array
     */
    public static function getGenresNames()
    {
        $genres = ArrayHelper::map(
            Genre::find()
                ->where(['status' => Genre::STATUS_ACTIVE])
                ->all(),
            'id', 'name');

        return $genres;
    }

    /**
     * @return array
     */
    public static function getPlatformsNames()
    {
        $platforms = ArrayHelper::map(
            Platform::find()
                ->where(['status' => Genre::STATUS_ACTIVE])
                ->all(),
            'id', 'name');

        return $platforms;
    }

    /**
     * @return array
     */
    public static function getRegionNames()
    {
        $regions = ArrayHelper::map(
            Region::find()
                ->where(['status' => Genre::STATUS_ACTIVE])
                ->all(),
            'id', 'name');

        return $regions;
    }

    public function priceMinMaxFilter()
    {
        if (empty($this->min_price)) {
            return ['between', 'price', 0, $this->max_price];
        } elseif (empty($this->max_price)) {
            return ['between', 'price', $this->min_price, 1000];
        }

        return ['between', 'price', $this->min_price, $this->max_price];
    }
}
