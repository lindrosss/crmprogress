<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

use app\models\Regions;
use app\models\Markets;

use yii\bootstrap\Modal;
use yii\bootstrap\Collapse;

use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VacanciesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = Yii::t('app', 'Вакансии в магазинах');
$this->params['breadcrumbs'][] = $this->title;


$this->registerJsFile('//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js');
$this->registerJsFile(Url::to(['web/js/vakancy_in_market.js?v=72']));

$this->registerCssFile(Url::to(['web/css/vakancy_in_market.css?v=5']));
?>
<div class="vacancies-index">

    <h1><?= Html::encode($this->title) ?></h1>
   
   <?php /*
    $this->registerJs(
        '$("document").ready(function(){
            $("#set_market").on("pjax:end", function() {
            $.pjax.reload({container:"#vacancies"});  //Reload GridView
        });
    });'
    );*/
?>
   <?php //Pjax::begin(); ?>
	<?php	
		//$form = ActiveForm::begin([
		//'id' => 'vacancy',
		//'options' => ['class' => 'form-horizontal'],
		
		//'action' => 'update',
		//]) 
	?> 
	<div class="row">
		<div class="form-group">
				
				<br/>
					<div class="label_select"> 
						Регион:
					</div>
				<?php 
					//echo //$form->field($modelRegions, 'id')-> dropDownList(ArrayHelper::map(Regions::find()->all(), 'id','name' ),
					/*
					Html::dropDownList('cat', 'null', ArrayHelper::map(Regions::find()->all(), 'id','name' ),
						array(
							'class' => 'form-control',
							'prompt' => 'Выберите регион',
							'label' => 'Регион',
							'id' => 'asdasds',
							
							 'onchange' => '
							  $.post(
							   "'.Url::to(['/vacancies/gettownsbyregionid']).'",
							   {id_region : $(this).val()},
							   function(data){
								   //alert(data);
								   $("#towns-id").empty();
								   $("#markets-id").empty();								   
								   $("#towns-id").append( $(data));
								   clearOptions();
							   }
							)',				
						   
						)
					);//->label('Регион');*/
					
					?>
					
					<div class="block" id="region_block">



						<?php echo  Select2::widget([							
							'data' => ArrayHelper::map(Regions::find()->where('id != -1')->all(), 'id','name'),
							'name'=>'region',
							'hideSearch'=> false,
							'id' => 'address22',
							//'data' => $data,
							'options' => ['placeholder' => 'Выберете регион', 'onChange' => '$.post(
							   "'.Url::to(['/vacancies/gettownsbyregionid']).'",
							   {id_region : $(this).val()},
							   function(data){
								   //alert(data);
								   $("#towns-id").empty();
								   $("#markets-id").empty();								   
								   $("#towns-id").append( $(data));
								   clearOptions();
							   }
							)',],
							'pluginOptions' => [
								'allowClear' => true
							],
							
							  
						]);
						?>
					</div>
					
					
					<br/>
					<div class="label_select"> 
						Город:
					</div>
					
					<?php 
					//echo //$form->field($modelTowns, 'id')-> dropDownList(array(),
					/*Html::dropDownList('towns', 'null', Array(),
						array(
							'class' => 'form-control',
							//'prompt' => 'Выберите регион',
							'id'=>'towns-id',
							 'onchange' => '
							  $.post(
							   "'.Url::to(['/vacancies/getmarketsbytownsid']).'",
							   {id_town : $(this).val()},
							   function(data){
								   //alert(data);
								   $("#markets-id").empty();								   
								   $("#markets-id").append( $(data));
								   clearOptions();
							   }
							)',				
						   
						)
					);//->label('Город');*/
					?>
					
					<div class="block" id="town_block">
						<?php echo  Select2::widget([							
							//'data' => ArrayHelper::map(Regions::find()->where('id != -1')->all(), 'id','name'),
							'name'=>'town',
							'hideSearch'=> false,
							'id' => 'towns-id',
							//'data' => $data,
							'options' => ['placeholder' => 'Выберете город', 'onChange' => ' $.post(
							   "'.Url::to(['/vacancies/getmarketsbytownsid']).'",
							   {id_town : $(this).val()},
							   function(data){
								   //alert(data);
								   $("#markets-id").empty();								   
								   $("#markets-id").append( $(data));
								   clearOptions();
							   }
							)',],
							'pluginOptions' => [
								'allowClear' => true
							],
							
							  
						]);
						?>
					</div>
					
					<br/>
					<div class="label_select"> 
						Магазин:
					</div>
				<?php 	/*
						echo  //$form->field($modelMarkets, 'id')-> dropDownList(array(),
						Html::dropDownList('markets', 'null', Array(),
						array(
							'class' => 'form-control',
							//'prompt' => 'Выберите магазин',
							'id'=>'markets-id',
							 'onchange' => '
							  $.post(
							   "'.Url::to(['/vacancies/getvakanciesbymarketsid']).'",
							   {id_market : $(this).val()},
							   function(data){
								   //alert(data);
								   clearOptions();
									$("#vacancies_list").html(data);
									$("#all_vacansieslist").fadeIn();
									$("#all_sourceslist").fadeIn();									
									
									$("#vacancies_list_in_market td.clickable").bind("click", function() {
											clickOnVacancy($(this).attr("id_row"));											
										});	
							   }
							)',				
						   
						)
					);//->label('Магазин');*/
					
				?>
				<div class="block" id="markets_block">
						<?php echo  Select2::widget([							
							'data' => ArrayHelper::map(Markets::find()->select(['id', 'name' => 'CONCAT_WS(\' \', num_market, name)'])->where('id != -1')->all(), 'id','name'),
							'name'=>'market',
							'hideSearch'=> false,
							'id' => 'markets-id',
							//'data' => $data,
							'options' => ['placeholder' => 'Выберете маркет', 'onChange' => '$.post(
							   "'.Url::to(['/vacancies/getvakanciesbymarketsid']).'",
							   {id_market : $(this).val()},
							   function(data){
								   //alert(data);
								   clearOptions();
									$("#vacancies_list").html(data);
									$("#all_vacansieslist").fadeIn();
									$("#all_sourceslist").fadeIn();									
									
									$("#vacancies_list_in_market td.clickable").bind("click", function() {
											clickOnVacancy($(this).attr("id_row"));											
										});
									
									set_rm();
								}
								
							)',],
							'pluginOptions' => [
								'allowClear' => true
							],
							
							  
						]);
						?>
					</div>
					
					
					
		</div>
		
		<label class="control-label">Список вакансий для магазина:</label>		
		<div id="vacancies_list" class="form-group">
			<span class="gray">Необходимо выбрать <u>Магазин</u></span>
		</div>
		
		
		
		<div id="all_vacansieslist">
			<?php //Pjax::begin(); ?>
			<?php echo Collapse::widget([ 
									'items' => [
										[
										'label' => 'Добавить вакансию в магазин',
										'content' => \Yii::$app->view->renderFile('@app/views/vacancies/list_view.php', ['dataProvider'=> $dataProvider, 'searchModel' => $searchModel]),
											'contentOptions' => [],
											'options' => []		
										]
									]
										]);
			?>	
			<?php //Pjax::end(); ?>
		</div>
										
		<hr>							
		
		</br></br>
		
		<div style="display: none;">
			<label class="control-label">График собеседований для магазина:</label>
			<div id="timetables_market" class="form-group"><span class="gray">Необходимо выбрать <u>Магазин</u></span></div>
			<?php echo \Yii::$app->view->renderFile('@app/views/vacancies/create_timetable_for_market.php',['modelAddresses'=>$modelAddresses ]);?>	
			<hr>
			</br></br>
		</div>
		
		<label class="control-label">График собеседований для вакансии:</label>
		<div id="timetables_vacancy" class="form-group"><span class="gray">Необходимо выбрать <u>Вакансию</u></span></div>
		<?php echo \Yii::$app->view->renderFile('@app/views/vacancies/create_timetable_for_vakancy.php',array());?>	
		<hr>
		</br></br>
		
		<label class="control-label">Источники информации для магазина:</label>
		<div id="sources_market" class="form-group"><span class="gray">Необходимо выбрать <u>Магазин</u></span></div>
		<div id="all_sourceslist">	

			<?php echo Collapse::widget([  		
									'items' => [
										[
										'label' => 'Добавить источник в магазин',
										'content' => \Yii::$app->view->renderFile('@app/views/vacancies/list_sources.php', ['dataProviderSources'=> $dataProviderSources, 'searchModelSources' => $searchModelSources]),
											'contentOptions' => [],
											'options' => []		
										]
									]
										]);
			?>	
			<hr>
		</div>

        <div id="rm">
            <label class="control-label">Региональный менеджер:</label>
            <p id="rm_value"></p>
        </div>
		
		

	</div>

    <div style="display: none">
        <div id="load_vakansyes" class ="btn btn-primary" onclick="load_vakansyes()">Загрузить вакансии</div>
        <div id="rez_load_vakansyes"></div>
    </div>
	
</div>

