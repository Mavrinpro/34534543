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
    public $phone;
    public $createTimeRange;
    public $createTimeStart;
    public $createTimeEnd;

    public function behaviors()
    {
        return [
            [
                'class' => DateRangeBehavior::className(),
                'attribute' => 'date_end',
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
            [['name', 'date_create', 'date_update', 'deals_id', 'date_end', 'phone'], 'safe'],
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
            $query->where(['>','status', 0])->with('deals');
        }else{
            $query = Tasks::find()->where(['user_id' =>  \Yii::$app->user->id])->andWhere(['>','status', 0]);
            //query->where(['>','status', 0]);
        }


        // add conditions that should always apply here
        //$query->joinWith(['deals']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->sort->attributes['deals'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['tbl_deals.phone' => SORT_ASC],
            'desc' => ['tbl_deals.phone' => SORT_DESC],
        ];
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            //'phone' => $this->deals_id,
            'user_id' => $this->user_id,
            //'deals_id' => $this->deals_id,
            'date_update' => $this->date_update,
            'status' => $this->status,
            //'date_end' =>  $this->createTimeEnd,
        ]);
        //$query->andFilterWhere(['like', Deals::tableName() . 'phone', $this->deals_id]);

        // Фильтра по датам

        if(strlen($this->createTimeStart) > 0) {
            $query->andFilterWhere([
                'DATE(date_end) >' =>  date('Y-m-d', $this->createTimeStart),
                'DATE(date_end) <' =>  date('Y-m-d', $this->createTimeEnd),
            ]);
        }


        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'deals_id', $this->deals_id]);


        return $dataProvider;
    }
}
