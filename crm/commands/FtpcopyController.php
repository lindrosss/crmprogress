<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use app\controllers\FtpController;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class FtpcopyController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex($message = 'hello world1111')
    {
        echo $message . "\n";
    }
	
	public function actionSend_to_ftp($message = 'Copy_to_ftp')
    {
        //..\..\app\controllers\FtpController::actionSendfile;
		
		//Yii::$app->runAction('FtpController/Sendfile');
		FtpController::Sendfile('ftp', 'ftp', '192.168.41.161', '/var/www/html/upload/files/serverfile222.png', 'serverfile333.png' );
		echo $message . "\n";
		
    }
	
	public function actionGet_from_ftp($message = 'Copy_to_ftp')
    {
        //..\..\app\controllers\FtpController::actionSendfile;
		
		//Yii::$app->runAction('FtpController/Sendfile');
		//FtpController::Getfile('ftp', 'ftp', 'localhost', 'serverfile.png', 'C:\xampp\htdocs\upload\files\serverfile_'.date('Y-m-d_H_i_s').'.png' );
		//FtpController::Getfile('ftp', 'ftp', '192.168.41.161', 'serverfile.png', '/var/www/html/upload/files/serverfile_'.date('Y-m-d_H_i_s').'.png' );
		
		FtpController::Getfile('ftp', 'ftp', '192.168.41.161', 'serverfile.png', '/var/www/html/upload/files/serverfile_'.date('Y-m-d_H_i_s').'.png' );
		
		//echo $message . "\n";
		
		echo 'Last script wirking at: '.date('Y-m-d_H_i_s');
		
    }
}
