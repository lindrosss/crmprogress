<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Список листов для загрузки';
$this->params['breadcrumbs'][] = $this->title;

?>

<div>
	<h1><?php echo $this->title; ?></h1>
	
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],			 
			
			[
				'label' => 'Название',				
				 'attribute'=>'name',
			],			
			
			[
				'label' => 'Дата загрузки из файла',				
				 'attribute'=>'date_load_from_file',
			],
			
			[
			'label' => 'Действие',		
			'format' => 'raw',			
			'value' => function($data){
				return Html::a(
					'Редактировать',					
					Url::to(['outboundlists/edit']).'?id='.$data->id,
					[
						'title' => 'Редактировать лист',
						//'target' => '_blank'
					]
				).' '.
				
				Html::a(
					'Залить в базу',					
					Url::to(['outboundlists/loaddata']).'?id='.$data->id,
					[
						'title' => 'Редактировать лист',
						//'target' => '_blank'
					]
				);;
				
			}
			],
        ],
		
    ]); ?>
	
	<?= Html::a('Назад', Url::to(['/']), ['class' => 'btn btn-primary']) ?>
	<?= Html::a('Создать', Url::to(['outboundlists/create']), ['class' => 'btn btn-primary']) ?>
	<?php //echo var_dump($provider);?>
</div>

