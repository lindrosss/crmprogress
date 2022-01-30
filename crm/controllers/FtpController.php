<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;


class FtpController extends Controller
{
	public $enableCsrfValidation = false;
    
	public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
	
	public static function Sendfile($ftp_username, $ftp_userpass, $ftp_server, $file_path_from, $file_name_to)
    {
		//$ftp_username = 'ftp';
		//$ftp_userpass = 'ftp';
		
		//$ftp_server = "localhost";
		$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
		$login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);
		ftp_pasv($ftp_conn, true);
		//$file_path_from = "C:/xampp/htdocs/upload/images/session_started_event.png";

		// upload file
		if (ftp_put($ftp_conn, $file_name_to, $file_path_from, FTP_BINARY))
		  {
		  echo "Successfully uploaded $file_path_from.";
		  }
		else
		  {
		  echo "Error uploading $file_path_from.";
		  }

		// close connection
		ftp_close($ftp_conn);
		
    }
	
	/*
		ftp_username - login ftp
		ftp_userpass - password ftp
		ftp_server - адрес сервера
		file_path_from - Имя файла, который необходимо скопировать на FTP
		file_name_to - Как будет назван файл на локальной машине (полный путь)
	*/
	
	public static function Getfile($ftp_username, $ftp_userpass, $ftp_server, $file_path_from, $file_name_to)
    {
		
		// объявление переменных
		//$local_file = 'local.zip';
		//$server_file = 'server.zip';
		
			
		
		// установка соединения
		$conn_id = ftp_connect($ftp_server);
		
		// вход с именем пользователя и паролем
		$login_result = ftp_login($conn_id, $ftp_username, $ftp_userpass);
		ftp_pasv($conn_id, true);

		// попытка скачать $server_file и сохранить в $local_file
		if (ftp_get($conn_id, $file_name_to, $file_path_from, FTP_BINARY)) {
			echo "Произведена запись в $file_name_to\n";
		} else {
			echo "Не удалось завершить операцию\n";
		}

		// закрытие соединения
		ftp_close($conn_id);
		
			
			
    }
}
