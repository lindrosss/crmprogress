<?php

namespace app\controllers;

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
use app\models\Sources;


use yii\web\Controller;
//use yii\web\NotFoundHttpException;
//use yii\filters\VerbFilter;

use yii\data\ActiveDataProvider;

use yii\helpers\ArrayHelper;

/**
 * VacanciesController implements the CRUD actions for Vacancies model.
 */
class VacanciesController extends \yii\web\Controller
{
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
	
	public function actionUpdatewithoutredirect()
    {
		if(isset($_POST['vacancy_name']) && isset($_POST['vacancy_info']) && isset($_POST['id_vacancy'])){
			 if (($model = Vacancies::findOne($_POST['id_vacancy'])) !== null) {
				 $model->name = $_POST['vacancy_name'];
				 $model->info = $_POST['vacancy_info'];
				 if($model->save()){
					 return 1;				 
				 }else{
					return 3;	
				}	
			 }else{
				return 2;	
			}	
			
		}else{
			return 0;	
		}
	}

	public function actionDeletewithoutredirect()
    {
		if(isset($_POST['id_vacancy'])){	
			
			if (($model = Vacancies::findOne($_POST['id_vacancy'])) !== null) {
				//$model->delete();

                $model->is_public = 0;
                $model->save();
				return 1;
			}else{
				return 2;
		}		
		}else{
			return 0;
		}	
    }	
	
	public function actionUpdatetimetablewithoutredirect()
    {
		if(isset($_POST['id_vacancy']) && 
		   isset($_POST['id_timetable']) && 
		   isset($_POST['date_interview']) && 
		   isset($_POST['quota']) && 
		   isset($_POST['id_address'])
		   ){
			 if (($model = Timetables::findOne($_POST['id_timetable'])) !== null) {
				 $model->date_interview = date('Y-m-d H:i:s',strtotime($_POST['date_interview']));
				 $model->quota = $_POST['quota'];
				 $model->id_address = $_POST['id_address'];
				 if($model->save()){
					 return $_POST['id_vacancy'];				 
				 }else{
					return -3;	
				}	
			 }else{
				return -2;	
			}	
			
		}else{
			return 0;	
		}
	}
	
	public function actionDeletesourcewithoutredirect()
    {
		if(isset($_POST['id_source'])){	
			
			if (($model = Sources::findOne($_POST['id_source'])) !== null) {
				$model->delete();
				return 1;
			}else{
				return 2;
		}		
		}else{
			return 0;
		}	
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
	
	
	
	
	
	/**
	 *Возвращает список городов по id_region
	 */
	public function actionGettownsbyregionid() {
        if(isset($_POST['id_region'])) {
            $data = Towns::find()->where('id_region=:id_region',
                array(':id_region' => (int)$_POST['id_region'])
            )->all();
            $itemStr = '<option value="">Выберите город</option>';
            foreach ($data as $item) {
                $itemStr .= '<option value="' . $item->id . '">' . $item->name . '</option>';
            }

            return $itemStr;
        }else{
            return '<option>Ошибка получения списка городов</option>';
        }
    }
	
	/**
	 *Возвращает список магазинов по id_town
	 */
	public function actionGetmarketsbytownsid() {
	    if(isset($_POST['id_town'])) {
            $data = Markets::find()->where('id_town=:id_town',
                array(':id_town' => (int)$_POST['id_town'])
            )->all();
            $itemStr = '<option value="">Выберите магазин</option>';
            foreach ($data as $item) {
                $itemStr .= '<option value="' . $item->id . '">' . $item->num_market . ' ' . $item->name . '</option>';
            }

            //echo var_dump($_POST['id_town']);

            return $itemStr;
        }else{
	        return '<option>Ошибка получения списка магазинов</option>';
        }
    }
	
	/**
	 *Возвращает список вакансий по id_market
	 */
	public function actionGetvakanciesbymarketsid() {
		if(isset($_POST['id_market'])){
			$id_market =(int) $_POST['id_market'];
			return $this->Getvakanciesbymarketsid($id_market);
		}else{
			return '<p>Передан пустой POST-параметр</p>';
		}
		
        
    }
	
	/**
	 *Возвращает список источников информации по id_market
	 */
	public function actionGetsourcesbymarketsid() {
		if(isset($_POST['id_market'])){
			$id_market =(int) $_POST['id_market'];
			return $this->Getsourcesbymarketsid($id_market);
		}else{
			return '<p>Передан пустой POST-параметр</p>';
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
			$model->date_create = date("Y-m-d H:i:s");
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
			//$VacancyMarket->delete();	
			$VacancyMarket->status = 0;
			if($VacancyMarket->save()){
			
				$id_market =(int) $_POST['id_market'];
				return $this->Getvakanciesbymarketsid($id_market);
			}else{
				$return['error'] = '2';	
				$return['msg'] = 'model not save';
				return json_encode($return);
			}
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
				//$model->delete();
				$model->is_public=0;
				$model->save();
				return $this->Getsourcesbymarketsid($id_market);
			}
		}else{
			return '<p>Передан пустой POST-параметр</p>';
		}
	}
	
