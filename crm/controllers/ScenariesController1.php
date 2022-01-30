<?php

/*контроллер блока редактирования сценариев*/

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\ScenariesModel;
use yii\data\ActiveDataProvider;

class ScenariesController extends Controller
{
	public $enableCsrfValidation = false;
    
	public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
	
	public function actionIndex()
    {
		//Yii::$app->controller->enableCsrfValidation = false;
		//$get = Yii::$app->request->get();	
		//$post = Yii::$app->request->post();	
		//$any = 'sdfsdfsdf';
		
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
		
		return $this->render('list_scenario_view', [
            //'post' => $post,
			//'any' => $any,
			'provider' => $provider,
        ]);
		
		
		/*
		return $this->render('sms');
		*/
		// \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		//return $post;
    }
	
	public function actionEdit()
    {
		$get = Yii::$app->request->get();
		$null_id = true;
		if(isset($get['id'])){
			$null_id = false;				
			
			$scenario = \app\models\ScenariesModel::find()
				->where(['id' => $get['id']])
				->one();
		}	
		
		return $this->render('basescenario_view', [
            'get' => $get,			
			'null_id' => $null_id,
			'scenario' => $scenario,
        ]);
	}
	
	/*получает контент сценария*/
	public function actionGetscenario($id)
    {
		$get = Yii::$app->request->get();
		$null_id = true;
		if(isset($get['id'])){
			$null_id = false;				
			
			$scenario = \app\models\ScenariesModel::find()
				->where(['id' => $get['id']])
				->one();
			
			/*			
			return $this->render('singlescenario_view', [
				'get' => $get,			
				'null_id' => $null_id,
				'scenario' => $scenario,
			]);
			*/
			return $scenario->text;
		}	
	}
	
	public function actionUpdate()
	{
		$model = new ScenariesModel();
		$request = \Yii::$app->getRequest();		
		
		if (isset($request) && $request->isPost && $model->load($request->post())){
			$post = $request->post();
			
			$scenario = \app\models\ScenariesModel::find()
				->where(['id' => $post['ScenariesModel']['id']] )
				->one();
			
			$scenario->text = $model->text ;
			$scenario->save();
				
			//if($	
			//return var_dump($post);
			
			//return 'ok';
			
			return $this->render('singlescenario_view', [
				
				'scenario' => $model,
			]);
		}
		
		
		if ($request->isPost && $model->load($request->post())) {	
			//$model->save();
			
			return $this->render('singlescenario_view', [
				
				'scenario' => $model,
			]);
		}
	}	
}
