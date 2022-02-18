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

    <?php echo var_dump($id_project);?>

    <?php $form = ActiveForm::begin($form_begin); ?>

    <?= $form->field($model, 'id_project')->hiddenInput()->label(false) ?>

    <input type="hidden" id="id_company" class="form-control" name="id_company" value="<?php echo $id_company;?>">

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'date_task')->textInput() ?>

    <?php
    /*
        echo DateTimePicker::widget([
            'id' => 'date_time_task_'.$id_project,
            'name' => 'Tasks[date_task]',
            'autocomplete' => 'off',
            'options' => ['placeholder' => 'Ввод даты и времени'],
            'convertFormat' => true,
            'pluginOptions' => [
                //'format' => 'dd-MM-yyyy HH:i:s',
                'format' => 'yyyy-MM-dd HH:i:s',
                //'startDate' => '01-Mar-2014 12:00 AM',
                'todayHighlight' => true,
                'autoclose'=>true,
                'weekStart'=>1,
            ]
        ]);
    */


    ?>

    <?= $form->field($model, 'date_task')->textInput(['type' => 'date']); ?>

    <?php /* = $form->field($model,'date_task')->widget(DatePicker::class, [
        'language' => 'ru',
        //'dateFormat' => 'dd.MM.yyyy,
        'options' => [
            'placeholder' => Yii::$app->formatter->asDate($model->date_task),
            'class'=> 'form-control',
            'autocomplete'=>'off'
        ],
        'clientOptions' => [
            'changeMonth' => true,
            'changeYear' => true,
            'yearRange' => '2015:2050',
            //'showOn' => 'button',
            //'buttonText' => 'Выбрать дату',
            //'buttonImageOnly' => true,
            //'buttonImage' => 'images/calendar.gif'
        ]])->label(false) */?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
