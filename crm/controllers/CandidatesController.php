<?php

namespace app\controllers;

use Yii;
use app\models\Candidates;
use app\models\CandidatesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CandidatesController implements the CRUD actions for Candidates model.
 */
class CandidatesController extends Controller
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
     * Lists all Candidates models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CandidatesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		if(isset($_GET['hide_menu']) && $_GET['hide_menu'] == 1){
			$hide_menu = 1;	
		}else{
			$hide_menu = 0;	
		}		

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'hide_menu' => $hide_menu,
        ]);
    }

    /**
     * Displays a single Candidates model.
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
     * Creates a new Candidates model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Candidates();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Candidates model.
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
     * Deletes an existing Candidates model.
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
     * Finds the Candidates model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Candidates the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Candidates::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionLoad_candidates(){
        $connection = $this->getConnection('sql.ad.kellykc.ru', 'fresh_market', 'fresh_user', 'Se3FvyxpwD34^v');

        $sql="select

   ROW_NUMBER() OVER (ORDER BY c.id) AS num		
  ,r.name as region
  ,t.name as town
  ,m.name as market
  ,DATE_FORMAT(tt.date_interview, '%d.%m.%Y ') as day_inerview
  ,CASE
      WHEN DAYOFWEEK(tt.date_interview) = 1 THEN 'Воскресенье'
      WHEN DAYOFWEEK(tt.date_interview) = 2 THEN 'Понедельник'
      WHEN DAYOFWEEK(tt.date_interview) = 3 THEN 'Вторник'
      WHEN DAYOFWEEK(tt.date_interview) = 4 THEN 'Среда'
      WHEN DAYOFWEEK(tt.date_interview) = 5 THEN 'Четверг'
      WHEN DAYOFWEEK(tt.date_interview) = 6 THEN 'Пятница'
      WHEN DAYOFWEEK(tt.date_interview) = 7 THEN 'Суббота'
      
      ELSE 'Не определен'
    END  AS day_of_week_interview
  ,DATE_FORMAT(tt.date_interview, '%H:%i:%s') as time_inerview
  , c.date_create
  ,c.fio
  ,c.phone
  ,v.name as name_vacancy
  ,a.name as pace_interview  
  ,c.comment
  ,s.name as source
  ,c.status
  ,c.nation

  
  
from fresh_market.candidates as c
  LEFT JOIN fresh_market.vacancy_market as vm on c.id_vacancy_in_market = vm.id
  LEFT JOIN fresh_market.timetables as tt on c.id_timetable = tt.id
  LEFT JOIN fresh_market.vacancies as v on v.id = vm.id_vacancy
  LEFT JOIN fresh_market.addresses as a on a.id = tt.id_address
  LEFT JOIN fresh_market.markets as m on m.id = vm.id_market
  LEFT JOIN fresh_market.towns as t on t.id = m.id_town  
  LEFT JOIN fresh_market.regions as r on r.id = t.id_region
  LEFT JOIN fresh_market.vacancy_sources as vs on vs.id = c.id_source
  LEFT JOIN fresh_market.sources as s on s.id = vs.id_source


  
    where (DATE_FORMAT(tt.date_interview, '%m-%Y') = DATE_FORMAT(CURDATE(), '%m-%Y') AND DATE_FORMAT(CURDATE(), '%d') <= 25 
        OR
        ((DATE_FORMAT(tt.date_interview, '%m-%Y') = DATE_FORMAT(CURDATE(), '%m-%Y') OR DATE_FORMAT(tt.date_interview, '%m-%Y') = DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL 1 MONTH), '%m-%Y') )AND DATE_FORMAT(CURDATE(), '%d') > 25)
  )
   and c.status = 1";

        $result = $connection->createCommand($sql)->queryAll();


        require_once Yii::getAlias('@vendor').'/Classes/PHPExcel/IOFactory.php';

        $ColumnLetter = \PHPExcel_Cell::stringFromColumnIndex(25);

        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");
        $i = 1;

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A1", 'Номер');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("B1", 'Регион');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C1", 'Нас. пункт');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D1", 'Адрес(магазин)');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E1", 'Дата');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F1", 'День недели');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G1", 'Время');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H1", 'ФИО');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("I1", 'Гражданство');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("J1", 'Номер телефона');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("K1", 'Вакансия');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("L1", 'Место проведения собеседования');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("M1", 'Комментарии');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("N1", 'Источник информации');


        foreach ($result as $item){
            $i++;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A".$i, $item['num']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("B".$i, $item['region']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C".$i, $item['town']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D".$i, $item['market']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E".$i, $item['day_inerview']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F".$i, $item['day_of_week_interview']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G".$i, $item['time_inerview']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H".$i, $item['fio']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("I".$i, $item['nation']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("J".$i, $item['phone']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("K".$i, $item['name_vacancy']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("L".$i, $item['pace_interview']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("M".$i, $item['comment']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("N".$i, $item['source']);
        }

       // return $item['region'];

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $file = dirname(__FILE__).'\\'.'candid'.'.xlsx';

        $file = str_replace("controllers", "", $file);
        $objWriter->save($file);

//        return $file;

        return $this->redirect(['download_file', 'file' => $file]);


        return var_dump($result);
       // return $result;

    }

    private function getConnection($host, $base, $usr, $pwd)
    {
        $connection = new \yii\db\Connection([
            // 'dsn' => 'mysql:host=sql.ad.kellykc.ru;dbname=kelly_reception_test',
            'dsn' => 'mysql:host='.$host.';dbname='.$base,
            'username' => $usr,
            'password' => $pwd,
            'charset' => 'utf8',
        ]);

        return $connection;
    }

    public function actionDownload_file(){
        $get = Yii::$app->request->get();
        $file = $get['file'];

        if (file_exists($file)) {
            // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
            // если этого не сделать файл будет читаться в память полностью!
            if (ob_get_level()) {
                ob_end_clean();
            }
            // заставляем браузер показать окно сохранения файла
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
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
            //exit;
        }
    }


}
