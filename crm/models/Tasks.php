<?php

namespace app\models;

use Yii;
use app\models\Companies;
use app\models\Projects;
use app\models\User;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property int $id_project
 * @property string $name
 * @property string $date_task
 * @property string $comment
 * @property string $date_create
 * @property int $responsible_usr
 */
class Tasks extends \yii\db\ActiveRecord
{
    public $responsible_usr;

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

    public function afterFind() {
        $this->responsible_usr = $this->getResponsibleusr();
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
        if(isset($project->company)) {
            $company = $project->company;
            return $company->name . ', ' . $project->name;
        }else{
            return '';
        }
    }

    public function getCompanyid() {
        $project = $this->project;
        if(isset($project->company)) {
            $company = $project->company;
            return $company->id;
        }else{
            return '';
        }


    }

    public function getResponsibleusr() {
        $project = $this->project;

        if(isset($project->company)) {
            $company = $project->company;
            //$id_responsible_usr = $company->responsible_usr;
            if ($company){
                $user = User::findByUserid($company->responsible_usr);
                if (isset($user->id)) {
                    return $user->id;
                } else {
                    //return 'Не указан '.$company->name;
                    return $company->responsible_usr;
                }
            }else{return 2;}
        }else{
            return 'Не указан';
        }

        return 0;

    }
}
