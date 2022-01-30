<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\Regions;

/* @var $this yii\web\View */
/* @var $model app\models\Towns */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="towns-form">

	<?php 
			$model->id_updator = intval(Yii::$app->user->identity->id);
			$model->date_update = date('Y-m-d H:i:s');
		?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Город') ?>
	
	<?php echo  Select2::widget([							
							'data' => ArrayHelper::map(Regions::find()->where('id != -1')->all(), 'id','name'),
							'name'=>'Towns[id_region]',
							'hideSearch'=> false,
							'id' => 'address2',
							'value' => $model->id_region,
							//'data' => $data,
							'options' => ['placeholder' => 'Выберете регион'],
							'pluginOptions' => [
								'allowClear' => true
							],
						]);
						?>

    

    <?= $form->field($model, 'id_updator')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'date_update')->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
