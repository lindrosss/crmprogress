<?php

namespace app\models;

use Yii;
use app\models\Companies;
use app\models\Projects;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property int $id_project
 * @property string $name
 * @property string $date_task
 * @property string $comment
 * @property string $date_create
 */
class Tasks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_project', 'name'], 'required'],
            [['id_project'], 'integer'],
            [['name', 'date_task', 'date_create'], 'safe'],
            [['comment'], 'string'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_project' => 'Id Project',
            'name' => 'Текст',
            'date_task' => 'Дата задачи',
            'comment' => 'Комментарий',
            'date_create' => 'Date Create',
        ];
    }

    public function getProject()
    {
        return $this->hasOne(Projects::className(), ['id' => 'id_project']);
    }

    /* Геттер для названия адреса */
    public function getProjectName() {
        return $this->company->name;
    }

    public function getCompanyproject() {
        $project = $this->project;
        $company = $project->company;
       // return $project->name;

        return $company->name.', '.$project->name;
    }
}
