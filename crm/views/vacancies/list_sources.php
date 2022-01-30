<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Vacancies */

?>

	<?php Pjax::begin(['id' => 'pjax_2']); ?>
		<?=	   GridView::widget([
									'dataProvider' => $dataProviderSources,
									'filterModel' => $searchModelSources,
									'id'=>'grid_list_sources',
									'columns' => 
									[
										['class' => 'yii\grid\SerialColumn'],
											'name',  
										[
											'format' => 'html',
											'content' => function ($data) {
															$str = '<a id_source="'.$data->id.'" class="btn btn-primary set_source_to_market" onclick="set_source_to_market('.$data->id.')">Назначить</a>';
															return $str; 				
														},
										],
										
										[
											'format' => 'html',
											'content' => function ($data) {
															$str = '<a class="btn btn-danger" onclick="delete_source('.$data->id.')">Удалить</a>';
															return $str; 				
														},
										],
														
									],
							]); ?>
		<?php Pjax::end(); ?>
			
		<!-- <div id="btn_update" class ="btn btn-primary" onclick="vacancy_refresh()">Обновить</div>		-->
			
		<?php	Modal::begin([ 
				'header' => '<h2>Создать источник</h2>',
				'toggleButton' => ['label' => 'Создать'],
				'closeButton' => ['id' => 'close-button'], 
			]); ?>

				<div id="create_source">
						
					<div class="block">
						<p>Источник</p>
						<textarea id="name_source" rows="20" cols="60" name="text"></textarea>
					</div>
					<div class="block">	
						<div id="btn_create" class ="btn btn-primary" onclick="source_create()">Создать</div>						
					</div>	
					<div class="block">	
						<div id="result"></div>
					</div>
				</div>

		<?php	Modal::end();?>
															
															
															
															


