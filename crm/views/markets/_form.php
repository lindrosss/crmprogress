<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\Towns;

/* @var $this yii\web\View */
/* @var $model app\models\Markets */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="markets-form">

	<?php 
			$model->id_updator = intval(Yii::$app->user->identity->id);
			$model->date_update = date('Y-m-d H:i:s');
	?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'num_market')->textInput(['maxlength' => true])->label('Номер магазина') ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Магазин') ?>
	
	<?php echo  Select2::widget([							
							'data' => ArrayHelper::map(Towns::find()->where('id != -1')->all(), 'id','name'),
							'name'=>'Markets[id_town]',
							'hideSearch'=> false,
							'id' => 'address3',
							'value' => $model->id_town,
							//'data' => $data,
							'options' => ['placeholder' => 'Выберете город'],
							'pluginOptions' => [
								'allowClear' => true
							],
						]);
						?>

    <?= $form->field($model, 'rm')->textInput(['maxlength' => true])->label('Региональный менеджер') ?>
    <?= $form->field($model, 'recruiter')->textInput(['maxlength' => true])->label('Рекрутер') ?>
   

    

    <?= $form->field($model, 'id_updator')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'date_update')->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
