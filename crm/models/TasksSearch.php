<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tasks;

/**
 * TasksSearch represents the model behind the search form of `app\models\Tasks`.
 */
class TasksSearch extends Tasks
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_project','responsible_usr'], 'integer'],
            //[['id', 'id_project','companies.responsible_usr'], 'integer'],
            [['id', 'id_project'], 'integer'],
            [['name', 'date_task', 'comment', 'date_create'], 'safe'],
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
    public function search($params, $user_id = null)
    {
        $query = Tasks::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['date_task'=>SORT_ASC]]
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
            'id_project' => $this->id_project,
            'DATE_FORMAT(date_task,"%Y-%m-%d")' => $this->date_task,
            'date_create' => $this->date_create,
            //'companies.responsible_usr' => $user_id,
           // 'responsibleusr' => $user_id,
        ]);

      /*  $query->andFilterWhere([

            ]);*/

        $query->andFilterWhere(['like', 'tasks.name', $this->name])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        $query->leftJoin('projects', 'projects.id = tasks.id_project');
        $query->leftJoin('companies', 'companies.id = projects.id_company');

        if($user_id){
            $query->andFilterWhere(['companies.responsible_usr' => $user_id]);
        }else{
            $query->andFilterWhere(['companies.responsible_usr' => $this->responsible_usr]);
        }

        return $dataProvider;
    }
}
