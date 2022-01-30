<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Scenaries */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="scenaries-form">

	<?php	
	$form = ActiveForm::begin([
    'id' => 'add-scenario',
    'options' => ['class' => 'form-horizontal'],
	'action' => 'save',
	
]) ?>
    	
		<?= $form->field($model, 'title')->textInput(['maxlength' => true] )->label('Имя сценария') ?>
		
		<?php 
			echo $form->field($model, 'text')->widget(Widget::className(), [
					'settings' => [
					'label' => 'Опубликован',
					'lang' => 'ru',
					'minHeight' => 200,
					'imageManagerJson' => Url::to(['/scenaries/images-get']),
					'imageUpload' => Url::to(['scenaries/image-upload']),
					'plugins' => [
						'clips',
						'fullscreen',
						'fontcolor',
						'imagemanager',
						]
				]
			])->label('Текст сценария');
		?>
		
		<?php 
			//$model->id_comaign = [2];
			$params = [
				'prompt' => 'Укажите имя кампанию',
				'style' =>'width: 250px;',
				];
				
			echo $form->field($model, 'id_campaign')->dropDownList( $itemsCampaign, $params)->label('Кампания');
		?>
		
		 <?= $form->field($model, 'is_public')
					 ->checkbox([
					'label' => 'Опубликован',
					'labelOptions' => [
					'style' => 'padding-left:0px;'
				],
				//'disabled' => true
			])
		?>
		
		
	
	

    <div class="row">
        <div class="col-lg-4">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>			
			 <?= Html::a('Отмена', ['index'], ['class' => 'btn btn-primary']) ?>			
        </div>
		
    </div>
	
	<?php ActiveForm::end() ?>
</div>
