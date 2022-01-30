<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Scenaries */

$this->title = 'Создать сценарий';
//$this->params['breadcrumbs'][] = ['label' => 'Scenaries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="scenaries-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'itemsCampaign' => $itemsCampaign,
    ]) ?>

</div>
