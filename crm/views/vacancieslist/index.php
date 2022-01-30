<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VacanciesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список вакансий';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vacancies-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать вакансию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'info:ntext',
            'employment',
          //  'is_zum',
            //'id_timetable:datetime',
            //'id_address',
            //'is_public',
            //'id_updator',
            //'date_update',
            //'date_upload',

          //  ['class' => 'yii\grid\ActionColumn'],
            [
                'label' => 'Опубликована',
                'format' => 'raw',
                'value' => function($data)  {
                    if($data->is_public ==1){
                        return 'Да';
                    }else{
                        return 'Нет';
                    }

                }
            ],

            [
                'label' => 'Действия',
                'format' => 'raw',
                'value' => function($data)  {
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                        Url::to(['vacancieslist/update', 'id' => $data->id],
                            [
                                'title' => 'Изменить вакансию',
                            ])
                    );
                }
            ]
        ],
    ]); ?>
</div>
