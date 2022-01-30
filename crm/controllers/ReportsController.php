<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\Timetables;


class ReportsController extends Controller
{
    public function actionIndex()
    {
        $get = Yii::$app->request->get();

        return $this->render('index', ['get' => $get,]);
    }

    public function actionDownload_actual_time_tables(){

        $xls_file_name = 'Актуальные_графики_на_'.date('Y-m-d');

        require_once Yii::getAlias('@vendor').'/Classes/PHPExcel/IOFactory.php';

        $res = $this->get_data_actual_time_tables();

        //$ColumnLetter = \PHPExcel_Cell::stringFromColumnIndex(25);

        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Kelly KC")
            ->setLastModifiedBy("Kelly KC")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("current schedule");
            //->setKeywords("office 2007 openxml php")
            //->setCategory("Test result file");

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A1", 'Рекрутер');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("B1", 'Региональный менеджер');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C1", 'Номер магазина');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D1", 'Регион');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E1", 'Город');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F1", 'Магазин');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G1", 'Дата');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H1", 'Время собеседования');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("I1", 'Адрес проведения');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("J1", 'Вакансия');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("K1", 'Квота');


        /*Установка стилей*/
        $bg_gray = array(
            'fill' => array(
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'dddddd')
            )
        );

        $objPHPExcel->setActiveSheetIndex(0)->getStyle("A1:K1")->getFont()->setBold(true);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle("A1:K1")->applyFromArray($bg_gray);
        $objPHPExcel->setActiveSheetIndex(0)->setAutoFilter('A1:K'.count($res));

        $objPHPExcel->setActiveSheetIndex(0)->freezePane('A2');

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);


        $row = 2;
        foreach($res as $val)
        {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$row", $val['recruiter']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("B$row", $val['rm']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C$row", $val['num_market']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D$row", $val['region']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E$row", $val['city']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F$row", $val['market']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G$row", $val['day_inerview']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H$row", $val['time_inerview']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("I$row", $val['adress']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("J$row", $val['vakancy']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("K$row", $val['quota']);

            $row++;
        }

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        //$objWriter->save('php://output');
        //$file = dirname(__FILE__).'\\'.$xls_file_name.'.xlsx';
        $file  = \Yii::$app->params['xlspath'].$xls_file_name.'.xlsx';
        $objWriter->save($file);

        return $this->redirect(['download_file', 'file' => $file]);



       // return serialize($this->get_data_actual_time_tables());

    }

    public function get_data_actual_time_tables($start_date=NULL, $end_date=NULL){

        if($start_date == NULL &&  $end_date == NULL){
            $where = " WHERE t.date_interview >= STR_TO_DATE('".date('d.m.Y')."', '%d.%m.%Y')".
            " AND t.is_public = 1";
        }

        if($start_date != NULL &&  $end_date != NULL){
            $where = " WHERE STR_TO_DATE(DATE_FORMAT(t.date_interview, '%d-%m-%Y'), '%d-%m-%Y')  >= STR_TO_DATE('".$start_date."', '%d-%m-%Y') ".
            "AND STR_TO_DATE(DATE_FORMAT(t.date_interview, '%d-%m-%Y'), '%d-%m-%Y')  <= STR_TO_DATE('".$end_date."', '%d-%m-%Y')".
            " AND t.is_public = 1";
        }


        $sql =   "SELECT 
  
                      
                       DATE_FORMAT(t.date_interview, '%d.%m.%Y ') as day_inerview
                      ,DATE_FORMAT(t.date_interview, '%H:%i:%s') as time_inerview
                      ,t.quota
                      ,a.name AS adress
                      ,v.name AS vakancy
                    
                      ,m.id AS id_market
                      ,m.name AS market
                      ,m.num_market AS num_market
                      ,m.rm
                      ,m.recruiter
                      ,t1.name AS city
                      ,r.name AS region
                      
                         
                      FROM fresh_market.timetables t
                      LEFT JOIN vacancy_market vm ON vm.id = t.id_vacancy
                      LEFT JOIN addresses a ON t.id_address = a.id
                      LEFT JOIN markets m ON vm.id_market = m.id
                      LEFT JOIN vacancies v ON vm.id_vacancy = v.id
                      LEFT JOIN towns t1 ON t1.id = m.id_town
                      LEFT JOIN regions r ON t1.id_region = r.id
                    
                      /*WHERE t.date_interview > STR_TO_DATE('06.08.2020', '%d.%m.%Y')*/
                     /* WHERE t.date_interview > STR_TO_DATE('".date('d.m.Y')."', '%d.%m.%Y')*/
                    ".$where
        ;

        $rows_s = Yii::$app->db->createCommand($sql)->queryAll();

        return $rows_s;

    }

    public function actionDownload_time_tables_range(){

        $post = Yii::$app->request->post();

        $start_date = $post['start_date'];
        $end_date = $post['end_date'];

        $xls_file_name = 'Графики_за_период_с_'.$start_date.'_по_'.$end_date;

        require_once Yii::getAlias('@vendor').'/Classes/PHPExcel/IOFactory.php';

        $res = $this->get_data_actual_time_tables($start_date, $end_date);

        //$ColumnLetter = \PHPExcel_Cell::stringFromColumnIndex(25);

        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Kelly KC")
            ->setLastModifiedBy("Kelly KC")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("current schedule");
        //->setKeywords("office 2007 openxml php")
        //->setCategory("Test result file");

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A1", 'Рекрутер');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("B1", 'Региональный менеджер');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C1", 'Номер магазина');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D1", 'Регион');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E1", 'Город');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F1", 'Магазин');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G1", 'Дата');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H1", 'Время собеседования');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("I1", 'Адрес проведения');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("J1", 'Вакансия');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("K1", 'Квота');


        /*Установка стилей*/
        $bg_gray = array(
            'fill' => array(
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'dddddd')
            )
        );

        $objPHPExcel->setActiveSheetIndex(0)->getStyle("A1:K1")->getFont()->setBold(true);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle("A1:K1")->applyFromArray($bg_gray);
        $objPHPExcel->setActiveSheetIndex(0)->setAutoFilter('A1:K'.count($res));

        $objPHPExcel->setActiveSheetIndex(0)->freezePane('A2');

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
       // $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);


        $row = 2;
        foreach($res as $val)
        {

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$row", $val['recruiter']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("B$row", $val['rm']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C$row", $val['num_market']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D$row", $val['region']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E$row", $val['city']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F$row", $val['market']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G$row", $val['day_inerview']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H$row", $val['time_inerview']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("I$row", $val['adress']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("J$row", $val['vakancy']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("K$row", $val['quota']);

            $row++;
        }

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        //$objWriter->save('php://output');
        //$file = dirname(__FILE__).'\\'.$xls_file_name.'.xlsx';
        $file  = \Yii::$app->params['xlspath'].$xls_file_name.'.xlsx';
        $objWriter->save($file);

        return $this->redirect(['download_file', 'file' => $file]);



        // return serialize($this->get_data_actual_time_tables());

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
