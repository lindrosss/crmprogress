<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\RegionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Регионы');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="regions-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Создать регион'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            
            
            
			['label' =>'Название региона', 'attribute'=> 'name', 'filterOptions' => ['style' => 'width: 650px']],
			
			[
			'label' => 'Действие',
			'format' => 'raw',
			'value' => function($data){
				return Html::a(
					'Редактировать',
					//$data->url,
					//'edit?id='.$data->id,
					Url::to(['regions/update']).'?id='.$data->id,
					[
						'title' => 'Редактировать регион',
						//'target' => '_blank'
					]
				);
			}
			],
            
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
