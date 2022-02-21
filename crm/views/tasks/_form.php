<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use yii\jui\DatePicker;

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

    <?php $form = ActiveForm::begin($form_begin); ?>

    <?= $form->field($model, 'id_project')->hiddenInput()->label(false) ?>

    <input type="hidden" id="id_company" class="form-control" name="id_company" value="<?php echo $id_company;?>">


    <?= $form->field($model, 'name')->textarea(['rows' => 6]) ?>


    <?= $form->field($model, 'date_task')->textInput(['type' => 'date']); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
