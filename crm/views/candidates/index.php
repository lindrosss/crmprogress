<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CandidatesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Список кандидатов на собеседования');
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js');
$this->registerJsFile(Url::to(['web/js/candidates.js?v=3']));
$this->registerJsFile(Url::to(['web/js/vakancy_operator.js?v=16']));
?>
<div class="candidates-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php 
		
		if($hide_menu == 1){ ?>
			<script>				
				window.onload = function() {
					$('nav, ul.breadcrumb').css('display', 'none'); 
					$('div.container').css('padding-top', '0'); 
					$('div.container').css('margin-left', '5px'); 
					
					//alert('sdsdsd');
				};
			</script>	
	<?php }
	?>

    
	
	<?php Pjax::begin(['id' => 'pjax_3']); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            ['label' =>'ФИО', 'attribute'=> 'fio', 'filterOptions' => ['style' => 'width: 350px']], 
			['label' =>'Телефон', 'attribute'=> 'phone', 'filterOptions' => ['style' => 'width: 350px']], 
			['label' =>'Возраст', 'attribute'=> 'age', 'filterOptions' => ['style' => 'width: 50px']], 
			['label' =>'Дата собеседования', 'attribute'=> 'timetableDate', 'filterOptions' => ['style' => 'width: 250px']], 
			['label' =>'Адрес собеседования', 'attribute'=> 'timetableAddress', 'filterOptions' => ['style' => 'width: 350px']], 
			['label' =>'Источник информации', 'attribute'=> 'sourceName', 'filterOptions' => ['style' => 'width: 350px']],
			['label' =>'Комментарий', 'attribute'=> 'comment', 'filterOptions' => ['style' => 'width: 150px']],
			['label' =>'Вакансия', 'attribute'=> 'VacancyMarketNameVacancy', 'filterOptions' => ['style' => 'width: 350px']], 
			['label' =>'Магазин', 'attribute'=> 'VacancyMarketNameMarket', 'filterOptions' => ['style' => 'width: 350px']],
			[
				'label' => 'Статус',				
				 'attribute'=>'status',
				 'filter'=>array("1"=>"Записан","2"=>"Записан в резерв", "3"=>"Отменена запись"),
				 'value' => function ($data) { 
								if($data->status == 1){
									$return	= 'Записан';
								}elseif($data->status == 2){
									$return	= 'Записан в резерв';
								}elseif($data->status == 3){
									$return	= 'Отменена запись';
								}else{
									$return	= $data->status;
								}
								
								return $return;
							},
				 'filterOptions' => ['style' => 'width: 200px']
			],
			
            [
				'format' => 'html',
				'content' => function ($data) {
								if($data->status != 3){
									$str = '<a id_candidate="'.$data->id.'" class="btn btn-primary" onclick="reset_candidate('.$data->id.')">Отменить запись</a>';
								}else{
									$str = '<span>Кандидат отказался</span>';
								}
								return $str; 				
							},
			],

            [
                'format' => 'html',
                'content' => function ($data) {
                    if($data->status != 3){
                        $str = '<a id_candidate="'.$data->id.'" class="btn btn-primary" href="'.Url::to(['/vacanciesoperator/']).'?id_candidat='.$data->id.'" onclick="recreate_candidate('.$data->id.')">Перезапись</a>';
                    }else{
                        $str = '<span></span>';
                    }
                    return $str;
                },
            ],
            
            //'id_timetable',
			//'timetableDate',
			//'timetableAddress',
            //'status',
            //'creator',
            //'id_updator',
            //'date_create',
            //'date_update',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
	
	<?php Pjax::end(); ?>

    <a id="load_report" class="btn btn-primary" >Загрузить отчет по кандидатам</a>

</div>
