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

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'g2a_id' => $this->g2a_id,
            'type' => $this->type,
            'qty' => $this->qty,
            'min_price' => $this->min_price,
            'price' => $this->price,
            'discount' => $this->discount,
            'region' => $this->region,
            'platform' => $this->platform,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'thumbnail', $this->thumbnail])
            ->andFilterWhere(['like', 'smallImage', $this->smallImage])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'developer', $this->developer])
            ->andFilterWhere(['like', 'publisher', $this->publisher])
            ->andFilterWhere(['like', 'restrictions', $this->restrictions])
            ->andFilterWhere(['like', 'requirements', $this->requirements])
            ->andFilterWhere(['like', 'videos', $this->videos]);

        return $dataProvider;
    }
}
