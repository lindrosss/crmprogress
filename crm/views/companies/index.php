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
                'value' => function($data) use ($max_id_hsl) {
                    $str ='';
                    $str .= Html::a($data->name,
                        Url::to(['update', 'id'=>$data->id],[]),
                        [
                            'title' => 'Редактировать контакт',
                            'aria-label' => 'Редактировать контакт',
							'target' => 'blanck',
                            'data-method' => 'post',
                        ]
                    ).'&nbsp&nbsp';
					
					return $str;
				}
			],	
          //  'name',
            'inn',
            'kpp',
            'address:ntext',
            //'comment:ntext',
            //'date_create',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
