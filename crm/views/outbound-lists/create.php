<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\OutboundLists */

$this->title = 'Create Outbound Lists';
$this->params['breadcrumbs'][] = ['label' => 'Outbound Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="outbound-lists-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
