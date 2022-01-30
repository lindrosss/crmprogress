<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Companies */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Компании', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="companies-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'id',
            'name',
            'inn',
            'kpp',
            'address:ntext',
            'comment:ntext',
            'date_create',
        ],
    ]) ?>
	
	<h2>Контакты</h2>
	<?php 
		if($contacts){
			$itemStr = '<table style="width: 95%;"><tr><th>ФИО</th><th>Телефоны</th><th>Почта</th><th>Должность</th><tr/>';
			foreach($contacts as $item){
				$itemStr .=	'<tr id_row="'.$item->id.'">';
					$itemStr .=	'<td style="padding-right: 15px;" id_row="'.$item->id.'">'.$item->fio.'</td>';
					$itemStr .=	'<td style="padding-right: 15px;" id_row="'.$item->id.'">'.$item->phones.'</td>';
					$itemStr .=	'<td style="padding-right: 15px;" id_row="'.$item->id.'">'.$item->emails.'</td>';
					$itemStr .=	'<td style="padding-right: 15px;" id_row="'.$item->id.'">'.$item->post.'</td>';
				$itemStr .=	'</tr>';	
			}
			$itemStr .=	'</table>';
			
			echo $itemStr;	
		}
	?>

</div>
