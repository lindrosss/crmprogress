<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

use app\models\Regions;

use yii\bootstrap\Modal;
use yii\bootstrap\Collapse;

use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VacanciesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = Yii::t('app', 'Запись на собеседование');
$this->params['breadcrumbs'][] = $this->title;


$this->registerJsFile('//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js');
$this->registerJsFile(Url::to(['web/js/vakancy_operator.js?v=67']));

$this->registerCssFile(Url::to(['web/css/vakancy_in_market.css?v=7']));

if(!isset(Yii::$app->user->identity->role) ){
    $this->registerJs(
        "$('nav#w0, ul.breadcrumb').css('display', 'none'); 
		 $('div.container').css('padding-top', '0'); 
		 $('div.container').css('margin-left', '5px');"
    );
}
?>
<div class="vacancies-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    if( $candidat_info['isset'] == 1){
        // var_dump($candidat_info['market']);
    }
    ?>

    <div class="row">
        <div id="info_candidat">

            <div class="block">
                <p><b>ФИО кандидата</b></p>
                <input id="info_fio_candidat" value="<?php echo $fio;?>" type="text" />
            </div>
            <br/><br/>

            <div class="block">
                <p><b>Телефон кандидата</b></p>
                <input id="info_phone_candidat" value="<?php echo $phone;?>" type="text" />
            </div>
            <br/><br/>


            <div class="block">
                <p><b>Из какого города Вы звоните?</b></p>
                <input id="info_city_candidat" type="text" />
            </div>
            <br/><br/>



            <div class="block">
                <p><b>Где Вы в первый раз увидели нашу рекламу?</b></p>
                <p>Если от сотрудника, то "Уточните, пожалуйста ФИО рекомендовавшего"</p>
                <label class="control-label">Источники информации:</label>
                <?php
                $selected_source = 0;
                if( $candidat_info['isset'] == 1){
                    $selected_source = $candidat_info['vacancy_source']->id_source;
                }else{
                    $selected_source = $source_info_id;
                }
                ?>
                <div id="sources_market" class="form-group" selected_source="<?php echo $selected_source;?>">
                    <span class="gray">Необходимо выбрать <u>Магазин</u></span>
                </div>
            </div>



            <input id="info_sid" value="<?php echo $sid;?>" type="hidden" />
        </div>
    </div>

    <div class="row">
        <div class="form-group">
            <label class="control-label">Какая вакансия Вас интересует?</label>
            <p><input id="" value="" type="text" /></p>
            <p>Уточните, пожалуйста, какой магазин Вас интересует? Выбираем магазин из списка. Если соискатель затрудняется, помогаем с выбором ближайшего магазина.</p>

            <br/>
            <div class="label_select">
                Регион:
            </div>
            <?php
            /*
            echo Html::dropDownList('cat', $candidat_info['region'], ArrayHelper::map(Regions::find()->all(), 'id','name' ),
                array(
                    'class' => 'form-control',
                    'prompt' => 'Выберите регион',
                    'label' => 'Регион',
                    'id' => 'region',

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
            );//->label('Регион');
            */

            echo  Select2::widget([
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

            <br/>
            <div class="label_select">
                Город:
            </div>

            <?php
            /*
            echo //$form->field($modelTowns, 'id')-> dropDownList(array(),
            Html::dropDownList('towns', $candidat_info['town'], ArrayHelper::map($candidat_info['towns_list'], 'id','name' ),
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
            );//->label('Город');

            */

            echo  Select2::widget([
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

            <br/>
            <div class="label_select">
                Магазин:
            </div>
            <?php
            /*
            echo  //$form->field($modelMarkets, 'id')-> dropDownList(array(),
                Html::dropDownList('markets', $candidat_info['market'], ArrayHelper::map($candidat_info['markets_list'], 'id','name' ),
                array(
                    'class' => 'form-control',
                    //'prompt' => 'Выберите магазин',
                    'id'=>'markets-id',
                     'onchange' => '
                      $.post(
                       "'.Url::to(['/vacanciesoperator/getvakanciesbymarketsid']).'",
                       {id_market : $(this).val()},
                       function(data){
                           //alert(data);
                           clearOptions();
                            $("#vacancies_list").html(data);
                            $("#all_vacansieslist").fadeIn();
                            $("#all_sourceslist").fadeIn();

                            //$("#vacancies_list_in_market td.clickable").click(function() {
                            $("#vacancies_list_in_market td.clickable").bind("click", function() {
                                    clickOnVacancy($(this).attr("id_row"));
                                });
                       }
                    )',

                )
            );//->label('Магазин');

            */

            echo  Select2::widget([
                'data' => ArrayHelper::map(Regions::find()->where('id != -1')->all(), 'id','name'),
                'name'=>'market',
                'hideSearch'=> false,
                'id' => 'markets-id',
                //'data' => $data,
                'options' => ['placeholder' => 'Выберете маркет', 'onChange' => '$.post(
							   "'.Url::to(['/vacanciesoperator/getvakanciesbymarketsid']).'",
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
							)',],
                'pluginOptions' => [
                    'allowClear' => true
                ],


            ]);

            ?>
            <?php //ActiveForm::end();   //yii\widgets\Pjax::end(); ?>
        </div>

        <label class="control-label">Список вакансий для магазина:</label>
        <div id="vacancies_list" class="form-group">
            <?php
            if( $candidat_info['isset'] == 1){
                echo $candidat_info['vacancyes_list'];

                $js = '
                        $("#vacancies_list_in_market td.clickable").bind("click", function() {
                            clickOnVacancy($(this).attr("id_row"));
                        });

                        clickOnVacancy('.$candidat_info['vacancy_market']->id.');
                        ';

                $this->registerJs($js);
            }else{
                ?>
                <span class="gray">Необходимо выбрать <u>Магазин</u></span>
            <?php } ?>
        </div>



        <div id="all_vacansieslist">

        </div>
        </br></br>

        <div style="display: none;">
            <label class="control-label">График собеседований для магазина:</label>

            <div id="timetables_market" class="form-group"><span class="gray">Необходимо выбрать <u>Магазин</u></span></div>
            </br></br>
        </div>

        <label class="control-label">График собеседований для вакансии:</label>
        <div id="timetables_vacancy" class="form-group"><span class="gray">Необходимо выбрать <u>Вакансию</u></span></div>
        </br></br>

        <div class="block">
            <p>Гражданство</p>
            <input id="info_nation_candidat" value="<?php echo $nation;?>" type="text" />
            <p><b>Если РФ, то идем дальше. Иначе берем контакты:</b> Спасибо Вам за проявленный интерес к нашей Компании. Мы сохраним Ваши контакты. И, в СЛУЧАЕ ЗАИНТЕРЕСОВАННОСТИ, сотрудники отдела кадров свяжутся с Вами. Заполняем отказ!</p>
            <p><b>Если есть акцент, то берем контакты, прощаемся:</b> Спасибо Вам за проявленный интерес к нашей Компании. Мы сохраним Ваши контакты. И, в СЛУЧАЕ ЗАИНТЕРЕСОВАННОСТИ, сотрудники отдела кадров свяжутся с Вами. Заполняем отказ!</p>
        </div>
        <br/><br/>

        <div class="block">
            <p><b>Уточните, пожалуйста, сколько вам полных лет?</b></p>
            <p>Возраст кандидата</p>
            <input id="info_age_candidat" value="<?php echo $age;?>" type="text" />
            <p><b>18-50, переходим к следующему пункту</b></p>
            <p><b>50-60, предлагаем также альтернативу вакансию помощника (если есть график)</b></p>
            <p><b>Если да, переходим к следующему пункту</b></p>
            <p><b>Нет: </b>Спасибо Вам за проявленный интерес к нашей Компании. Мы сохраним Ваши контакты. И, в СЛУЧАЕ ЗАИНТЕРЕСОВАННОСТИ, сотрудники отдела кадров свяжутся с Вами. <b>Заполняем отказ!</b></p>
            <p><b>60+</b> Спасибо Вам за проявленный интерес к нашей Компании. Мы сохраним Ваши контакты. И, в СЛУЧАЕ ЗАИНТЕРЕСОВАННОСТИ, сотрудники отдела кадров свяжутся с Вами. <b>Заполняем отказ!</b></p>
        </div><br/><br/>

        <div class="block">
            <p>Комментарий</p>
            <textarea id="comment" rows="8" cols="60" name="text"></textarea>
        </div>

        <?php echo \Yii::$app->view->renderFile('@app/views/vacanciesoperator/create_candidat.php', [    'phone'=>$phone
                ,'fio'=>$fio
                ,'age'=>$age
                ,'nation'=>$nation
                ,'id_candidat'=>$candidat_info['id_candidat']
            ]
        );
        ?>

        <div id="failure">
            <h3>ОТКАЗ</h3>
            <label class="control-label">Отказ Соискателя</label><br/>
            <select id="failure_client">
                <option value=""></option>
                <option value="Не устраивает ЗП">Не устраивает ЗП</option>
                <option value="Не устраивает график">Не устраивает график</option>
                <option value="Не устраивают особенности работы">Не устраивают особенности работы</option>
                <option value="Неудобно добираться">Неудобно добираться</option>
            </select><br/><br/>

            <label class="control-label">Отказ Фрешмаркет</label><br/>
            <select id="failure_fresh">
                <option value=""></option>
                <option value="Акцент">Акцент</option>
                <option value="Возраст">Возраст</option>
                <option value="Ранее проходил собеседование, был получен отказ">Ранее проходил собеседование, был получен отказ</option>
                <option value="Гражданство">Гражданство</option>
                <option value="Другое">Другое</option>
            </select>

        </div>

        <label class="control-label"><b>Сохранить данные о звонке</b> без записи кандидата</label><br/>
        <div id="btn_save_form" class ="btn btn-primary" method="saveform" onclick="save_form($(this))">Сохранить</div>
        <p style="color: red;">Нажимаем "Сохранить", если не записали клиента!</p>
        <div id="result_form"></div>





    </div>

</div>

