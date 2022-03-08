<?php

namespace app\controllers;

use Yii;
use app\models\Companies;
use app\models\CompaniesSearch;
use app\models\ContactsSearch;
use app\models\Contacts;
use app\models\Projects;
use app\models\Tasks;
use app\models\ProjectsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;

/**
 * CompaniesController implements the CRUD actions for Companies model.
 */
class CompaniesController extends Controller
{
    public $enableCsrfValidation = false;
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


    /**
     * Lists all Companies models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CompaniesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Companies model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
		$contacts = Contacts::find()
		 ->Where(['=','id_company' , $id])
		 ->all();
		
        return $this->render('view', [
            'model' => $this->findModel($id),
			'contacts' => $contacts
        ]);
    }

    /**
     * Creates a new Companies model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Companies();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id]);
			return $this->redirect(['index', []]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Companies model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
		//echo var_dump(Yii::$app->request->post());
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id]);
			//$this->actionIndex();
			return $this->redirect(['index', []]);
        }

		/**/
		$searchModelContacts = new ContactsSearch();
        $dataProviderContacts = $searchModelContacts->search(Yii::$app->request->queryParams, $id );

        $searchModelProjects = new ProjectsSearch();
        $dataProviderProjects = $searchModelProjects->search(Yii::$app->request->queryParams, $id );
       
		/**/

        return $this->render('update', [
            'model' => $model,			
			'searchModelContacts' => $searchModelContacts,
            'dataProviderContacts' => $dataProviderContacts,

            'searchModelProjects' => $searchModelProjects,
            'dataProviderProjects' => $dataProviderProjects,
        ]);
    }

    public function actionViewcompany($id)
    {
        //echo var_dump(Yii::$app->request->post());
        $company = $this->findModel($id);

        $projects = $company->getCompany_projects();
        $contacts = $company->getCompany_contacts();

        /*
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', []]);
        }*/

        /**/
        $searchModelContacts = new ContactsSearch();
        $dataProviderContacts = $searchModelContacts->search(Yii::$app->request->queryParams, $id );

        $searchModelProjects = new ProjectsSearch();
        $dataProviderProjects = $searchModelProjects->search(Yii::$app->request->queryParams, $id );

        /**/

        return $this->render('veiw_company', [
            'model' => $company,
            'company' => $company,
            'projects' => $projects,
            'contacts' => $contacts,

            'searchModelContacts' => $searchModelContacts,
            'dataProviderContacts' => $dataProviderContacts,

            'searchModelProjects' => $searchModelProjects,
            'dataProviderProjects' => $dataProviderProjects,
        ]);
    }

    public function actionGet_contacts_part(){
        $post = Yii::$app->request->post();

        if(isset($post['company_id'])){
            $company = $this->findModel($post['company_id']);
            $contacts = $company->getCompany_contacts();

            return \Yii::$app->view->renderFile('@app/views/companies/part_contacts.php', [
                'contacts' => $contacts,
                ]);
        }else{
            return '<p>Ошибка отображения контактов</p>';
        }
    }

    public function actionGet_projects_part(){
        $post = Yii::$app->request->post();

        if(isset($post['company_id'])){
            $company = $this->findModel($post['company_id']);
            $projects = $company->getCompany_projects();

            return \Yii::$app->view->renderFile('@app/views/companies/part_projects.php', [
                'projects' => $projects,
            ]);
        }else{
            return '<p>Ошибка отображения контактов</p>';
        }
    }

    public function actionGet_tasks_part(){
        //return '-';
        $post = Yii::$app->request->post();

        if(isset($post['id_project'])){
            //$company = $this->findModel($post['id_project']);
            $tasks = Tasks::find()
                ->where(['id_project' =>$post['id_project']])
                ->all();


            return \Yii::$app->view->renderFile('@app/views/companies/part_tasks.php', [
                'tasks' => $tasks,
            ]);
        }else{
            return '-';
        }
    }

    /**
     * Deletes an existing Companies model.
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
     * Finds the Companies model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Companies the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Companies::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
