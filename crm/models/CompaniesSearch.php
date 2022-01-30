<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Companies;

/**
 * CompaniesSearch represents the model behind the search form of `app\models\Companies`.
 */
class CompaniesSearch extends Companies
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'inn', 'kpp', 'address', 'comment',  'date_create'], 'safe'],
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
        $query = Companies::find()
        ->leftJoin('contacts', 'contacts.id_company =  companies.id')
        ->groupBy(['inn']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]
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
        ]);

        $query
            ->andFilterWhere(
                        [   'OR',
                            ['like', 'CONCAT_WS(\' \', contacts.fio, contacts.phones, contacts.emails, post)', $this->name],
                            ['like', 'name', $this->name]
                         ]
                    )
            ->andFilterWhere(['like', 'inn', $this->inn])
            ->andFilterWhere(['like', 'kpp', $this->kpp])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
