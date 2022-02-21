<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Projects;

/* @var $this yii\web\View */
/* @var $model app\models\Projects */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="projects-form">

    <?php
    if(!isset($form_begin)){
        $form_begin = [];
    }
    ?>

    <?php $form = ActiveForm::begin($form_begin); ?>

    <?= $form->field($model, 'id_company')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cost')->textInput() ?>

    

    <?php
    $items = Projects::$sourcesCodes;
    $params = [
        'prompt' => 'Укажите источник'
    ];
    echo $form->field($model, 'source')->dropDownList($items,$params);
    ?>

    <?php
        $items = Projects::$stageCodes;
        $params = [
            'prompt' => 'Укажите этап'
        ];
        echo $form->field($model, 'stage')->dropDownList($items,$params);
    ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
