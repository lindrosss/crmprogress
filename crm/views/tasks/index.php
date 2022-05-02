<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use app\models\User;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TasksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Задачи';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile(Url::to(['web/css/tasks/view.css?v=1']));
?>
<div class="tasks-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
           // 'id_project',
            'name',
          //  'date_task',
            [
                'label' => 'Дата задачи',
                'format' => 'raw',
                'attribute' => 'date_task',
                'value' => function($data) {
                    if($data->date_task) {
                        if(strtotime(date('Y-m-d H:i:s')) > strtotime($data->date_task)) {
                            return '<span class="red">'.date('d-m-Y', strtotime($data->date_task)).'</span>';
                        }else{
                            return '<span class="">'.date('d-m-Y', strtotime($data->date_task)).'</span>';
                        }
                    }else{
                        return '';
                    }
                }
            ],
            [
                'label' => 'Компания, проект',
                'attribute' => 'companyproject',
            ],
            'comment:ntext',

            [
                'label' => 'Ответственный',
                'format' => 'raw',
                'filter'=>User::getUsersArray(),
                'attribute' => 'responsible_usr',
                'value' => function($data) {
                    //$str = '<select name="TasksSearch[responsible_usr]">';
                   // return User::findByUserid($data->responsible_usr);
                    return User::getUserNameById($data->responsible_usr);
                }
            ],


           // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
