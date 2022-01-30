<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use vova07\imperavi\Widget;
use yii\helpers\Url;

$this->registerJsFile('web/js/outbound_lists.js');

$this->title = 'Создание листа загрузки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
<h1><?= Html::encode($this->title);?></h1>    
<?php	
	$form = ActiveForm::begin([
    'id' => 'edit-outboundlist',
    'options' => ['class' => 'form-horizontal'],
	'action' => 'save',
]) ?>
    	
	
	<?= $form->field($model, 'name')->TextInput(array('style' => 'width: 500px;'))->label('Имя листа') ?>
	<div id="dsn" style="background-color: #eee; padding:5px;">
		<p>Подключение к базе:</p>
		<style>
			#dsn .form-group{
				margin-left: 0 !important;
			}
		</style>
		<?= $form->field($model, 'dsn_dsn')->TextInput(array('style' => 'width: 500px;'))->label('DSN') ?>
		<?= $form->field($model, 'dsn_table')->TextInput(array('style' => 'width: 500px;'))->label('Table') ?>
		<?= $form->field($model, 'dsn_user')->TextInput(array('style' => 'width: 500px;'))->label('User') ?>
		<?= $form->field($model, 'dsn_password')->TextInput(array('style' => 'width: 500px;'))->label('Password') ?>
		<?= $form->field($model, 'settings')->textarea(['rows' => 5, 'cols' => 5])->label('Mapping загрузки в БД') ?>
	</div>
	
	<?= $form->field($model, 'id')->hiddenInput()->label(false) ?>

    <div class="row">
        <div class="col-lg-4">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>			
			 <?= Html::a('Отмена', ['index'], ['class' => 'btn btn-primary']) ?>			
        </div>
		
    </div>
	
<?php ActiveForm::end() ?>

    
</div>
