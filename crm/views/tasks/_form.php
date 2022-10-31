<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use yii\jui\DatePicker;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Tasks */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tasks-form">

    <?php
    if(!isset($form_begin)){
        $form_begin = [];
    }
    ?>

    <?php Pjax::begin(['id' => 'modal_pj_tasks']) ?>

        <?php $form = ActiveForm::begin($form_begin); ?>

            <?= $form->field($model, 'id_project')->hiddenInput()->label(false) ?>

            <?= $form->field($model, 'name')->textarea(['rows' => 6]) ?>


            <?= $form->field($model, 'date_task')->textInput(['type' => 'date']); ?>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>

        <?php ActiveForm::end(); ?>

    <?php Pjax::end() ?>

</div>
