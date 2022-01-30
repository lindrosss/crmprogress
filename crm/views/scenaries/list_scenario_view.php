<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Список сценариев';
$this->params['breadcrumbs'][] = $this->title;

?>

<div>
	<h1><?php echo $this->title; ?></h1>
	
	<?= GridView::widget([
        'dataProvider' => $provider,
		'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
			[
				'label' => 'Название',
				//'title:ntext',
				 'attribute'=>'title',
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
					'edit?id='.$data->id,
					[
						'title' => 'Редактировать сценарий',
						'target' => '_blank'
					]
				);
			}
			],
        ],
		
    ]); ?>
	
	<?php //echo var_dump($provider);?>
</div>

