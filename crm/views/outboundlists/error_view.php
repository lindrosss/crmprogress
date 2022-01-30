<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Ошибка Список листов для загрузки';
$this->params['breadcrumbs'][] = $this->title;

?>

<div>
	<h1><?php echo $this->title; ?></h1>
	<div>
		<?php echo $error_text;?>
	</div>

</div>

