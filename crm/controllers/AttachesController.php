<?php

namespace app\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

use app\models\Attaches;
use app\models\UploadForm;
use yii\web\UploadedFile;

class AttachesController extends \yii\web\Controller
{
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
                        'actions' => ['index', 'update', 'view', 'viewcompany'],
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

    public function actionIndex()
    {
        return $this->render('index');
    }

    // ОТКЛЮЧАЕМ CSRF
    /*
    public function beforeAction($action)
    {
        if ($action->id === 'myFunction') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }*/

    public function actionUpload()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {

            $post = Yii::$app->request->post();
            if(!isset($post['task_id'])){
                return 'Ошибка при загрузке файла [1]';
            }
            $model->task_id = $post['task_id'];
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
           // return var_dump($model);
            //return $model->upload();

            $res_upload = $model->upload();
            if ($res_upload === true) {
                return 'ok';
            }else{
                return $res_upload;
            }
        }
    }

    public function actionDownloadfile() {
        $post = Yii::$app->request->get();
        if(isset($post['sfile']) && isset($post['file'])) {
            $file = '../uploads/'.$post['sfile'];
            if (file_exists($file)) {
                // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
                // если этого не сделать файл будет читаться в память полностью!
                if (ob_get_level()) {
                    ob_end_clean();
                }
                // заставляем браузер показать окно сохранения файла
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename=' . $post['file']);
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file));
                // читаем файл и отправляем его пользователю
                if ($fd = fopen($file, 'rb')) {
                    while (!feof($fd)) {
                        print fread($fd, 1024);
                    }
                    fclose($fd);
                }
                exit;
            }else{
                return 'Файл не найден на сервере';
            }
        }else{
            return 'Не указано имя файла';
        }
    }

    /*Запасной вариант отдачи файла. Но хз как работает X-SendFile:*/
    public function actionDownloadfile_1() {
        $post = Yii::$app->request->get();
        if(isset($post['sfile']) && isset($post['file'])){
            $file = '../uploads/'.$post['sfile'];
            if (file_exists($file)) {
                header('X-SendFile: ' . realpath($file));
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename=' . $post['file']);
                exit;
            }else{
                return 'Файл не найден на сервере';
            }
        }else{
            return 'Не указано имя файла';
        }
    }

    public function actionDeleteattache(){
        $post = Yii::$app->request->post();
        if(isset($post['sfile']) && isset($post['id_attache']) ){
            $file = '../uploads/'.$post['sfile'];
            if (unlink($file) ){
                $attache = Attaches::findOne($post['id_attache']);
                if($attache){
                    $attache->delete();
                    return 'ok';
                }else{
                    return 'Файл не найден в БД';
                }
            }else{
                return 'Не удалось удалить файл';
            }
        }else{
            return 'Не указано имя файла или номер вложения';
        }
    }

    /*Вывод списка файлов Задачи*/
    public function actionRenderattaches(){
        $post = Yii::$app->request->post();
        if(isset($post['id_task']) ){
            $attaches = Attaches::find()
                ->where(['id_task'=>$post['id_task']])
                ->asArray()
                ->all();

            return $this->renderPartial('../companies/part_attaches_list_files', [
                'attaches' => $attaches,
                'task_id' => $post['id_task']
            ]);
        }else{
            return 'Не указан номер задачи';
        }
    }



    protected function findModel($id)
    {
        if (($model = Attaches::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