	public function actionGetdatavacancy(){	
		$return = ['error'=>0, 'msg'=>''];
		
		if(isset($_POST['id_vacancy'])){
			if (($model = Vacancies::findOne($_POST['id_vacancy'])) !== null) {
				$return['name'] = $model->name;
				$return['info'] = $model->info;
				$return['id'] = $model->id;
			}else{
				$return['error'] = '2';	
				$return['msg'] = 'model NOT found';
			}
		}else{
			$return['error'] = '1';	
			$return['msg'] = 'POST parametrs is empty';
		}
		
		return json_encode($return);
	}
	
	public function actionGetdatatimetablevacancy(){	
		$return = ['error'=>0, 'msg'=>''];
		
		if(isset($_POST['id_timetable'])){
			if (($model = Timetables::findOne($_POST['id_timetable'])) !== null) {
				$return['date_interview'] = date('d-m-Y H:i',strtotime($model->date_interview));
				$return['id_address'] = $model->id_address;
				$return['quota'] = $model->quota;
				$return['id'] = $model->id;
			}else{
				$return['error'] = '2';	
				$return['msg'] = 'model NOT found';
			}
		}else{
			$return['error'] = '1';	
			$return['msg'] = 'POST parametrs is empty';
		}
		
		return json_encode($return);
	}
	
