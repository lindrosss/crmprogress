<?php

namespace app\controllers;

use Yii;
use app\models\Regions;
use app\models\RegionsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RegionsController implements the CRUD actions for Regions model.
 */
class RegionsController extends Controller
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
     * Lists all Regions models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RegionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Regions model.
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
     * Creates a new Regions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Regions();		
		$post = \Yii::$app->getRequest()->post();
		if(isset($post['Regions']['name'])){
		
			$model->name = $post['Regions']['name'];
			$model->id_updator = intval(Yii::$app->user->identity->id);
			$model->date_update = date('Y-m-d H:i:s');
			
			if ($model->save()) {
				return $this->redirect(['index', 'id' => $model->id]);return 1;
			}
		}else{
			return $this->render('create', [
				'model' => $model,
			]);
		}
		
		
		/*
		
		*/
    }
	
	public function actionSave()
    {
		$post = \Yii::$app->getRequest()->post();
		//echo var_dump($post);
		//exit;
		
		$model = new Regions();
		
		$model->name = $post['Regions']['name'];
		$model->id_updator = intval(Yii::$app->user->identity->id);
		$model->date_update = date('Y-m-d H:i:s');
		
        if ($model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);return 1;
        }

		return $this->render('create', [
            'model' => $model,
        ]);
	}	

    /**
     * Updates an existing Regions model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
		//$post = \Yii::$app->getRequest()->post();
		//$post = \Yii::$app->getRequest()->post();
		//if(isset($post['Regions']['id'])){
			//$model = $this->findModel($post['Regions']['id']);
		$model = $this->findModel($id);
		/*
		if(isset($post['id'])){
			$id = $post['id'];
			$model = $this->findModel($id);

			return $this->render('update', [
				'model' => $model,
				'action' => 'update',
			]);
		}else{
			echo 'Не передан ID региона';
		}*/
		
			if ($model->load(Yii::$app->request->post()) && $model->save()) {
				return $this->redirect(['index', 'id' => $model->id]);
			}
		//}
		
		//$model = new Regions();
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Regions model.
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
     * Finds the Regions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Regions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Regions::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
