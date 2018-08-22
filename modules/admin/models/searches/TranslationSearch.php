<?php

namespace app\modules\admin\models\searches;

use app\modules\admin\models\Language;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\Translation;

/**
 * TranslationSearch represents the model behind the search form of `app\modules\admin\models\Translation`.
 */
class TranslationSearch extends Translation
{
    public $language_id;
    public $phrase;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'language_id'], 'integer'],
            [['phrase', 'translation', 'scope'], 'string'],
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
        $this->language_id = Language::find()->where(['short_name' => Yii::$app->language])->one()->id;

        $query = Translation::find();

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
            'language_id' => $this->language_id,
        ]);

        $query->andFilterWhere(['like', 'phrase', $this->phrase]);
        $query->orFilterWhere(['like', 'scope', $this->phrase]);
        $query->orFilterWhere(['like', 'translation', $this->phrase]);
        $query->orFilterWhere(['=', 'id', $this->phrase]);

        return $dataProvider;
    }
}
