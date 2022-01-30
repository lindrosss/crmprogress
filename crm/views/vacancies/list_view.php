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

	<?php Pjax::begin(['id' => 'pjax_1']); ?>
		<?=	   GridView::widget([
									'dataProvider' => $dataProvider,
									'filterModel' => $searchModel,
									'id'=>'grid_list_vacancies',
									'columns' => 
									[
										['class' => 'yii\grid\SerialColumn'],
											'name',  
										[
											'format' => 'html',
											'content' => function ($data) {
															$str = '<a class="btn btn-primary set_vacancy_to_market" onclick="set_vacancy_to_market('.$data->id.')">Назначить</a>';
															return $str; 				
														},
										],
										
										[
											'format' => 'html',
											'content' => function ($data) {
															$str = '<a class="btn btn-warning set_vacancy_to_market" onclick="edit_vacancy('.$data->id.')">Редактировать</a>';
															return $str; 				
														},
										],
										
										[
											'format' => 'html',
											'content' => function ($data) {
															$str = '<a class="btn btn-danger set_vacancy_to_market" onclick="delete_vacancy('.$data->id.')">Удалить</a>';
															return $str; 				
														},
										],
														
									],
							]); ?>
		<?php Pjax::end(); ?>
			
		<!-- <div id="btn_update" class ="btn btn-primary" onclick="vacancy_refresh()">Обновить</div>		-->
			
		<?php	Modal::begin([ 
				'header' => '<h2>Создать вакансию</h2>',
				'toggleButton' => ['label' => 'Создать'],
				'closeButton' => ['id' => 'close-button'], 
				//'id' => 'modal_edit_vacancy',
			]); ?>

				<div id="create_vacancy">
					<div class="block">
						<p>Название вакансии</p>
						<input id="name_vacancy" type="text" />
					</div>	
					<div class="block">
						<p>Информация</p>
						<textarea id="info_vacancy" rows="20" cols="60" name="text"></textarea>
					</div>
					<div class="block">	
						<div id="btn_create" class ="btn btn-primary" onclick="vacancy_create()">Создать</div>						
					</div>	
					<div class="block">	
						<div id="result"></div>
					</div>
				</div>

		<?php	Modal::end();?>
		
		<?php	Modal::begin([ 
				'header' => '<h2>Редактировать вакансию</h2>',
				//'toggleButton' => ['label' => 'Создать'],
				'closeButton' => ['id' => 'close-button'], 
				'id' => 'modal_edit_vacancy',
			]); ?>

				<div id="edit_vacancy">
					<div class="block">
						<p>Название вакансии</p>
						<input id="name_vacancy" type="text" />
					</div>	
					<div class="block">
						<p>Информация</p>
						<textarea id="info_vacancy" rows="20" cols="60" name="text"></textarea>
					</div>
					<div class="block">	
						<div id="btn_edit" class ="btn btn-primary" id_vacancy="-1" onclick="vacancy_update($(this))">Сохранить</div>
					</div>	
					<div class="block">	
						<div id="result"></div>
					</div>
				</div>

		<?php	Modal::end();?>
															
												
															
															


