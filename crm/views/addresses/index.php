<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\AddressesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Адреса');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="addresses-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Создать адрес'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			['label' =>'Адрес прохождения собеседований', 'attribute'=> 'name', 'filterOptions' => ['style' => 'width: 750px']],

            [
                'label' => 'Удален',
                'value' => function($data){
                    if($data->is_public == 0){
                        return 'Удален';
                    }else{
                        return '';
                    }
                }
            ],

			[
			'label' => 'Действие',
			'format' => 'raw',
			'value' => function($data){
				return Html::a(
					'Редактировать',
					//$data->url,
					//'edit?id='.$data->id,
					Url::to(['addresses/update']).'?id='.$data->id,
					[
						'title' => 'Редактировать адрес',
						//'target' => '_blank'
					]
				);
			}
			],
            
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
