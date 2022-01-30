<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use vova07\imperavi\Widget;
use yii\helpers\Url;

$this->title = 'Загрузка данных';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
<h1><?= Html::encode($this->title);?></h1>    

<div>
	<p><b>DSN:</b> <?php echo $dsn['dsn'];?></p>
	<p><b>Table:</b> <?php echo $dsn['table'];?></p>
	<p><b>User:</b> <?php echo $dsn['user'];?></p>
</div>

<?php if($file_status == 'ok'){ ?>

<?php 
	//echo $_SERVER['SERVER_NAME'].'<br/>';// '/kernel_hub/vendor/Classes/PHPExcel/IOFactory.php';
	//echo Yii::getAlias('@vendor');
	
	//$dir = 'C:\xampp\htdocs\kernel_hub\vendor\Classes\PHPExcel\IOFactory.php';
	
	/*
	$dir = Yii::getAlias('@vendor').'/Classes/PHPExcel/IOFactory.php';	
	require_once $dir;// '/../vendor/Classes/PHPExcel/IOFactory.php';
	*/
	
	//$pathXls = \Yii::$app->params['xlspath'].$model->source_file;
	//echo 'asdasd '.$pathXls.' dsadasd';
	echo '<p><b>file: </b>'.$model->source_file.'</p>';
	/*
	$objPHPExcel = PHPExcel_IOFactory::load($model->source_file);
	$workSheet = $objPHPExcel->getSheet(0);
	
	//echo var_dump($settings);
	
	if(is_array($settings)){
		$highestRow = $workSheet->getHighestRow(); // e.g. 10
		for ($row = 2; $row <= $highestRow; ++ $row) {
			$fields = '';
			$values = '';
			
			$arr = $settings;
			foreach($arr as $item){
				$addr = (string)key($arr);
				$addr .= (string)$row;
				//echo 'addr '. $addr;
				//echo key($settings).' '.$item.'<br/>';			
				next($arr);
				$fields .= $item.', ';
				$values .= $workSheet->getCell($addr)->getValue().', ';				
			}	
			$fields = substr($fields,0,-1);
			$values = substr($values,0,-1);
			$sql = 'INSERT INTO '.$dsn['table'].' ('.$fields.') values ('.$values.')';
			echo $sql.'</br>';
		}
	}	
		*/
	$form = ActiveForm::begin([
		'id' => 'edit-outboundlist',
		'options' => ['class' => 'form-horizontal'],
		'action' => 'loadfromsourcefile',
	]) ?>
	
		 <?= $form->field($model, 'delete_data_before_load')
					 ->checkbox([
					'label' => 'Очистить базу перед заливкой данных',
					'labelOptions' => [
					//'style' => 'padding-left:0px;'
				],
				//'disabled' => true
			])
		?>
    	
		<?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
		
		<div class="row">
			<div class="col-lg-4">
				<?= Html::submitButton('Загрузить данные в базу', ['class' => 'btn btn-primary']) ?>			
				 <?= Html::a('Отмена', ['loaddata', 'id'=>$model->id], ['class' => 'btn btn-primary']) ?>			
			</div>		
		</div>
		
	<?php ActiveForm::end() ?>
	
	
	

		<p>Файл был загружен</p>
		<p><a href="loaddata?id=<?php echo $model->id;?>">Загрузить другой файл</a></p>
		
	<?php } else{
?>

	<?php $form = ActiveForm::begin([
		'options' => ['enctype' => 'multipart/form-data'],
		'action' => 'loadfile',
		]); 
	?>
	 
		<?= $form->field($modelFile, 'file')->fileInput(); ?>
		<?= $form->field($model, 'id')->hiddenInput()->label(false) ?> 		
		<button>Загрузить файл</button>
		<p><a href="index">Отмена</a></p>
	 
	<?php ActiveForm::end(); ?>

	<?php } ?>
    
</div>
