<?php

/* @var $this yii\web\View */

$this->title = 'Отчеты FreshMarket';

//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Инструменты'), 'url' => ['/tools']];
$this->params['breadcrumbs'][] = $this->title;

use yii\helpers\Url;
use kartik\date\DatePicker;

$this->registerJsFile('//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js');
$this->registerJsFile(Url::to(['web/js/reports.js?v=4']));

?>
<div class="site-index">

	
    <div class="jumbotron">
        <h1>Отчеты FreshMarket</h1>
        
    </div>

    <div class="body-content">
		<?php
				if(Yii::$app->user->isGuest){
                    echo '<p class="lead">Для формирования отчетов необходимо <a href="'.Url::to(['/site/login']).'">авторизоваться</a></p>';
				}else{ ?>
				<div class="row">
			
					<?php if(Yii::$app->user->identity->role == 2){?>
						<div class="col-lg-4">
							<h2>Графики собеседований</h2>
							<p>Актуальные графики собеседований</p>
                            <div id="btn_dwld_actual_time_tables" class="btn btn-lg btn-success">Выгрузить</div>
                            <div id="status"></div>
                            <div id="result"></div>
						</div>
						

					
			
				</div>

                <br/><br/>

                <div class="row">

                        <?php if(Yii::$app->user->identity->role == 2){?>
                            <div class="col-lg-4">
                                <h2>Графики собеседований за период</h2>
                                <p>Все графики собеседований за выбранный период</p>

                                <div class="block">

                                    <?php
                                    echo '<label>Начальная дата:</label>';
                                    echo DatePicker::widget([
                                        'name' => 'check_issue_date',
                                        'id' => 'start_date',
                                        'value' => date('d-m-Y'),
                                        'options' => ['placeholder' => 'Начало периода...'],
                                        'pluginOptions' => [
                                            'format' => 'dd-mm-yyyy',
                                            'language' => 'ru',
                                            'todayHighlight' => true
                                        ]
                                    ]);
                                    ?>
                                </div>

                                <div class="block">

                                    <?php
                                    echo '<label>Конечная дата:</label>';
                                    echo DatePicker::widget([
                                        'name' => 'check_issue_date',
                                        'id' => 'end_date',
                                        'value' => date('d-m-Y'),
                                        'options' => ['placeholder' => 'Конец периода...'],
                                        'pluginOptions' => [
                                            'format' => 'dd-mm-yyyy',
                                            'language' => 'ru',
                                            'todayHighlight' => true
                                        ]
                                    ]);
                                    ?>
                                </div>
                                <br/>

                                <div id="btn_dwld_actual_time_tables_range" class="btn btn-lg btn-success">Выгрузить</div>
                                <div id="status_range"></div>
                                <div id="result_range"></div>
                            </div>


                        <?php } ?>

                </div>


		
		<?php }elseif(Yii::$app->user->identity->role == 5){ ?>

			
		<?php }elseif(Yii::$app->user->identity->role == 6){ ?>

				
		<?php }

		
	}	
		?>

    </div>
</div>
<?php //echo var_dump($get);?>