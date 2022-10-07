<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Doctors;

/**
 * SearchDoctors represents the model behind the search form of `frontend\models\Doctors`.
 */
class SearchDoctors extends Doctors
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'work_experience', 'treated_patients'], 'integer'],
            [['name', 'last_name', 'first_name', 'specialization', 'photo', 'specialization_text', 'about_doc', 'sertificates', 'education', 'date_create'], 'safe'],
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
        $query = Doctors::find();

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
            'work_experience' => $this->work_experience,
            'treated_patients' => $this->treated_patients,
            'date_create' => $this->date_create,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'specialization', $this->specialization])
            ->andFilterWhere(['like', 'photo', $this->photo])
            ->andFilterWhere(['like', 'specialization_text', $this->specialization_text])
            ->andFilterWhere(['like', 'about_doc', $this->about_doc])
            ->andFilterWhere(['like', 'sertificates', $this->sertificates])
            ->andFilterWhere(['like', 'education', $this->education]);

        return $dataProvider;
    }
}