	/*ФУНКЦИИ*/
	/*Возвращает список вакансий магазина*/
	public function Getvakanciesbymarketsid($id_market) {
		
		 $data = VacancyMarket::find()->where('id_market=:id_market AND status = 1',
										array(':id_market'=>$id_market)
									)->all();
		/*
		$itemStr = '<option value="">Выберите магазин</option>';*/
		$itemStr='<div>В данном магазине нет вакансий</div>';
		
		if($data){
			$itemStr = '<table id="vacancies_list_in_market" class="vacancy_list_table">';
			foreach($data as $item) {            
			
				//$itemStr .='<option value="'.$item->id.'">'.$item->name.'</option>';
				$itemStr .=	'<tr id_row="'.$item->id.'">';
					$itemStr .=	'<td id_row="'.$item->id.'" class="clickable">'.$item->vacancies->name.'</td>';
				//	$itemStr .=	'<td id_row="'.$item->id.'" class="clickable">'.$item->vacancies->info.'</td>';
					$itemStr .=	'<td ><a id_row="'.$item->id.'" class="btn btn-danger del_vacancy" onclick="return del_vakancy_from_market($(this))">Удалить</a></td>';
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
		/*
		$itemStr = '<option value="">Выберите магазин</option>';*/
		
		
		
		$itemStr='<div>В данном магазине нет расписания собеседований</div>';		
		
		if($data){
			
			$itemStr = '<table id="timetable_list_in_market" class="vacancy_list_table">';
			//echo var_dump($data);	
			$itemStr .=	'<tr class="head_tr">'.
							'<td>Дата собеседования</td>'.
							'<td>Квота</td>'.
							'<td>Адрес</td>'.
							'<td></td>'.
							//'<td></td>'.
						'</tr>';
						;
				foreach($data as $item) {            
					//$itemStr .='<option value="'.$item->id.'">'.$item->name.'</option>';
					$itemStr .=	'<tr>';
						$itemStr .=	'<td>'.date('d.m.Y H:i:s',strtotime($item->date_interview)).'</td>';
						$itemStr .=	'<td>'.$item->quota.'</td>';
						$itemStr .=	'<td>'.$item->addressName.'</td>';
						$itemStr .=	'<td><a id_row="'.$item->id.'" class="btn btn-warning del_vacancy" onclick="unpublish_timetable_market($(this))">Скрыть</a></td>';
						//$itemStr .=	'<td><a id_row="'.$item->id.'" class="btn btn-danger del_vacancy" onclick="delete_timetable_market($(this))">Удалить</a></td>';
					$itemStr .=	'</tr>';	
					//echo var_dump($item->vacancies);
				}
				$itemStr .=	'</table>';
			
		}
		return $itemStr;        
    }
	
	public function Gettimetablesbyvakancysid($id_vacancy) {
        $data = Timetables::find()->where('id_vacancy=:id_vacancy AND is_public = 1',
										array(':id_vacancy'=>$id_vacancy)
									)->all();
		/*
		$itemStr = '<option value="">Выберите магазин</option>';*/
		$itemStr='<div>Для данной вакансии нет расписания собеседований</div>';
		
		if($data){
			$itemStr = '<table id="timetable_list_in_vacancy" class="vacancy_list_table">';
			$itemStr .=	'<tr class="head_tr">'.
							'<td>Дата собеседования</td>'.
							'<td>Квота</td>'.
							'<td>Адрес</td>'.
							'<td></td>'.
							'<td></td>'.
							//'<td></td>'.
						'</tr>';
						;
			foreach($data as $item) {            
				//$itemStr .='<option value="'.$item->id.'">'.$item->name.'</option>';
				$itemStr .=	'<tr id_row="'.$item->id.'">';
					$itemStr .=	'<td>'.$item->date_interview.'</td>';
					$itemStr .=	'<td>'.$item->quota.'</td>';
					$itemStr .=	'<td>'.$item->addressName.'</td>';
					$itemStr .=	'<td><a id_row="'.$item->id.'" class="btn btn-warning del_vacancy" onclick="edit_timetable_vacancy('.$item->id.')">Редактировать</a></td>';					
					//$itemStr .=	'<td><a id_row="'.$item->id.'" class="btn btn-danger del_vacancy" onclick="delete_timetable_vacancy($(this))">Удалить</a></td>';
					$itemStr .=	'<td><a id_row="'.$item->id.'" class="btn btn-warning del_vacancy" onclick="unpublish_timetable_vacancy($(this))">Скрыть</a></td>';
				$itemStr .=	'</tr>';	
				//echo var_dump($item->vacancies);
			}
			$itemStr .=	'</table>';
		
		}
		return $itemStr;        
    }
	
	/*Возвращает список источников информации магазина*/
	public function Getsourcesbymarketsid($id_market) {
		
		 $data = VacancySources::find()->where('id_vacancy=:id_market AND is_public = 1',
										array(':id_market'=>$id_market)
									)->all();
		/*
		$itemStr = '<option value="">Выберите магазин</option>';*/
		$itemStr='<div>В данном магазине нет источников информации</div>';
		
		if($data){
			$itemStr = '<table id="sources_list_in_market" class="vacancy_list_table">';
			foreach($data as $item) {            
				//$itemStr .='<option value="'.$item->id.'">'.$item->name.'</option>';
				$itemStr .=	'<tr id_row="'.$item->id.'">';
					$itemStr .=	'<td id_row="'.$item->id.'" class="clickable">'.
						$item->sourceName.'</td>';
					//$itemStr .=	'<td id_row="'.$item->id.'" class="clickable">'.$item->vacancies->info.'</td>';
					$itemStr .=	'<td><a id_row="'.$item->id.'" class="btn btn-danger del_vacancy" onclick="delete_source_from_market($(this))">Удалить</a></td>';
				$itemStr .=	'</tr>';	
				//echo var_dump($item->vacancies);
			}
			$itemStr .=	'</table>';
		
		}
		
		//$itemStr .= '<a class="btn btn-primary">Добавить</a>';
		return $itemStr;
	}

	/*Возвращает РМ магазина*/
	public function actionGet_rm(){
        if(isset($_POST['id_market'])){

            $market = Markets::findOne($_POST['id_market']);

            if($market){
                return $market->rm;
            }else{
                return "Магазин не найден";
            }


        }else{
            return "Не указан ID магазина";
        }

    }





	/*Загрузчик вакансий из файла*/
	public function actionLoad_vakansyes(){
	   // $path = 'C:/xampp/htdocs/upload/files/Fresh_markets.xlsx';
        $path = '/var/www/html/upload/files/Fresh_markets.xlsx';

        require_once Yii::getAlias('@vendor').'/Classes/PHPExcel/IOFactory.php';

        $objPHPExcel = \PHPExcel_IOFactory::load($path);
        $workSheet = $objPHPExcel->getSheet(0);

        $highestRow = $workSheet->getHighestRow(); // e.g. 10

        $markets = array();

        $errors = array();

        $cnt_is_ok = 0;

        for ($row = 2; $row <= $highestRow; ++ $row) {


            $market_name = $workSheet->getCell("A".$row)->getValue();



            $market = Markets::find()
                ->where(['name' => $market_name])
                ->one();

            if($market){
                $markets[] = $market->name;

                $vakancy_name = $workSheet->getCell("D".$row)->getValue();
                $vakancy_info = $workSheet->getCell("E".$row)->getValue();

                if($vakancy_name !='' && $vakancy_info != ''){
                    $vakancy = new Vacancies();
                    $vakancy->name = $vakancy_name;
                    $vakancy->info = $vakancy_info;
                    $vakancy->id_updator = 1100;
                    $vakancy->date_update = date('Y-m-d H:i:s');

                    if($vakancy->save()){
                          //return $vakancy->id;
                        $vakancy_market = new VacancyMarket();
                        $vakancy_market->id_market = $market->id;
                        $vakancy_market->id_vacancy = $vakancy->id;
                        $vakancy_market->id_updator = 1100;
                        $vakancy_market->status = 1;
                        $vakancy_market->date_create = date('Y-m-d H:i:s');

                        if($vakancy_market->save()){
                            $cnt_is_ok ++;
                        }else{
                            //return serialize($vakancy_market->errors);
                            $errors[] = 'Ошибка сохранения привязки вакансии к магазину: ('.$row.') '.serialize($vakancy_market->errors);
                        }
                    }else{
                        //return serialize($vakancy->errors);
                        $errors[] = 'Ошибка сохранения вакансии: ('.$row.') '.serialize($vakancy->errors);
                    }
                }else{
                    $errors[] = 'Пустое имя или описание вакансии: ('.$row.')';
                }



                //$vakancy_market->

            }else{
                //$markets[] = 'Not find: ('."A".$row.')'.$market_name;
                $errors[] = 'Not find Market: ('."A".$row.')'.$market_name;
            }


        }

       // return '<p>'.json_encode($markets, JSON_UNESCAPED_UNICODE).'</p>';
        $return = '<p> Найдено вакансий в файле: '.($highestRow - 1).'</p>';

        $return .= '<p> Создано вакансий: '.$cnt_is_ok.'</p>';

        if(count($errors)>0){
            $return .= '<p>Ошибки:</p>';
            foreach ($errors as $item){
                $return .= '<p>'.$item.'</p>';
            }
        }

        return $return;
    }



}
