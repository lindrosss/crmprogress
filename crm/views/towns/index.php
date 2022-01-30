<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TownsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Города');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="towns-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Создать город'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			['label' =>'Название', 'attribute'=> 'name'],
			['label' =>'Регион', 'attribute'=> 'regionName', 'filterOptions' => ['style' => 'width: 450px']],
			[
			'label' => 'Действие',
			'format' => 'raw',
			'value' => function($data){
				return Html::a(
					'Редактировать',
					//$data->url,
					//'edit?id='.$data->id,
					Url::to(['towns/update']).'?id='.$data->id,
					[
						'title' => 'Редактировать город',
						//'target' => '_blank'
					]
				);
			}
			],
			/*
            'id',
            'name',
            'id_region',
            'id_updator',
            'date_update',
			*/
          
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
