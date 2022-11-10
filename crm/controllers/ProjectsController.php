<?php

namespace app\controllers;

use Yii;
use app\models\Projects;
use app\models\ProjectsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ProjectsController implements the CRUD actions for Projects model.
 */
class ProjectsController extends Controller
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
                        'actions' => ['index', 'update', 'view'],
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
     * Lists all Projects models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProjectsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Projects model.
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
     * Creates a new Projects model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Projects();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionCreate_without_redirect()
    {
        $post = Yii::$app->request->post();
        $model = new Projects();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return 'ok';
            //return $this->redirect(['companies/update', 'id' => $post['Projects']['id_company']]);

        }else{
            return var_dump(Yii::$app->request->post());
        }
    }

    /**
     * Updates an existing Projects model.
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

    /*Обновление поля Проекта*/
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
                        return 'Ошибка. Не удалось сохранить Проект '.serialize($model->errors);
                    }
                }else{
                    return 'Ошибка. Поле Проекта не найдено';
                }
            }else{
                return 'Ошибка. Не найден Проект';
            }
        }else{
            return 'Ошибка. Не указаны параметры запроса';
        }
    }

    /**
     * Deletes an existing Projects model.
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
     * Finds the Projects model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Projects the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Projects::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
