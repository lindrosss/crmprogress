<?php

namespace app\controllers;

use app\models\Sources;
use Yii;
use app\models\Vacancies;
use app\models\VacanciesSearch;
use app\models\Regions;
use app\models\Towns;
use app\models\Markets;
use app\models\VacancyMarket;
use app\models\Timetables;
use app\models\VacancySources;
use app\models\SourcesSearch;
use app\models\AddressesSearch;
use app\models\Addresses;
use app\models\Candidates;
use app\models\Forms;


use yii\web\Controller;
//use yii\web\NotFoundHttpException;
//use yii\filters\VerbFilter;

use yii\data\ActiveDataProvider;

use yii\helpers\ArrayHelper;

/**
 * VacanciesController implements the CRUD actions for Vacancies model.
 */
class VacanciesoperatorController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    /**
     * {@inheritdoc}
     */
	 /*
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
	*/

    /**
     * Lists all Vacancies models.
     * @return mixed
     */
    public function actionIndex()
    {
        $modelRegions = new Regions();
		$modelTowns = new Towns();
		$modelMarkets = new Markets();	
		$modelAddresses	= new Addresses();	
		
		$searchModel = new VacanciesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		$searchModelSources = new SourcesSearch();
		$dataProviderSources = $searchModelSources->search(Yii::$app->request->queryParams);
		
		$searchModelAddresses = new AddressesSearch();
		$dataProviderAddresses= $searchModelAddresses->search(Yii::$app->request->queryParams);
		
		if(isset($_GET['phone'])){
			$phone = $_GET['phone'];
		}else{
			$phone = '';
		}
		
		if(isset($_GET['sid'])){
			$sid = $_GET['sid'];
		}else{
			$sid = '';
		}
		
		if(isset($_GET['fio'])){
			$fio = $_GET['fio'];
		}else{
			$fio = '';
		}
		
		if(isset($_GET['age'])){
			$age = $_GET['age'];
		}else{
			$age = '';
		}

        if(isset($_GET['nation'])){
            $nation = $_GET['nation'];
        }else{
            $nation = '';
        }

        if(isset($_GET['source_info'])){
            $source_info = $_GET['source_info'];
        }else{
            $source_info = '';
        }

        $source_info_id = 0;

        $candidat_info = array();

        $candidat_info['isset'] = 0;

        $candidat_info['id_candidat'] = 0;
        $candidat_info['region'] = null;
        $candidat_info['town'] = null;
        $candidat_info['market'] = null;
        $candidat_info['vacancy']= null;
        $candidat_info['vacancy_market'] = null;
        $candidat_info['time_table'] = null;
        $candidat_info['candidat'] = null;
        $candidat_info['vacancy_source'] = null;

        $candidat_info['towns_list'] = array();
        $candidat_info['markets_list'] = array();
        $candidat_info['vacancyes_list'] = array();

        if(isset($_GET['id_candidat'])){
            $id_candidat = $_GET['id_candidat'];
            $candidat = Candidates::findOne($id_candidat);
            if($candidat){
                $time_table = Timetables::findOne($candidat->id_timetable);

                $vacancy_market = VacancyMarket::findOne($candidat->id_vacancy_in_market);
                $vacancy_source =  VacancySources::findOne($candidat->id_source);

                $market = Markets::findOne($vacancy_market->id_market);

                //return var_dump($time_table);

                $town = Towns::findOne($market->id_town);

                $region = Regions::findOne($town->region);

                $vacancy = Vacancies::findOne($vacancy_market->id_vacancy);

                $towns_list = Towns::find()->where('id_region='.$region->id)->all();
                $markets_list = Markets::find()->where('id_town='.$town->id)->all();
                //$vacancyes_list = $vacancy_market->vacancies; //Markets::find()->where('id_town='.$town->id)->all();

                $vacancyes_list = $this->getvakanciesbymarketsid($market->id);


                $candidat_info['isset'] = 1;
                $candidat_info['id_candidat'] = $id_candidat;
                $candidat_info['time_table'] = $time_table;
                $candidat_info['vacancy_market'] = $vacancy_market;
                $candidat_info['market'] = $market->id;
                $candidat_info['town'] = $town->id;
                $candidat_info['region'] = $region->id;
                $candidat_info['vacancy'] = $vacancy;
                $candidat_info['candidat'] = $candidat;
                $candidat_info['vacancy_source'] = $vacancy_source;


                $candidat_info['towns_list'] = $towns_list;
                $candidat_info['markets_list'] = $markets_list;
                $candidat_info['vacancyes_list'] = $vacancyes_list;

                $fio = $candidat->fio;
                $phone = $candidat->phone;
                $age = $candidat->age;
                $nation = $candidat->nation;

            }
        }else{
                $source = Sources::find()->where( ['name'=>$source_info])
                    ->asArray()
                    ->all();

                if(isset($source[0]['id'])){
                    $source_info_id = $source[0]['id'];
                }
        }



        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'searchModelSources' => $searchModelSources,
            'dataProviderSources' => $dataProviderSources,
			
			'searchModelAddresses' => $searchModelAddresses,
			'dataProviderAddresses' => $dataProviderAddresses,			
			
			'modelRegions' => $modelRegions,
			'modelTowns' => $modelTowns,
			'modelMarkets' => $modelMarkets,
			'modelAddresses' => $modelAddresses,
			'phone' => $phone,
			'sid' => $sid,
			'fio' => $fio,
			'age' => $age,
			'nation' => $nation,
            'source_info_id' => $source_info_id,

			'candidat_info' => $candidat_info
			//'queryParams' => var_dump(Yii::$app->request->queryParams),
        ]);
    }

    /**
     * Displays a single Vacancies model.
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
     * Creates a new Vacancies model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Vacancies();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
	
	/*Создание вакансии без редиректа*/
	public function actionCreatewithoutredirect()
    {
        $post = \Yii::$app->getRequest()->post();
		$model = new Vacancies();
		
		$model->name = $post['vacancy_name'];
		$model->info = $post['vacancy_info'];
		
		$model->id_updator = intval(Yii::$app->user->identity->id);
		$model->date_update = date('Y-m-d H:i:s');
		
        if ($model->save()) {
            return 1;
        }

		return 0;
    }
	
	/*Создание расписания для магазина без редиректа*/
	public function actionCreate_time_table_for_market()
    {
        $post = \Yii::$app->getRequest()->post();
		$model = new Timetables();
		
		$model->id_vacancy = 0;
		$model->id_market = $post['id_market'];
		$model->id_address = $post['id_address'];
		$model->date_interview = date('Y-m-d H:i:s', strtotime($post['date_interview']));
		$model->quota = $post['quota'];
		$model->is_public = 1;
		
		$model->id_updator = intval(Yii::$app->user->identity->id);
		$model->date_update = date('Y-m-d H:i:s');
		
        if ($model->save()) {
            return $post['id_market'];
        }

		return 0;
    }
	
	/*Создание расписания для магазина без редиректа*/
	public function actionCreate_time_table_for_vacancy()
    {
        $post = \Yii::$app->getRequest()->post();
		if(isset($post['id_vacancy'])){
			$model = new Timetables();
			
			$model->id_vacancy = $post['id_vacancy'];
			$model->id_market = 0;
			$model->id_address = $post['id_address'];
			$model->date_interview = date('Y-m-d H:i:s', strtotime($post['date_interview']));
			$model->quota = $post['quota'];
			$model->is_public = 1;
			
			$model->id_updator = intval(Yii::$app->user->identity->id);
			$model->date_update = date('Y-m-d H:i:s');
			
			if ($model->save()) {
				return $post['id_vacancy'];
			}
		}
		return 0;
    }

    /**
     * Updates an existing Vacancies model.
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

    /**
     * Deletes an existing Vacancies model.
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
     * Finds the Vacancies model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Vacancies the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Vacancies::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
	
	
	
	/*Сохранение или обновление данных по звонку на линию*/
	public function actionSaveform()
    {		
		
        $post = \Yii::$app->getRequest()->post();
		if(isset($post['sid'])){
			$sid = $post['sid'];
		}else {$sid = '';}
		
		if(isset($post['fio_candidat'])){
			$fio_candidat = $post['fio_candidat'];
		}else {$fio_candidat = '';}
		
		if(isset($post['phone_candidat'])){
			$phone_candidat = $post['phone_candidat'];
		}else {$phone_candidat = '';}
		
		if(isset($post['age_candidat'])){
			$age_candidat = $post['age_candidat'];
		}else {$age_candidat = '';}

        if(isset($post['nation_candidat'])){
            $nation_candidat = $post['nation_candidat'];
        }else {$nation_candidat = '';}
		
		if(isset($post['city_candidat'])){
			$city_candidat = $post['city_candidat'];
		}else {$city_candidat = '';}
		
		if(isset($post['region'])){
			$region = $post['region'];
		}else {$region = '';}
		
		if(isset($post['town'])){
			$town = $post['town'];
		}else {$town = '';}
		
		if(isset($post['market'])){
			$market = $post['market'];
		}else {$market = '';}
		
		if(isset($post['name_vacancy'])){
			$name_vacancy = $post['name_vacancy'];
		}else {$name_vacancy = '';}
		
		if(isset($post['comment'])){
			$comment = $post['comment'];
		}else {$comment = '';}
		
		if(isset($post['source'])){
			$source = $post['source'];
		}else {$source = '';}
				
		if(isset($post['method'])){
			$method = $post['method'];
		}else {$method = '';}

        if(isset($post['failure_client'])){
            $failure_client = $post['failure_client'];
        }else {$failure_client = '1';}

        if(isset($post['failure_fresh'])){
            $failure_fresh= $post['failure_fresh'];
        }else {$failure_fresh = '';}
		
		$data = Forms::find()->where('sid=:sid',
									  array(':sid'=> $sid)
									)->one();
		if($data){
			$method = 'updateform';
		}else{
			$method = 'saveform';
		}
		
		if($method == 'saveform'){
			$model = new Forms();
			
			$model->sid = $sid;
			$model->fio_candidat = $fio_candidat;	
			$model->phone_candidat = $phone_candidat;					  
			$model->age_candidat = $age_candidat;
            $model->nation_candidat = $nation_candidat;
			$model->city_candidat = $city_candidat;
			$model->region = $region;
			$model->town = $town;
			$model->market = $market;
			$model->name_vacancy = $name_vacancy;
			$model->comment = $comment.' new_model';
			$model->source = $source;
            $model->failure_client = $failure_client;
            $model->failure_fresh = $failure_fresh;

			$model->date_create = date('Y-m-d H:i:s');
			
			if ($model->save()) {
				return '<p style="color: Green;">Данные о звонке по вакансии успешно сохранены</p>';
						
			}else{
				return '<p style="color: Red;">Внимание! Данные о звонке НЕ сохранены.(Insert)</p>';
			}
		}elseif($method == 'updateform'){
				$model = $data;
								
				$model->fio_candidat = $fio_candidat;	
				$model->phone_candidat = $phone_candidat;					  
				$model->age_candidat = $age_candidat;
                $model->nation_candidat = $nation_candidat;
				$model->city_candidat = $city_candidat;
				$model->region = $region;
				$model->town = $town;
				$model->market = $market;
				$model->name_vacancy = $name_vacancy;
				$model->comment = $comment;
				$model->source = $source;
                $model->failure_client = $failure_client;
                $model->failure_fresh = $failure_fresh;
				$model->date_create = date('Y-m-d H:i:s');
			
			if ($model->save()) {
				return '<p style="color: Green;">Данные о звонке по вакансии успешно сохранены</p>';
			}else{
				return '<p style="color: Red;">Внимание! Данные о звонке НЕ сохранены.(Update) '.serialize($model->errors).'</p>';
			}
		}	
		else{
			return '<p style="color: Red;">Внимание! Ошибка сохранения данных о звонке. Не определен метод сохранения.</p>';
		}
		
    }
	
	
	/**
	 *Возвращает список городов по id_region
	 */
	public function actionGettownsbyregionid() {
        $data = Towns::find()->where('id_region=:id_region',
										array(':id_region'=>(int) $_POST['id_region'])
									)->all();
		$itemStr = '<option value="">Выберите город</option>';
		foreach($data as $item) {            
			$itemStr .='<option value="'.$item->id.'">'.$item->name.'</option>';
        }
		
		return $itemStr;        
    }
	
	/**
	 *Возвращает список магазинов по id_town
	 */
	public function actionGetmarketsbytownsid() {
        $data = Markets::find()->where('id_town=:id_town',
										array(':id_town'=>(int) $_POST['id_town'])
									)->all();
		$itemStr = '<option value="">Выберите магазин</option>';
		foreach($data as $item) {            
			$itemStr .='<option value="'.$item->id.'">'.$item->name.'</option>';
        }
		
		//echo var_dump($_POST['id_town']);
		
		return $itemStr;        
    }
	
	/**
	 *Возвращает список вакансий по id_market
	 */
	public function actionGetvakanciesbymarketsid() {
		if(isset($_POST['id_market'])){
			$id_market =(int) $_POST['id_market'];
			return $this->Getvakanciesbymarketsid($id_market);
		}else{
			return '<p style="color: Red;">Передан пустой POST-параметр</p>';
		}
		
        
    }
	
	/**
	 *Возвращает список источников информации по id_market
	 */
	public function actionGetsourcesbymarketsid() {
		if(isset($_POST['id_market'])){
			$id_market =(int) $_POST['id_market'];
           $selected_source =(int) $_POST['selected_source'];
			return $this->Getsourcesbymarketsid($id_market, $selected_source);
		}else{
			return '<p style="color: Red;">Передан пустой POST-параметр</p>';
		}
		
        
    }
	
	
	
	/**
	 *Возвращает список расписаний по id_market
	 */
	public function actionGettimetablesbymarketsid() {		
		if(isset($_POST['id_market'])) {
			$id_market = (int)$_POST['id_market'];
			return $this->Gettimetablesbymarketsid($id_market);
		}else{
			return '<p>Передан пустой POST-параметр</p>';
		}
    }
	
	public function actionGettimetablesbyvakancysid() {
		
		if(isset($_POST['id_vacancy'])) {
			$id_vacancy = (int)$_POST['id_vacancy'];
			return $this->Gettimetablesbyvakancysid($id_vacancy);
		}else{
			return '<p>Передан пустой POST-параметр</p>';
		}      
    }
	
	public function actionSetvacancytomarket() {
		$return = ['error'=>0, 'msg'=>''];
		if(isset($_POST['id_market']) && isset($_POST['id_vacancy'])){
			$id_market = $_POST['id_market'];
			$id_vacancy = $_POST['id_vacancy'];
			
			$model = new VacancyMarket();
			$model->id_market = $id_market;
			$model->id_vacancy = $id_vacancy;			
			$model->id_updator = intval(Yii::$app->user->identity->id);
			$model->date_create = date('Y-m-d H:i:s');
			if($model->save()){
				return $this->Getvakanciesbymarketsid($id_market);
			}else{	
				$return['error'] = '1';	
				$return['msg'] = 'Model not save';
			}	
		}else		
			{
				$return['error'] = '1';	
				$return['msg'] = 'POST parametrs is empty';
			}
		
		return json_encode($return);
	}

	/*Назначить Источник информации в Магазин*/
	public function actionSetsourcetomarket() {
		$return = ['error'=>0, 'msg'=>''];
		if(isset($_POST['id_market']) && isset($_POST['id_source'])){
			$id_market = $_POST['id_market'];
			$id_source = $_POST['id_source'];
			
			$model = new VacancySources();
			$model->id_vacancy = $id_market;
			$model->id_source = $id_source;			
			$model->id_updator = intval(Yii::$app->user->identity->id);
			$model->date_create = date('Y-m-d H:i:s');
			//return ''.var_dump($model);
			if($model->save()){
				return $this->Getsourcesbymarketsid($id_market);
			}else{	
				$return['error'] = '1';	
				$return['msg'] = 'Model not save';
				return var_dump($model->errors);
			}	
		}else		
			{
				$return['error'] = '1';	
				$return['msg'] = 'POST parametrs is empty';
				
				 
			}
		
		return json_encode($return);
	}	
	
	/*Удаление вакансии из списка вакансий Маркета*/
	public function actionDel_vacancy_from_market(){
		$return = ['error'=>0, 'msg'=>''];
		
		if(isset($_POST['id_row']) && isset($_POST['id_market'])){
			$VacancyMarket = VacancyMarket::findOne($_POST['id_row']);
			$VacancyMarket->delete();	
			
			
			$id_market =(int) $_POST['id_market'];
			return $this->Getvakanciesbymarketsid($id_market);
		}	
		else		
			{
				$return['error'] = '1';	
				$return['msg'] = 'POST parametrs is empty';
				return json_encode($return);
			}
		//Еще нужно удалить расписания на вакансию!!!!!!!!!!!!!!!!!!!!!!!!!!
		
	}

	/*Снимает с публикации расписания для Магазина*/
	public function actionUnpublish_timetable_market(){	
		if(isset($_POST['id_row_timetable']) && isset($_POST['id_market'])){
			$id_market = $_POST['id_market'];
			$model = Timetables::find()->where( ['id' => $_POST['id_row_timetable'] ])->one();
			if($model){
				$model->is_public = 0;
				$model->save();
				return $this->Gettimetablesbymarketsid($id_market);
			}
		}	
	}
	
	
	/*Снимает с публикации расписание для Вакансии*/
	public function actionUnpublish_timetable_vacancy(){	
		if(isset($_POST['id_row_timetable']) && isset($_POST['id_vacancy'])){
			$id_vacancy = $_POST['id_vacancy'];
			$model = Timetables::find()->where( ['id' => $_POST['id_row_timetable'] ])->one();
			if($model){
				$model->is_public = 0;
				$model->save();
				return $this->Gettimetablesbyvakancysid($id_vacancy);
			}
		}	else{
			return '<p>Передан пустой POST-параметр</p>';
		}
	}
	
	/*Удаляет расписание Магазина*/
	public function actionDelete_timetable_market(){	
		if(isset($_POST['id_row_timetable']) && isset($_POST['id_market'])){
			$id_market = $_POST['id_market'];
			$model = Timetables::find()->where( ['id' => $_POST['id_row_timetable'] ])->one();
			if($model){
				$model->delete();
				return $this->Gettimetablesbymarketsid($id_market);
			}
		}else{
			return '<p>Передан пустой POST-параметр</p>';
		}
	}
	
	/*Удаляет расписание Вакансии*/
	public function actionDelete_timetable_vacancy(){	
		if(isset($_POST['id_row_timetable']) && isset($_POST['id_vacancy'])){
			$id_vacancy = $_POST['id_vacancy'];
			$model = Timetables::find()->where( ['id' => $_POST['id_row_timetable'] ])->one();
			if($model){
				$model->delete();
				return $this->Gettimetablesbyvakancysid($id_vacancy);
			}
		}else{
			return '<p>Передан пустой POST-параметр</p>';
		}
	}
	
	/*Удаляет Источник информации Магазина*/
	public function actionDelete_source_market(){	
		if(isset($_POST['id_row_source']) && isset($_POST['id_market'])){
			$id_market = $_POST['id_market'];
			$model = VacancySources::find()->where( ['id' => $_POST['id_row_source'] ])->one();
			if($model){
				$model->delete();
				return $this->Getsourcesbymarketsid($id_market);
			}
		}else{
			return '<p>Передан пустой POST-параметр</p>';
		}
	}
	
	/*Создает кандидата на собеседование*/
	public function actionCreatecandidate()
    {
		$fio_candidat = $_POST['fio_candidat'];
		$phone_candidat = $_POST['phone_candidat'];
		$age_candidat = $_POST['age_candidat'];
        $nation = $_POST['nation'];

		$id_source = $_POST['id_source'];
		if(isset($_POST['comment'])){
			$comment = $_POST['comment'];
		}else{
			$comment = '';
		}
		$id_time_table = $_POST['id_time_table'];
		$id_vacancy_in_market = $_POST['id_vacancy_in_market'];
		
		$status = 1;
		if(isset($_POST['rezerv']) && $_POST['rezerv'] == 1){
			$status = 2;
		}
		
		$is_zum = 0;
		if(isset($_POST['is_zum']) && $_POST['is_zum'] == 1){
			$is_zum = 1;
		}

        $id_candidat= 0;
        if( isset($_POST['id_candidat']) ){
            $id_candidat = $_POST['id_candidat'];
        }


        $model = new Candidates();
			$model->fio = $fio_candidat;
			$model->phone = $phone_candidat;			
			$model->age = $age_candidat;
            $model->nation = $nation;
			$model->id_source = $id_source;			
			$model->comment = $comment;			
			$model->status = $status;			
			$model->id_timetable = $id_time_table;		
			$model->id_vacancy_in_market = 	$id_vacancy_in_market;
			$model->creator = 'operator';
			$model->date_create = date('Y-m-d H:i:s');
			//return ''.var_dump($model);
			if($model->save()){
			    if($id_candidat !=0) {
                    $old_candidat = Candidates::findOne($id_candidat);
                    if($old_candidat){
                        $old_candidat->status = 3;
                        $old_candidat->save();
                    }
			    }

				if($is_zum==1){
					return 2;
				}else{
					return 1;
				}
			}else{
				return var_dump($model->errors);
			}
	}	
	
	public function actionResetcandidate(){
		if(isset($_POST['id_candidate'])){
			if (($model = Candidates::findOne($_POST['id_candidate'])) !== null) {
				$model->status = 3;
				if($model->save()){
					return 1;
				}else{
					return 2;
				}
			}else{
				return 3;
			}
		}else{
			return 4;
		}
		
	}
	
	/*ФУНКЦИИ*/
	/*Возвращает список вакансий магазина*/
	public function Getvakanciesbymarketsid($id_market) {
		
		 $data = VacancyMarket::find()->where('id_market=:id_market AND status = 1', 
										array(':id_market'=>$id_market)
									)->all();
		
		$itemStr='<div>В данном магазине нет вакансий</div>';
		
		if($data){
			$itemStr = '<table id="vacancies_list_in_market" class="vacancy_list_table">';
			foreach($data as $item) { 
			
				//$itemStr .='<option value="'.$item->id.'">'.$item->name.'</option>';
				$itemStr .=	'<tr id_row="'.$item->id.'">';
					$itemStr .=	'<td id_row="'.$item->id.'" class="clickable name_vacancy">'.$item->vacancies->name.'</td>';
                    $itemStr .=	'<td id_row="'.$item->id.'" class="clickable ">'.$this->Gettimetablesbyvakancysid_short($item->id).'</td>';
              //  $itemStr .=	'<td id_row="'.$item->id.'" class="clickable name_vacancy">'.var_dump($item->vacancies).'</td>';
					$itemStr .=	'<td id_row="'.$item->id.'" class="clickable">'.$item->vacancies->info.'</td>';
					//$itemStr .=	'<td><a id_row="'.$item->id.'" class="btn btn-danger del_vacancy" onclick="return del_vakancy_from_market($(this))">Удалить</a></td>';
				$itemStr .=	'</tr>';	
				//echo var_dump($item->vacancies);
			}
			$itemStr .=	'</table>';
		
		}
		
		//$itemStr .= '<a class="btn btn-primary">Добавить</a>';
		return $itemStr;
	}	
	
	
	
	/*Возвращает список расписаний для магазина*/
	public function Gettimetablesbymarketsid($id_market) {
        $data = Timetables::find()->where('id_market=:id_market AND is_public = 1',
										array(':id_market'=>$id_market)
									)->all();
									
		$itemStr='<div>В данном магазине нет расписания собеседований</div>';		
		
		if($data){			
			$itemStr = '<table id="timetable_list_in_market" class="vacancy_list_table">';			
			$itemStr .=	'<tr class="head_tr">'.
							'<td>Дата собеседования</td>'.
							'<td>Квота</td>'.
							'<td>Адрес</td>'.
							'<td></td>'.
						'</tr>';
						;
				foreach($data as $item) {            				
					$rezerv = 0; //Записывать кандидатов в резерв (Нет)
					$label_btn = 'Открыть запись';
					$Candidates = Candidates::find()->where('id_timetable=:id_timetable AND	status = 1',
										array(':id_timetable'=>$item->id)
									)->all();
					$CandidatesCount = 	count($Candidates);		
					if(intval($item->quota) - $CandidatesCount == 0){
						$rezerv = 1; //Записывать кандидатов в резерв (Да)
						$label_btn = 'Открыть запись(в резерв)';
					}					
					
					$itemStr .=	'<tr>';
						$itemStr .=	'<td id_row="'.$item->id.'" class="date_timetable_in_market">'.date('d.m.Y H:i:s',strtotime($item->date_interview)).'</td>';
						$itemStr .=	'<td id_row="'.$item->id.'" class="quota_timetable_in_market">'.$item->quota.'('.$CandidatesCount.')</td>';
						$itemStr .=	'<td>'.$item->addressName.'</td>';
						$itemStr .=	'<td><a id_row="'.$item->id.'" class="btn btn-warning" onclick="open_create_candidat('.$item->id.', \'market\', '.$rezerv.')">'.$label_btn.'</a></td>';	
					$itemStr .=	'</tr>';						
				}
				$itemStr .=	'</table>';
			
		}
		return $itemStr;        
    }
	
	
	public function Gettimetablesbyvakancysid($id_vacancy) {
        $data = Timetables::find()->where('id_vacancy=:id_vacancy'.
										  ' AND is_public = 1 '.
										  //' AND DATE_FORMAT(date_interview, "%d-%m-%Y") >= date_format( DATE_ADD(now(), Interval 1 DAY), "%d-%m-%Y")', 
										 // ' AND date_interview >= DATE_ADD(now(), Interval 1 DAY)',
										 ' AND date_interview >= now()',
										array(':id_vacancy'=>$id_vacancy)
									)->all();
		
		$vacancy_model = VacancyMarket::find()->where('id=:id_vacancy', array(':id_vacancy'=>$id_vacancy))->one();
		$is_zum = 0;
		
		if( $vacancy_model &&
			isset($vacancy_model->vacanciesiszum) &&
			$vacancy_model->vacanciesiszum == 1
			){
			$is_zum = 1;
		}
		
									
		/*
		$itemStr = '<option value="">Выберите магазин</option>';*/
		$itemStr='<div>	<p> Для данной вакансии нет расписания собеседований</p>'. 
					'<a id_row="21" class="btn btn-warning" onclick="open_create_candidat(-1, \'vacancy\', 1, '.$is_zum.')">Открыть запись(в резерв)</a>'
				.'</div>';
		
		if($data){
			$itemStr = '<table id="timetable_list_in_vacancy" class="vacancy_list_table">';			
			$itemStr .=	'<tr class="head_tr">'.
							'<td>Дата собеседования</td>'.
							'<td>Квота</td>'.
							'<td>Адрес</td>'.
							'<td></td>'.
						'</tr>';
						;
				foreach($data as $item) {            				
					$rezerv = 0; //Записывать кандидатов в резерв (Нет)
					$label_btn = 'Открыть запись';
					$Candidates = Candidates::find()->where('id_timetable=:id_timetable AND	status = 1',
										array(':id_timetable'=>$item->id)
									)->all();
					$CandidatesCount = 	count($Candidates);		
					if(intval($item->quota) <= $CandidatesCount ){
						$rezerv = 1; //Записывать кандидатов в резерв (Да)
						$label_btn = 'Открыть запись(в резерв)';
					}					
					
					$itemStr .=	'<tr>';
						$itemStr .=	'<td id_row="'.$item->id.'" class="date_timetable_in_vacancy">'.date('d.m.Y H:i:s',strtotime($item->date_interview)).'</td>';
						$itemStr .=	'<td id_row="'.$item->id.'" class="quota_timetable_in_vacancy">'.$item->quota.'('.$CandidatesCount.')</td>';
						$itemStr .=	'<td id_row="'.$item->id.'" class="address_timetable_in_vacancy">'.$item->addressName.'</td>';
						$itemStr .=	'<td><a id_row="'.$item->id.'" class="btn btn-warning" onclick="open_create_candidat('.$item->id.', \'vacancy\', '.$rezerv.', '.$is_zum.')">'.$label_btn.'</a></td>';	
					$itemStr .=	'</tr>';						
				}
				$itemStr .=	'</table>';
		
		}
		return $itemStr;        
    }

    /*Возвращает краткие данные по расписаниям собеседований и квоту*/
    public function Gettimetablesbyvakancysid_short($id_vacancy) {
        $data = Timetables::find()->where('id_vacancy=:id_vacancy'.
            ' AND is_public = 1 '.
            //' AND DATE_FORMAT(date_interview, "%d-%m-%Y") >= date_format( DATE_ADD(now(), Interval 1 DAY), "%d-%m-%Y")',
            // ' AND date_interview >= DATE_ADD(now(), Interval 1 DAY)',
            ' AND date_interview >= now()',
            array(':id_vacancy'=>$id_vacancy)
        )->all();

        $vacancy_model = VacancyMarket::find()->where('id=:id_vacancy', array(':id_vacancy'=>$id_vacancy))->one();
        $is_zum = 0;

        if( $vacancy_model &&
            isset($vacancy_model->vacanciesiszum) &&
            $vacancy_model->vacanciesiszum == 1
        ){
            $is_zum = 1;
        }


        /*
        $itemStr = '<option value="">Выберите магазин</option>';*/
        $itemStr='<div>	<p> Нет раписаний</p></div>';
        /*
            '<a id_row="21" class="btn btn-warning" onclick="open_create_candidat(-1, \'vacancy\', 1, '.$is_zum.')">Открыть запись(в резерв)</a>'
            .'</div>';*/

        if($data){
            $itemStr = '<table id="timetable_list_in_vacancy_short" class="vacancy_list_table">';
            $itemStr .=	'<tr class="head_tr">'.
                '<td>Дата</td>'.
                '<td>Квота</td>'.

                '</tr>';
            ;
            foreach($data as $item) {
               // $rezerv = 0; //Записывать кандидатов в резерв (Нет)
              //  $label_btn = 'Открыть запись';
                $Candidates = Candidates::find()->where('id_timetable=:id_timetable AND	status = 1',
                    array(':id_timetable'=>$item->id)
                )->all();
                $CandidatesCount = 	count($Candidates);
                if(intval($item->quota) <= $CandidatesCount ){
                    $rezerv = 1; //Записывать кандидатов в резерв (Да)
                    $label_btn = 'Открыть запись(в резерв)';
                }

                $itemStr .=	'<tr>';
                $itemStr .=	'<td id_row="'.$item->id.'" class="date_timetable_in_vacancy">'.date('d.m.Y H:i:s',strtotime($item->date_interview)).'</td>';
                $itemStr .=	'<td id_row="'.$item->id.'" class="quota_timetable_in_vacancy">'.$item->quota.'('.$CandidatesCount.')</td>';
               $itemStr .=	'</tr>';
            }
            $itemStr .=	'</table>';

        }
        return $itemStr;
    }
	
	/*Возвращает список источников информации магазина*/
	public function Getsourcesbymarketsid($id_market, $selected_source) {
		
		 $data = VacancySources::find()->where('id_vacancy=:id_market AND is_public = 1',
										array(':id_market'=>$id_market)
									)->all();
		/*
		$itemStr = '<option value="">Выберите магазин</option>';*/
		$itemStr='<div>В данном магазине нет источников информации</div>';
		
		if($data){
			$itemStr = '<select id="sources_list_in_market">';
							$itemStr .=	'<option value="0">Выбрать источник</option>';
			foreach($data as $item) {
                $sel = $item->id_source == $selected_source ? ' selected' : '';
				$itemStr .=	'<option value="'.$item->id.'"'. $sel.'>'.$item->sourceName.'</option>';
			}
			$itemStr .=	'</select>';			
		}		
		
		return $itemStr;
	}	
	
	
	
}
