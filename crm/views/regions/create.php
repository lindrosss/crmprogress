<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Regions */

$this->title = Yii::t('app', 'Создать регион');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Регионы'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="regions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="regions-form">

		<?php $form = ActiveForm::begin(['action' => 'create',]); ?>

			<?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название') ?>
			

			<div class="form-group">
			<?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-success']) ?>
			</div>

		<?php ActiveForm::end(); ?>

	</div>

</div>
