<?php defined('SYSPATH') or die('No direct script access.');
 
abstract class Controller_Commonauthorized extends Controller_Template 
{

  
 
    public $template = 'editmode/templateadmin';
 
    public function before()
    {
        parent::before();
		
		$this->response->headers('cache-control', 'public, max-age=0');		
		  
		//echo 'user '.Auth::instance()->get_user();									
        if (!Auth::instance()->get_user()) // смотрим - если пользователь НЕ авторизован
        {
            $session = Session::instance(); // стартуем сессию
            $session->set('redirectAfterLogin', $_SERVER['REQUEST_URI']); // записываем куда он хотел попасть
            //HTTP::redirect('/account/registration'); // редиректим на авторизацию/регистрацию
			HTTP::redirect('/account/login'); // редиректим на авторизацию/регистрацию
        }
    }
}
?>