<?php

namespace app\modules\admin\models\searches;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\Game;

/**
 * GameSearch represents the model behind the search form of `app\modules\admin\models\Game`.
 */
class GameSearch extends Game
{
    public $platform;
    public $region;
    public $name;
    public $status;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'g2a_id', 'type', 'qty', 'discount', 'region', 'platform', 'status'], 'integer'],
            [['name', 'slug', 'thumbnail', 'smallImage', 'description', 'developer', 'publisher', 'restrictions', 'requirements', 'videos', 'created_at', 'updated_at'], 'safe'],
            [['min_price', 'price'], 'number'],
        ];
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
    public function search($params)
    {
        $query = Game::find();
        $query->joinWith(['region region', 'platform platform']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['region'] = [
            'asc' => ['region.name' => SORT_ASC],
            'desc' => ['region.name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['platform'] = [
            'asc' => ['platform.name' => SORT_ASC],
            'desc' => ['platform.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            //  'id' => $this->id,
            //'g2a_id' => $this->g2a_id,
            'game.type' => $this->type,
            'game.qty' => $this->qty,
            'game.min_price' => $this->min_price,
            'game.price' => $this->price,
            // 'discount' => $this->discount,
            'region.id' => $this->region,
            'platform.id' => $this->platform,
            'game.status' => $this->status,
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere([
            'or',
            ['like', 'game.name', $this->name],
            ['like', 'game.g2a_id', $this->name],
        ])
            ->andFilterWhere(['=', 'platform.id', $this->platform])
            ->andFilterWhere(['=', 'region.id', $this->region]);

        return $dataProvider;
    }
}
