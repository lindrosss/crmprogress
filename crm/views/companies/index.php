<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CompaniesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Компании';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="companies-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать компанию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],

            //'id',
			[
                'label' => 'Название',
                'format' => 'raw',
				'attribute' => 'name',
                'value' => function($data) {
                    $str ='';
                    $str .= Html::a($data->name,
                        Url::to(['update', 'id'=>$data->id],[]),
                        [
                            'title' => 'Редактировать компанию',
                            'aria-label' => 'Редактировать компанию',
							'target' => '_blank',
                            'data-method' => 'post',
                        ]
                    ).'&nbsp&nbsp';
					
					return $str;
				}
			],

            /*
            [
                'label' => 'Название',
                'format' => 'raw',
                'attribute' => 'name',
                'value' => function($data) {
                    $str ='';
                    $str .= Html::a($data->name.' new',
                            Url::to(['viewcompany', 'id'=>$data->id],[]),
                            [
                                'title' => 'Открыть компанию',
                                'aria-label' => 'Открыть компанию',
                                'target' => 'blanck',
                                'data-method' => 'post',
                            ]
                        ).'&nbsp&nbsp';

                    return $str;
                }
            ],*/
            //  'name',
            'inn',
            'kpp',
            'address:ntext',
            [
                'label' => 'Контакты',
                'attribute' => 'contactsname',
            ],
            //'comment:ntext',
            //'date_create',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
