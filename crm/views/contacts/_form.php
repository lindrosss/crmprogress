<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\BaseHtml;
use app\models\Contacts;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Contacts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contacts-form">

	<?php
		if(!isset($form_begin)){
			$form_begin = [];
		}

        if(!isset($model)){
            $model = new Contacts();
            $model->id_company = $id_company;

        }else{
           //echo var_dump($model);
        }

	?>

    <?php Pjax::begin(['id' => 'modal_pj_contacts']) ?>

            <?php $form = ActiveForm::begin($form_begin); ?>

            <?= $form->field($model, 'id_company')->hiddenInput()->label(false) ?>

            <?= $form->field($model, 'fio')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'phones')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'emails')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'post')->textInput(['maxlength' => true]) ?>


        <div class="form-group">
            <?= Html::submitButton('Сохранить контакт', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    <?php Pjax::end() ?>


</div>
