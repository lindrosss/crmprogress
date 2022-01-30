<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Addresses */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="addresses-form">
	<?php 
			$model->id_updator = intval(Yii::$app->user->identity->id);
			$model->date_update = date('Y-m-d H:i:s');
	?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Адрес') ?>

    <?= Html::activeCheckbox($model, 'is_public', ['class' => 'agreement']) ?>

    <?= $form->field($model, 'id_updator')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'date_update')->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
