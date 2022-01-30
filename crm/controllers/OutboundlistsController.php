<?php

namespace app\controllers;

use Yii;
use app\models\Outboundlists;
use app\models\OutboundListsSearch;
use app\models\UploadForm;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use app\vendor\Classes;



class OutboundlistsController extends \yii\web\Controller
{
	/**/
    public function actionIndex()
    {
		$searchModel = new OutboundListsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
		
        return $this->render('index');
		
    }
	
	public function actionEdit()
    {
		$get = Yii::$app->request->get();
		$null_id = true;
		if(isset($get['id'])){
			$null_id = false;				
			
			$model = \app\models\Outboundlists::find()
				->where(['id' => $get['id']])
				->one();
				
			$dsn = unserialize($model->dsn);
			$model->dsn_dsn = $dsn['dsn'];	
			$model->dsn_table = $dsn['table'];	
			$model->dsn_user = $dsn['user'];	
			$model->dsn_password = $dsn['password'];	
		}	
		
		
		
		return $this->render('editoutboundlists_view', [
            'get' => $get,			
			'null_id' => $null_id,
			'model' => $model,
			
        ]);
	}
	
	public function actionUpdate()
    {
		$post = \Yii::$app->getRequest()->post();
		$id = $post['OutboundLists']['id'];		
        
		echo var_dump($post);
		
		$model = \app\models\Outboundlists::find()
				->where(['id' => $id] )
				->one();
		$dsn = array();
		$dsn['dsn'] = $post['OutboundLists']['dsn_dsn'];
		$dsn['table'] = $post['OutboundLists']['dsn_table'];
		$dsn['user'] = $post['OutboundLists']['dsn_user'];
		$dsn['password'] = $post['OutboundLists']['dsn_password'];		
		
		$model->name = $post['OutboundLists']['name'];
		$model->dsn	= serialize($dsn);
		$model->settings = $post['OutboundLists']['settings'];
		
		$model->id_updator = intval(Yii::$app->user->identity->id);
		$model->date_create = date('Y-m-d H:i:s');

		if($model->save()){
			return $this->redirect(['index']);	
		}else{
			echo 'Произошла ошибка редактирования';
		}	
		
	}	
	
	public function actionCreate()
    {
		/*
		$get = Yii::$app->request->get();
		$null_id = true;
		if(isset($get['id'])){
			$null_id = false;				
			
			$scenario = \app\models\Outboundlists::find()
				->where(['id' => $get['id']])
				->one();
		}	
		*/
		$model = new Outboundlists();
		
		return $this->render('addoutboundlists_view', [
            //'get' => $get,			
			//'null_id' => $null_id,
			'model' => $model,
			
        ]);
	}
	
	public function actionSave()
    {
		$post = Yii::$app->request->post();
		
		if(isset($post)){
			$dsn = array();
			$settings = array();
			
			$settings['A'] = 'fio';
			$settings['B'] = 'phone';
			$settings['C'] = 'email';
			
			
			$dsn['dsn'] = $post["OutboundLists"]["dsn_dsn"];
			$dsn['table'] = $post["OutboundLists"]["dsn_table"];
			$dsn['user'] = $post["OutboundLists"]["dsn_user"];
			$dsn['password'] = $post["OutboundLists"]["dsn_password"];
			
			$model = new Outboundlists();
			
			$model->name = $post["OutboundLists"]["name"];
			$model->dsn = serialize($dsn);
			//$model->settings = serialize($settings);
			$model->settings = $post["OutboundLists"]["settings"];
			$model->id_updator = intval(Yii::$app->user->identity->id);
			$model->date_create = date('Y-m-d H:i:s');
			
			if($model->save()){
				return $this->redirect(['index', 'id' => $model->id]);
			}else{
				return $this->Error(['Ошибка "actionSave"']);
				//echo var_dump($model);
			}	
		}		
		
	}	
	
