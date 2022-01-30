<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use vova07\imperavi\Widget;
use yii\helpers\Url;

$this->title = 'Редактирование сценария';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
<h1><?= Html::encode($this->title); echo ' #'.$get['id']; ?></h1>    

<?php	
	$form = ActiveForm::begin([
    'id' => 'edit-scenario',
    'options' => ['class' => 'form-horizontal'],
	'action' => 'update',
]) ?>
    	
	<?= $form->field($scenario, 'title')->TextInput(array('style' => 'width: 500px;'))->label('Название') ?>
	
	<?php 
		echo $form->field($scenario, 'text')->widget(Widget::className(), [
				'settings' => [
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
		])->label('Текст');
	?>
	
		<?php 
			$scenario->id_campaign = [$scenario->id_campaign]; //preSelect
			$params = [
				'prompt' => 'Укажите имя кампанию',
				'style' =>'width: 250px;',
				];
				
			echo $form->field($scenario, 'id_campaign')->dropDownList( $itemsCampaign, $params)->label('Кампания');
		?>
	
	 <?= $form->field($scenario, 'is_public')
					 ->checkbox([
					'label' => 'Опубликован',
					'labelOptions' => [
					'style' => 'padding-left:0px;'
				],
				//'disabled' => true
			])
		?>
	
	<?= $form->field($scenario, 'replace_codes')->textarea(['rows' => 2, 'cols' => 5])->label('Коды замены [ ]');?>
	
	<?= $form->field($scenario, 'id')->hiddenInput()->label(false) ?>

    <div class="row">
        <div class="col-lg-4">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>			
			 <?= Html::a('Отмена', ['index'], ['class' => 'btn btn-primary']) ?>			
        </div>
		
    </div>
	
<?php ActiveForm::end() ?>


    
</div>
