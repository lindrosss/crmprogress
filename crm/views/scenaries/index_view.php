<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Список сценариев';
$this->params['breadcrumbs'][] = $this->title;

?>

<div>
	<h1><?php echo $this->title; ?></h1>
	<?php echo 'asdasdasdasdasd '.$searchModel->id;?>
	
	
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
			[	
				'label' => 'ID',				
				'attribute'=>'id',
				'filterOptions' => ['style' => 'width: 100px']
			], 
			
			[
				'label' => 'Название',				
				 'attribute'=>'title',
			],
			
			
			[
				'label' => 'Кампания',				
				 'attribute'=>'campaignName',
				 //'value' => function ($data) { return $data->campaign->name; },
			],
			
			//'campaignName',
			
			[
				'label' => 'Статус',				
				 'attribute'=>'is_public',
				 'filter'=>array("1"=>"Опубликовано","0"=>"Не опубликовано"),
				 'value' => function ($data) { return $data->is_public === 1 ? 'Опубликовано' : 'Не опубликовано'; },
				 'filterOptions' => ['style' => 'width: 200px']
			],
            //'is_public:ntext',
            //'image:ntext',
            // 'created_at',
            // 'updated_at',
            //['class' => 'yii\grid\ActionColumn'],
			[
			'label' => 'Действие',
			'format' => 'raw',
			'value' => function($data){
				return Html::a(
					'Редактировать',
					//$data->url,
					//'edit?id='.$data->id,
					Url::to(['scenaries/edit']).'?id='.$data->id,
					[
						'title' => 'Редактировать сценарий',
						//'target' => '_blank'
					]
				);
			}
			],
        ],
		
    ]); ?>
	
	<?= Html::a('Назад', Url::to(['/']), ['class' => 'btn btn-primary']) ?>
	<?= Html::a('Создать', Url::to(['scenaries/create']), ['class' => 'btn btn-primary']) ?>
	<?php //echo var_dump($provider);?>
</div>

