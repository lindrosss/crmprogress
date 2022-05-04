<?php

namespace app\controllers;

use Yii;
use app\models\Tasks;
use app\models\TasksSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TasksController implements the CRUD actions for Tasks model.
 */
class TasksController extends Controller
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
     * Lists all Tasks models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TasksSearch();
        $params = Yii::$app->request->queryParams;
        if(isset($params['TasksSearch']['date_task'])) {
            $date_task_search = $params['TasksSearch']['date_task'];
        }else{
            $date_task_search = '';
        }

        if(isset($params['TasksSearch']['responsible_usr'])) {

            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }else{
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity->id);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'date_task_search' => $date_task_search,
        ]);
    }

    /**
     * Displays a single Tasks model.
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
     * Creates a new Tasks model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tasks();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionCreate_without_redirect()
    {
        $model = new Tasks();

        $post = Yii::$app->request->post();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return 'ok';
        }else{
            return var_dump(Yii::$app->request->post());
        }
    }

    /**
     * Updates an existing Tasks model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        if($model->date_task){
            $model->date_task = date('Y-m-d', strtotime($model->date_task));
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /*Обновление поля Задачи*/
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
                        return 'Ошибка. Не удалось сохранить Задачу '.serialize($model->errors);
                    }
                }else{
                    return 'Ошибка. Поле Задачи не найдено';
                }
            }else{
                return 'Ошибка. Не найдена Задача';
            }
        }else{
            return 'Ошибка. Не указаны параметры';
        }
    }

    /**
     * Deletes an existing Tasks model.
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
     * Finds the Tasks model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tasks the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tasks::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
