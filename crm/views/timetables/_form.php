<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Timetables */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="timetables-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_vacancy')->textInput() ?>

    <?= $form->field($model, 'date_interview')->textInput() ?>

    <?= $form->field($model, 'quota')->textInput() ?>

    <?= $form->field($model, 'id_updator')->textInput() ?>

    <?= $form->field($model, 'date_update')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
