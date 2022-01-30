<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\bootstrap\Modal;
//use vova07\imperavi\Widget;
//use dtp\DateTimePicker;
use kartik\datetime\DateTimePicker;
//use kartik\widgets\Select2;
use kartik\select2\Select2;
use app\models\Addresses;

/* @var $this yii\web\View */
/* @var $model app\models\Vacancies */

?>
				
		<?php	Modal::begin([ 
				'header' => '<h2>Создать Расписание</h2>',
				'toggleButton' => ['label' => 'Создать график для магазина'],
				'closeButton' => ['id' => 'close-button'], 
				'options' => [
					'id' => 'kartik-modal',
					'tabindex' => false // important for Select2 to work properly
				],
			]); ?>

				<h3>Создать график собеседования для магазина</h3>
				<div id="create_time_table_for_market">
					<div class="block">
						<p>Дата собеседования:</p>
						
						<?php 
							
							echo DateTimePicker::widget([
								'id' => 'timetable_for_market',
								'name' => 'datetime_10',
								'options' => ['placeholder' => 'Ввод даты и времени'],
								'convertFormat' => true,
								'pluginOptions' => [
									'format' => 'dd-MM-yyyy HH:i',
									//'startDate' => '01-Mar-2014 12:00 AM',
									'todayHighlight' => true,
									'autoclose'=>true,
									'weekStart'=>1,
								]
							]);
						?>
					</div>	
					<div class="block">
						<p>Квота</p>
						<input id="timetable_quota_for_market" type="text"/>
					</div>
					
					<div class="block" id="address_block">	
						
						
						<?=  Select2::widget([
							//'model' => $modelAddresses,
							//'attribute' => 'id',
							'data' => ArrayHelper::map(Addresses::find()->where(['is_public'=>1])->all(), 'id','name'),
							'name'=>'address',
							'hideSearch'=> false,
							'id' => 'address',
							//'data' => $data,
							'options' => ['placeholder' => 'Выберете адрес'],
							'pluginOptions' => [
								'allowClear' => true
							],
						]);
						?>
					
						
					</div>
					
					<div class="block">	
						<div id="btn_create" class ="btn btn-primary" onclick="timetable_for_market_create()">Создать</div>						
					</div>	
					
					
					
					<div class="block">	
						<div id="result"></div>
					</div>
				
				</div>

		<?php	Modal::end();?>
															
															
															
															


