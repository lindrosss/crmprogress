<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Timetables;

/**
 * TimetablesSearch represents the model behind the search form of `app\models\Timetables`.
 */
class TimetablesSearch extends Timetables
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_vacancy', 'quota', 'id_updator'], 'integer'],
            [['date_interview', 'date_update'], 'safe'],
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
        $query = Timetables::find();

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
            'id_vacancy' => $this->id_vacancy,
            'date_interview' => $this->date_interview,
            'quota' => $this->quota,
            'id_updator' => $this->id_updator,
            'date_update' => $this->date_update,
        ]);

        return $dataProvider;
    }
}
