<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use vova07\imperavi\Widget;


use app\models\Contacts;
use app\models\Projects;
use app\models\Tasks;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Companies */

$this->title = 'Редактировать компанию: ' . $company->name;
$this->params['breadcrumbs'][] = ['label' => 'Компании', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => mb_substr($company->name, 0, 25).'...', 'url' => ['view', 'id' => $company->id]];
//$this->params['breadcrumbs'][] = 'Редактирование';

$this->registerCssFile(Url::to(['web/css/companies/view.css?v=11']));

//$this->registerJsFile('https://code.jquery.com/jquery-latest.min.js',  ['position' => yii\web\View::POS_HEAD]);
$this->registerJsFile(Url::to(['web/js/jquery.js']));
$this->registerJsFile(Url::to(['web/js/companies/companies.js?v=61']));
?>
<div class="companies-update">

    <?php
        $model_company = $model;
        $id_company = $model->id;
    ?>

    <div id="company">
        <div id="status"></div>
        <div id="company_header"><?php echo $company->name;?></div><br/>
        <div id="company_id" style="display: none;"><?php echo $company->id;?></div>

        <div class="item">
            <span class="label">ИНН:</span><input onchange="updateField($(this), 'input_this')" id_item_inn="<?php echo $company->id;?>" controller_name="companies" field_name="inn" class="name" value="<?php echo $company->inn; ?>" type="text" />
            <span class="label">КПП:</span><input onchange="updateField($(this), 'input_this')" id_item_kpp="<?php echo $company->id;?>" controller_name="companies" field_name="kpp" class="name" value="<?php echo $company->kpp; ?>" type="text" />
            <span class="label">Ответственный сотрудник:</span>
            <select onchange="updateField($(this), 'select')" field_name="responsible_usr" id_item_responsible_usr="<?php echo $company->id;?>" controller_name="companies">
                <?php
                $arr = User::getUsersByRole(2);
                foreach ($arr as $key => $value ){
                    $selected = ($key == $company->responsible_usr) ? 'selected="selected"' : '';
                    echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                }
                ?>
            </select>
        </div><br/>

        <div class="item">
            <textarea onchange="updateField($(this), 'textarea_this')" id_item_address="<?php echo $company->id;?>" field_name="address" controller_name="companies" ><?php echo $company->address;?></textarea>
        </div>

        <div class="table">
            <div class="table-row">
                <div id="create_contact"  class="table-cell">

                        <?php	Modal::begin([
                            'header' => '<h2>Создать Контакт</h2>',
                            'toggleButton' => ['label' => 'Создать контакт', 'class'=>'btn btn-success'],
                            'closeButton' => ['id' => 'close-button'],
                            'options' => [
                                'id' => 'contact_modal',
                                'tabindex' => false // important for Select2 to work properly
                            ],
                        ]);


                        //$get = Yii::$app->request->get();

                        echo \Yii::$app->view->renderFile('@app/views/contacts/_form.php', [

                            'id_company' => $id_company,
                            'form_begin' => [ 'id'=>'create_contact'],

                        ]);

                        Modal::end();
                        ?>

                </div>

                <div id="create_project" class="table-cell">
                    <?php	Modal::begin([
                        'header' => '<h2>Создать Проект</h2>',
                        'toggleButton' => ['label' => 'Создать проект', 'class'=>'btn btn-success'],
                        'closeButton' => ['id' => 'close-button'],
                        'options' => [
                            'id' => 'project_modal',
                            'tabindex' => false // important for Select2 to work properly
                        ],
                    ]);

                    $model_project = new Projects();
                    //$get = Yii::$app->request->get();
                    $model_project->id_company = $id_company;
                    echo \Yii::$app->view->renderFile('@app/views/projects/_form.php', [
                        'model' => $model_project,
                        // 'form_begin' => ['action'=>Url::base().'/contacts/create_without_redirect', 'id'=>'create_contact'],
                        'form_begin' => ['id'=>'create_project'],

                    ]);

                    Modal::end();
                    ?>
                </div>
            </div>

            <div class="table-row">

                <div id="contacts" class="table-cell">
                </div>

                <div id="projects" class="table-cell">

                </div>
                <?php
                    foreach ($projects as $item){?>
                    <div class="table-cell project">
                        <div><?php //echo var_dump($item);?></div>
                    </div>
                <?php }?>

            </div>
        </div>

        <div id="comment_item1" class="item">
            <textarea name="<?php echo $company->id;?>" id="comment1" onchange="updateField($(this), 'textarea_this')" id_item_comment="<?php echo $company->id;?>" field_name="comment" controller_name="companies" ><?php echo $company->comment;?></textarea>
            <?php
            echo \vova07\imperavi\Widget::widget([
                'selector' => '#comment1',
                'settings' => [
                    'lang' => 'ru',
                    'minHeight' => 200,
                    'autosave' => 'update_comment',
                    'autosaveOnChange' => true,
                    'plugins' => [
                        'clips',
                        'fullscreen',
                        'fontcolor',
                        //'imagemanager',
                        'table',
                    ],

                ],
            ]);
            ?>
        </div>

    </div>
    --->


	
		
	


</div>
