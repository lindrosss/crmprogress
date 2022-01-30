<?php

namespace app\controllers;

use Yii;
use app\models\Scenaries;
use app\models\ScenariesSearch;
use app\models\Campaigns;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * ScenariesController implements the CRUD actions for Scenaries model.
 */
class ScenariesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Scenaries models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ScenariesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		/*
		$query = Scenaries::find()->where(['is_public' => 1]);
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => 10,
			],
			'sort' => [
				'defaultOrder' => [
					'id' => SORT_ASC,					
				]
			],
		]);
		*/
        return $this->render('index_view', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionIndex1()
    {
		$query = ScenariesModel::find()->where(['is_public' => 1]);

		$provider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => 10,
			],
			'sort' => [
				'defaultOrder' => [
					'id' => SORT_ASC,					
				]
			],
		]);
	}
    /**
     * Displays a single Scenaries model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Scenaries model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Scenaries();
		$modelCampaign = new Campaigns();
		
		
		$campaigns = Campaigns::find()->all();	
		$itemsCampaign = ArrayHelper::map($campaigns,'id','name');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
			'itemsCampaign' => $itemsCampaign,
        ]);
    }
	
	public function actionSave()
    {
        $model = new Scenaries();
		
		/*
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        }
		*/
		$post = Yii::$app->request->post();
		if( $model->load( Yii::$app->request->post() ) ){
			
			//$model->is_public = 1;
			//return var_dump(Yii::$app->request->post());//
			
			$model->id_campaign = intval($post['Scenaries']['id_campaign']);
			$model->id_updator = intval(Yii::$app->user->identity->id);
			$model->date_create = date('Y-m-d H:i:s');
			
			//echo var_dump( $model);
			
			
			if($model->save()){
				return $this->redirect(['index', 'id' => $model->id]);
			}else {echo 'err';}
			
			
		}
		
		
		//echo var_dump($model);
		 //echo $model->save();
		
		/*Здесь должен быть рендер вьюхи с ошибкой*/
		/*
        return $this->render('create', [
            'model' => $model,
        ]);
		*/
    }

    
	public function actionUpdate()
    {	
		$post = \Yii::$app->getRequest()->post();
		$id = $post['Scenaries']['id'];
		
        //$model = $this->findModel($id);
		$model = \app\models\Scenaries::find()
				->where(['id' => $id] )
				->one();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('index_view', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Scenaries model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Scenaries model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Scenaries the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Scenaries::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	public function actionEdit()
    {
		$get = Yii::$app->request->get();
		$null_id = true;
		if(isset($get['id'])){
			$null_id = false;				
			
			$scenario = \app\models\Scenaries::find()
				->where(['id' => $get['id']])
				->one();
		}	
		
		$campaigns = Campaigns::find()->all();	
		$itemsCampaign = ArrayHelper::map($campaigns,'id','name');
		
		return $this->render('editscenario_view', [
            'get' => $get,			
			'null_id' => $null_id,
			'scenario' => $scenario,
			'itemsCampaign' => $itemsCampaign,
			
        ]);
	}
	
	public function actions()
	{
		return [
			'images-get' => [
				'class' => 'vova07\imperavi\actions\GetImagesAction',
				//'url' => 'http://localhost/upload/images/', // Directory URL address, where files are stored.
				'url' => \Yii::$app->params['imgurl'], // Directory URL address, where files are stored.			
				
				'path' => \Yii::$app->params['imgpath'], // Or absolute path to directory where files are stored.
				'options' => ['only' => ['*.jpg', '*.jpeg', '*.png', '*.gif', '*.ico']], // These options are by default.
			],
			
			 'image-upload' => [
				'class' => 'vova07\imperavi\actions\UploadFileAction',
				//'url' => 'http://localhost/upload/images/', // URL адрес папки куда будут загружатся изображения.
				//'path' => 'C:/xampp/htdocs/upload/images/', // Или абсолютный путь к папке куда будут загружатся изображения.
				'url' => \Yii::$app->params['imgurl'], // Directory URL address, where files are stored.			            
				'path' => \Yii::$app->params['imgpath'], // Or absolute path to directory where files are stored.
				'validatorOptions' => [
					 'maxWidth' => 1500,
					 'maxHeight' => 1000
				 ],
				'unique' => false, //не переименовывать файлы
				],
				
			//Загрузка файлов
			'file-upload' => [
				'class' => 'common\widgets\UploadKsl', 
				'url' => '/frontend/web/files/', 
				'path' => '@frontend/web/files', 
				'uploadOnlyImage' => false, //загрузка не изображений
				'unique' => false, //не переименовывать файлы
				'validatorOptions' => [
					'maxSize' => 100000, //Размер в Bite
				]
			],
			'files-get' => [
				'class' => 'vova07\imperavi\actions\GetAction',
				'url' => '/frontend/web/files/',  // URL адрес папки где хранятся файлы.
				'path' => '@frontend/web/files',  // Или абсолютный путь к папке с файлами.
				//'type' => \vova07\imperavi\actions\GetAction::TYPE_FILES,
			],	
		];
	}
	
	/*получает контент сценария*/
	public function actionGetscenario()
    {
		$get = Yii::$app->request->get();
		$null_id = true;
		if(isset($get['id'])){
			$null_id = false;				
			
			$scenario = \app\models\Scenaries::find()
				->where(['id' => $get['id']])
				->one();
				
			$return_str = $scenario->text;
			
			/*Замена в тексте сценария short-кодов, указанных в настройках replace_codes
			* key - short-код в тексте сценария
			* value - имя Get-параметра
			*/
				
			$arr = unserialize($scenario->replace_codes);
				if(is_array($arr)){
					foreach($arr as $item){
						
						$short_code = (string)key($arr);
						if(isset($get[$item])){
							$return_str	= str_replace ('['.$short_code.']', $get[$item], $return_str);
						}	
						//$addr = (string)key($arr);
						//$addr .= (string)$row;
						
						next($arr);
						//$fields .= $item.', ';
						//$values .= "'".$workSheet->getCell($addr)->getValue()."', ";	 kernel/scenaries/getscenario?id=24&fio=fioget&date_form=datefromget		
					}			
				}
			
			
			return $return_str;
		}	
	}
	
	
}
