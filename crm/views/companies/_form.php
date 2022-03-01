<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Companies */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="companies-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'inn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kpp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>

    <?php
        $items = User::getUsersByRole(2);
        $params = [
            'prompt' => 'Укажите ответственного сотрудника'
        ];
        echo $form->field($model, 'responsible_usr')->dropDownList($items,$params);
    ?>

  
	
	<?php 
		echo $form->field($model, 'comment')->widget(Widget::className(), [
				'settings' => [
				'lang' => 'ru',
				'minHeight' => 200,
				//'imageManagerJson' => Url::to(['/scenaries/images-get']),
				//'imageUpload' => Url::to(['scenaries/image-upload']),
				'plugins' => [
					'clips',
					'fullscreen',
					'fontcolor',
					//'imagemanager',
					'table',
					]
			]
		])->label('Комментарий');
	?>
   

    <div class="form-group">
        <?= Html::submitButton('Сохранить компанию', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
