<?php

namespace frontend\models;

use app\models\Tags;
use common\models\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Deals;
use kartik\daterange\DateRangeBehavior;

/**
 * SearchDeals represents the model behind the search form of `app\models\Deals`.
 */
class SearchDeals extends Deals
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
            [['id', 'id_operator', 'id_filial', 'id_comment', 'deal_sum'], 'integer'],
            [['name', 'phone', 'tag', 'status'], 'safe'],
            [['date_create'], 'match', 'pattern' => '/^.+\s\-\s.+$/'],
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
        //$query = Deals::find()->where(['id_operator' =>  \Yii::$app->user->id]); - для конкретного пользователя
        if(\Yii::$app->authManager->getRolesByUser(\Yii::$app->getUser()->identity->getId())['superadmin']->name == 'superadmin' || \Yii::$app->authManager->getRolesByUser(\Yii::$app->getUser()->identity->getId())['admin']->name == 'admin'){
            $query = Deals::find();
            $query->andWhere(['del' => 0]);
            $query->orderBy('date_create DESC');
        }else{
            $query = Deals::find()->where(['id_operator' =>  \Yii::$app->user->id]);
            $query->andWhere(['del' => 0]);
            $query->orderBy('date_create DESC');
        }
        $query->with(['us', 'branch']);
        $query->with('tegi');
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            $query->where('id_operator' == '1');
            return $dataProvider;
        }


        // Фильтра по датам
        if(strlen($this->createTimeStart) > 0) {
            $query->andFilterWhere([
                'DATE(date_create) >' =>  date('Y-m-d', $this->createTimeStart),
                'DATE(date_create) <' =>  date('Y-m-d', $this->createTimeEnd),
            ]);
        }

        // фильтр по ответственным
        if($this->id_operator > 0) {
            $query->andFilterWhere([
                'id_operator' => $this->id_operator,
            ]);
        }
            // фильтр по названию
        if($this->name > 0) {
            $query->andFilterWhere([
                'name' => $this->name,
            ]);
        }
        

        // фильтр по городам
        if($this->id_filial > 0) {
            $query->andFilterWhere([
                'id_filial' => $this->id_filial,
            ]);
        }
        // фильтра по Тегам
        if($this->tag > 0) {
            $query->andFilterWhere([
                'tag' => $this->tag,
            ]);
        }
        // фильтра по Статусу
        if($this->status > 0) {
            $query->andFilterWhere([
                'status' => $this->status,
            ]);
        }

        // фильтра по сумме
        if($this->deal_sum > 0) {
            $query->andFilterWhere([
                'deal_sum' => $this->deal_sum,
            ]);
        }

        // фильтра по названию
        if(strlen($this->name) > 1) {
            $query->andFilterWhere(['like', 'name', $this->name]);
        }
        // фильтра по телефону
        if(strlen($this->phone) > 1) {
            $query->andFilterWhere(['like', 'phone', $this->phone]);
        }

        // фильтра по сумме
        if(strlen($this->deal_sum) > 1) {
            $query->andFilterWhere(['like', 'deal_sum', $this->deal_sum]);
        }


        return $dataProvider;
    }
}
