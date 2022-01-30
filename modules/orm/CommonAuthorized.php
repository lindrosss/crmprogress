<?php defined('SYSPATH') or die('No direct script access.');
 
abstract class Controller_CommonAuthorized extends Controller_Template {
 
    public $template = 'template';
 
    public function before()
    {
        parent::before();
        if (!Auth::instance()->get_user()) // смотрим - если пользователь НЕ авторизован
        {
            $session = Session::instance(); // стартуем сессию
            $session->set('redirectAfterLogin', $_SERVER['REQUEST_URI']); // записываем куда он хотел попасть
            HTTP::redirect('/account/registration'); // редиректим на авторизацию/регистрацию
        }
    }
}
?>