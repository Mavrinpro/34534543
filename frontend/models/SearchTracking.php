<?php

namespace frontend\models;

use app\models\Tracking;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

/**
 * SearchUsers represents the model behind the search form of `common\models\User`.
 */
class SearchTracking extends Tracking
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'date_at', 'date_end', 'session_start', 'session_end'], 'safe'],
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
        $query = Tracking::find();

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
            //'user_id' => $this->user_id,

            'date_at' => $this->date_at,
            'date_end' => $this->date_end,
            'session_start' => $this->session_start,
            'session_end' => $this->session_end,
        ]);

        $query->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'session_start', $this->session_start])
            ->andFilterWhere(['like', 'session_end', $this->session_end])
            ->andFilterWhere(['like', 'date_at', $this->date_at])
            ->andFilterWhere(['like', 'date_end', $this->date_end]);

        return $dataProvider;
    }
}
