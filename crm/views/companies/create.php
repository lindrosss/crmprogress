<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Companies */

$this->title = 'Новая компания';
$this->params['breadcrumbs'][] = ['label' => 'Компании', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="companies-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
