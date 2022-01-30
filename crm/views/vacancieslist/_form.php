<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Vacancies */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vacancies-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'info')->textarea(['rows' => 6]) ?>



    <?=
    $form->field($model, 'employment')
        ->dropDownList([
            'Полная' => 'Полная',
            'Частичная' => 'Частичная',
            'Любая' => 'Любая',
        ],
            [
                'prompt' => 'Укажите занятость'
            ]);
    ?>

    <?= $form->field($model, 'is_public')
        ->checkbox([
            'label' => 'Опубликована',
            'labelOptions' => [
                'style' => 'padding-left:20px;'
            ],
            //'disabled' => true
        ]);?>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
