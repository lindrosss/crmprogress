<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Regions */

$this->title = Yii::t('app', 'Изменить: ' . $model->name, [
    'nameAttribute' => '' . $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Регионы'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Изменить');
?>
<div class="regions-update">

    <h1><?= Html::encode($this->title) ?></h1>

     <div class="regions-form">
		<?php 
			$model->id_updator = intval(Yii::$app->user->identity->id);
			$model->date_update = date('Y-m-d H:i:s');
		?>
		
		<?php //$form = ActiveForm::begin(['action' => 'update',]); ?>
		<?php $form = ActiveForm::begin(); ?>

			<?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название') ?>
			<?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
			<?= $form->field($model, 'id_updator')->hiddenInput()->label(false) ?>
			<?= $form->field($model, 'date_update')->hiddenInput()->label(false) ?>
			

			<div class="form-group">
			<?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success']) ?>
			</div>

		<?php ActiveForm::end(); ?>

	</div>

</div>
