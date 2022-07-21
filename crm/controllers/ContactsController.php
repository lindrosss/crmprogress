<?php

namespace app\controllers;

use Yii;
use app\models\Contacts;
use app\models\ContactsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ContactsController implements the CRUD actions for Contacts model.
 */
class ContactsController extends Controller
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

            'access' => [
                'class' => AccessControl::class,
                // 'only' => ['login', 'logout', 'signup'],
                'denyCallback' => function () {
                    die('Доступ запрещен!');
                },

                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'signup'],
                        'roles' => ['?'],
                    ],

                    [
                        'allow' => false,
                        'actions' => ['index', 'update', 'view', 'update_without_redirect'],
                        'roles' => ['?'],
                    ],

                    [
                        'allow' => true,
                        //'actions' => ['logout', 'index', /*'update'*/],
                        'roles' => ['@'],
                    ],
                ],
            ],

        ];
    }

    /**
     * Lists all Contacts models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ContactsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Contacts model.
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
     * Creates a new Contacts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Contacts();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

		$get = Yii::$app->request->get();
		$model->id_company = $get['id_company'];
		
		
        return $this->render('create', [
            'model' => $model,			
        ]);
    }
	
	public function actionCreate_without_redirect()
    {
        $post = Yii::$app->request->post();
       // return var_dump($post['Contacts']);
		$model = new Contacts();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return 'ok';
            return $this->redirect(['companies/update', 'id' => $post['Contacts']['id_company']]);
        }else{
            return var_dump(Yii::$app->request->post());
        }
	}

    /**
     * Updates an existing Contacts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /*Обновление поля контакта*/
    public function actionUpdate_field()
    {
        $post = Yii::$app->request->post();
        if(isset($post['id']) && isset($post['field_name'])&& isset($post['value']) ){
            $model = $this->findModel($post['id']);
            if($model){
                $field_name = $post['field_name'];
                //return var_dump($post['field_name']);
                if(isset($model->$field_name) ) {
                    $model->$field_name = $post['value'];
                    if ($model->save()){
                        return 'ok';
                    }else{
                        return 'Ошибка. Не удалось сохранить контакт';
                    }
                }else{
                    return 'Ошибка. Параметр контакта не найден';
                }
            }else{
                return 'Ошибка. Не найден контакт';
            }
        }else{
            return 'Ошибка. Не указаны параметры';
        }
    }
	
	public function actionUpdate_without_redirect()
    {
		
	}	

    /**
     * Deletes an existing Contacts model.
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
     * Finds the Contacts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Contacts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Contacts::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
