<?php

namespace app\models;

use app\models\Tasks;
use kartik\daterange\DateRangeBehavior;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TasksSearch represents the model behind the search form of `app\models\Tasks`.
 */
class TasksSearch extends Tasks
{
    public $createTimeRange;
    public $createTimeStart;
    public $createTimeEnd;

    public function behaviors()
    {
        return [
            [
                'class' => DateRangeBehavior::className(),
                'attribute' => 'date_create',
                'dateStartAttribute' => 'createTimeStart',
                'dateEndAttribute' => 'createTimeEnd',
            ]
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'status'], 'integer'],
            [['name', 'date_create', 'date_update', 'deals_id', 'date_end'], 'safe'],
            [['date_end'], 'match', 'pattern' => '/^.+\s\-\s.+$/'],
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
        if(\Yii::$app->authManager->getRolesByUser(\Yii::$app->getUser()->identity->getId())['superadmin']->name == 'superadmin' || \Yii::$app->authManager->getRolesByUser(\Yii::$app->getUser()->identity->getId())['admin']->name == 'admin'){
            $query = Tasks::find();
            $query->where(['>','status', 0]);
        }else{
            $query = Tasks::find()->where(['user_id' =>  \Yii::$app->user->id])->andWhere(['>','status', 0]);
            //query->where(['>','status', 0]);
        }


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
            'deals_id' => $this->deals_id,
            'user_id' => $this->user_id,
            //'date_create' => $this->date_create,
            'date_update' => $this->date_update,
            'status' => $this->status,
            //'date_end' =>  $this->createTimeEnd,
        ]);

        // Фильтра по датам
        if(strlen($this->createTimeStart) > 0) {
            $query->andFilterWhere([
                '(date_end) >' =>  date('Y-m-d', $this->createTimeStart),
                '(date_end) <' =>  date('Y-m-d', $this->createTimeEnd),
            ]);
        }


        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'deals_id', $this->deals_id]);
        $query->andFilterWhere(['like', 'date_end', $this->date_end]);

        return $dataProvider;
    }
}
