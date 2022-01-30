<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SmsController extends Controller
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
	
	public function actionSendsmsrequest()
    {
		//Yii::$app->controller->enableCsrfValidation = false;
		//$post = Yii::$app->request->get();	
		$post = Yii::$app->request->post();	
		$any = 'sdfsdfsdf';
		
		/*
		
		return $this->render('sms', [
            'post' => $post,
			'any' => $any,
        ]);
		
		
		return $this->render('sms');
		*/
		 \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return $post;
		
		
    }
}
