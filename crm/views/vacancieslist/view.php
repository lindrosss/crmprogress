<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Vacancies */

$this->title = 'Вакансия: '.$model->name;
$this->params['breadcrumbs'][] = ['label' => 'Список вакансий', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="vacancies-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'info:ntext',
            'employment',
          //  'is_zum',
          //  'id_timetable:datetime',
          //  'id_address',
          //  'is_public',
            [
                'label' => 'Опубликована',
                'format' => 'raw',
                'value' => function($data)  {
                    if($data->is_public ==1){
                        return 'Да';
                    }else{
                        return 'Нет';
                    }

                }
            ],
          //  'id_updator',
            'date_update',

          //  'date_upload',
        ],
    ]) ?>

</div>
