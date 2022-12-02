<?php

namespace frontend\models;

use app\models\Tags;
use common\models\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Deals;

/**
 * SearchDeals represents the model behind the search form of `app\models\Deals`.
 */
class SearchDeals extends Deals
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_operator', 'id_filial', 'id_comment'], 'integer'],
            [['name', 'phone', 'tag', 'date_create', 'status'], 'safe'],
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
        $query = Deals::find();

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
            'date_create' => $this->date_create,
            'id_operator' => $this->id_operator,
            'id_filial' => $this->id_filial,
            'id_comment' => $this->id_comment,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'tag', $this->tag])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
