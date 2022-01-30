<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\MarketsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Магазины');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="markets-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Создать магазин'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['label' =>'Номер магазина', 'attribute'=> 'num_market'],
            ['label' =>'Название', 'attribute'=> 'name'],
			['label' =>'Город', 'attribute'=> 'townName', 'filterOptions' => ['style' => 'width: 450px']],
            ['label' =>'Региональный менеджер', 'attribute'=> 'rm'],
            ['label' =>'Рекрутер', 'attribute'=> 'recruiter'],

            [
			'label' => 'Действие',
			'format' => 'raw',
			'value' => function($data){
				return Html::a(
					'Редактировать',
					//$data->url,
					//'edit?id='.$data->id,
					Url::to(['markets/update']).'?id='.$data->id,
					[
						'title' => 'Редактировать магазин',
						//'target' => '_blank'
					]
				);
			}
			],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