	public function actionLoaddata()
    {
		$get = Yii::$app->request->get();
		$null_id = true;
		if(isset($get['id'])){
			$null_id = false;				
			
			$model = \app\models\Outboundlists::find()
				->where(['id' => $get['id']])
				->one();
			
			
			
			if(!empty($model)){
				$dsn = unserialize($model->dsn);
				$settings = unserialize($model->settings);
				
				$modelFile = new UploadForm();
				
				$file_status = 'no';
				if(isset($get['file_status']) && $get['file_status'] == 'ok'){
					$file_status = 'ok';
				}	
				
				return $this->render('load_data', [            
				'dsn' => $dsn,
				'model' => $model,		
				'modelFile' =>$modelFile,	
				'file_status' => $file_status,
				'settings' => $settings,
				]);
				
			}else{
				//return $this->Error(['Пустая модель"']);
				echo 'err';
			}
			
		}else{
				//$this->Error('Пустая модель');
				echo 'error Пустая модель';
			}
	}

	public function actionLoadfile()
    {
		 $model = new UploadForm();
    
		if(Yii::$app->request->post()){
			$model->file = UploadedFile::getInstance($model, 'file');
			if ($model->validate()) {
				$path = \Yii::$app->params['xlspath'];
				$model->file->saveAs( $path . $model->file);
				
				$post = Yii::$app->request->post();
				//echo var_dump($post);
				$id = $post['OutboundLists']['id'];
				
				$this->updateSourceFile($id, $path . $model->file);
				
				return $this->redirect(['loaddata', 'id' => $id, 'file_status' => 'ok' ]);
			}
			else{echo 'err actionLoadfile';}
		}
		
		
		//return $this->render('load_data', ['id'=>'3']);
		    
	}	
	
	public function updateSourceFile($id_list, $path_file_list)
    {		
		$model = \app\models\Outboundlists::find()
				->where(['id' => $id_list])
				->one();
				
		$model->source_file = $path_file_list;
		$model->id_updator = intval(Yii::$app->user->identity->id);
		$model->date_create = date('Y-m-d H:i:s');		
		$model->save();
		
		/*		
		$dsn = unserialize($model->dsn);	
		
		$connection = new \yii\db\Connection([
			'dsn' => $dsn['dsn'],
			'username' => $dsn['user'],
			'password' => $dsn['password'],
		]);
								
		$connection->open();
		*/			
	}
	
	public function actionLoadfromsourcefile()
    {
		$post = Yii::$app->request->post();
		$null_id = true;
		if(isset($post['OutboundLists']['id'])){
			$model = \app\models\Outboundlists::find()
				->where(['id' => $post['OutboundLists']['id']])
				->one();
		}
				
		if(!empty($model->source_file)){
			$dsn = unserialize($model->dsn);
			$settings = unserialize($model->settings);
			
			$connection = new \yii\db\Connection([
				'dsn' => $dsn['dsn'],
				'username' => $dsn['user'],
				'password' => $dsn['password'],
				'charset' => 'utf8',
			]);			
			
			
			require_once Yii::getAlias('@vendor').'/Classes/PHPExcel/IOFactory.php';
			
			$objPHPExcel = \PHPExcel_IOFactory::load($model->source_file);
			$workSheet = $objPHPExcel->getSheet(0);
			
			if(is_array($settings)){
				
				if(isset($post['OutboundLists']['delete_data_before_load']) && $post['OutboundLists']['delete_data_before_load'] == true){
						$sql = "DELETE FROM ".$dsn["table"];					
						$command = $connection->createCommand($sql);
						$command->execute();
					}	
				
				$highestRow = $workSheet->getHighestRow(); // e.g. 10
				for ($row = 2; $row <= $highestRow; ++ $row) {
					$fields = '';
					$values = '';
					
					$arr = $settings;
					foreach($arr as $item){
						$addr = (string)key($arr);
						$addr .= (string)$row;
						
						next($arr);
						$fields .= $item.', ';
						$values .= "'".$workSheet->getCell($addr)->getValue()."', ";				
					}	
					$fields = substr($fields,0,-2);
					$values = substr($values,0,-2);
					
					
										
					$sql = "INSERT INTO ".$dsn["table"]." (".$fields.") values (".$values.")";					
					$command = $connection->createCommand($sql);
					$command->execute();
					
					$model->id_uploader = intval(Yii::$app->user->identity->id);
					$model->date_load_from_file = date('Y-m-d H:i:s');
					$model->save();
				}
			}
			
		}	else{
				echo 'Пустой файл источника post: '.var_dump($model);
			}
			
			return $this->redirect(['index', 'id' => $model->id ]);
	}	
	
	public function Error($error_text)
    {		
		return $this->render('error_view', [            
			'error_text' => $error_text,			
        ]);
	}	

}
