<?php defined('SYSPATH') or die('No direct script access.');
 
class Controller_Account extends Controller_Template {
 
    public function action_index() // просмотр профиля или авторизация через соц.сеть
    {    
        $data = array(); // в эту переменную я зыписываю все, что нужно передать виду
        $ulogin = Ulogin::factory(); // создаем экземпляр класса юлогин
        if (!$ulogin->mode()) // если ранее юлогин не вызывался
        {
            $this->template->login = $ulogin->render(); // рисуем значки соц.сетей
        }
        else
        {
            try // пробуем
            {
                $user = $ulogin->login(); // залогиниться
                if ($user['photo']!='') // если из соц.сети можно достать фото пользователя
                {
                    $fp = fopen(DOCROOT.'uploads/users/'.Auth::instance()->get_user()->id.'.jpg', 'w');  // кладем в папку /uploads/users (не забудьте про права на запись!)
                    fwrite($fp, file_get_contents($user['photo'])); // скачиваем его
                    fclose($fp);
                    DB::update('users')->set(array('photo' => 1))->where('id', '=', Auth::instance()->get_user()->id)->execute(); // обновляем запись, что у пользователя есть фото
                }
                $session = Session::instance(); // стартуем сессии
                if ($session->get('redirectAfterLogin')!='') // если пользователь хотел куда-то перейти
                { 
                    $redirect = $session->get('redirectAfterLogin'); 
                    $session->delete('redirectAfterLogin'); // удаляем запись об этом
                    HTTP::redirect($redirect); // и редиректим
                }
            }
            catch(ORM_Validation_Exception $e)
            {
                $this->template->login = $e->errors(''); // если возникли ошибки - выводим в переменную login
            }
        }
 
        if (!$data['user'] = Auth::instance()->get_user()) // если пользователь не авторизован
        {
            HTTP::redirect('/account/registration'); // редиректим на страницу со входом/регистрацией
        } 
 
        $data['ulogin'] = $ulogin->render(); // стартуем сессии
        $data['photo'] = '/uploads/users/nophoto.jpg';
        if (Auth::instance()->get_user()->photo==1) $data['photo'] = "/uploads/users/".Auth::instance()->get_user()->id.".jpg"; // выводим фото
        $data['networks'] = DB::select("identity")->from('ulogins')->where("user_id","=",Auth::instance()->get_user()->id)->execute()->as_array(); // берем данные по всем присоединенным аккаунтам пользователя
        $this->template->content = View::factory('account',$data);
    }
 
    public function action_login() // экшн для входа
    {    
        $data = array();        
        if (HTTP_Request::POST == $this->request->method())  // если переданы POST данные
        {
            // проверяем - стоит ли флаг - запомнить меня
            $remember = array_key_exists('rememberme', $this->request->post()) ? (bool) $this->request->post('rememberme') : FALSE;
            // пробуем авторизовать пользователя
            $user = Auth::instance()->login($this->request->post('email'), $this->request->post('password'), $remember);
 
            if ($user) // если авторизовали успешно
            {
                $session = Session::instance();
                if ($session->get('redirectAfterLogin')!='')
                { 
                    $redirect = $session->get('redirectAfterLogin');
                    $session->delete('redirectAfterLogin');
                    HTTP::redirect($redirect); // редиректим куда надо (см. выше)
                }
                //HTTP::redirect('/account/');
				HTTP::redirect('/editmode');
            } 
            else 
            {
                $data['message'] = Kohana::message('auth','wrongPass'); // если не удалось авторизоваться - выводим соответствующий мессадж
				echo 'error! '.Kohana::message('auth','wrongPass');
            }
            $data['email'] = $this->request->post('email');
        }
        //$ulogin = Ulogin::factory(); 
        //$data['ulogin'] = $ulogin->render(); // рисуем значки соц.сетей
        $data['email'] = array_key_exists('email', $this->request->post()) ? htmlspecialchars($this->request->post('email')) : '';
        $data['username'] = array_key_exists('username', $this->request->post()) ? htmlspecialchars($this->request->post('username')) : ''; // вставляем данные в формы, если они были введены
        $this->template->content = View::factory('editmode/login')->bind('data', $data);
    }
 
    public function action_registration() // экшн регистрации
    {    
        $data = array();
        if (HTTP_Request::POST == $this->request->method()) 
        {            
            try {
 
                // производим проверку всех полей
                $object = Validation::factory($this->request->post());
                $object
                    ->rule('username', 'not_empty')
                    ->rule('username', 'min_length', array(':value', '4'))
                    ->rule('password', 'not_empty')
                    ->rule('password', 'min_length', array(':value', '5'))
                    ->rule('email', 'email');
 
                $user = ORM::factory('User') // если проверка пройдена - регистрируем
                    ->set('email', $this->request->post('email'))
                    ->set('username', $this->request->post('username'))
                    ->set('password', $this->request->post('password'))
                    ->save();
 
                // даем новому пользователю роль для логина
                $user->add('roles', ORM::factory('Role', array('name' => 'login')));
 
                // очищаем массив с POST
                $_POST = array();

                $to = $this->request->post('email');
                $subject = Kohana::message('account', 'email.themes.registration');
                $from = Kohana::message('account', 'email.from');
                $message = 'Вы успешно зарегистрировались с паролем - '.$this->request->post('password');
                //Email::send($to, $from, $subject, $message, $html = false); // отправляем пользователю сообщение с его паролем
 
                Auth::instance()->force_login($user); // сразу же авторизуем его, без ввода логина и пароля
                HTTP::redirect('/editmode/users');
 
            } catch (ORM_Validation_Exception $e) {
 
                // если во время валидации возникли ошибки
                $data['messageReg'] = Kohana::message('account', 'errorReg');
                $data['errors']=$e->errors('models');            
                // берем значения ошибок из файла /application/messages/model/user.php
            }
        }    
        $data['email'] = array_key_exists('email', $this->request->post()) ? htmlspecialchars($this->request->post('email')) : '';
        $data['username'] = array_key_exists('username', $this->request->post()) ? htmlspecialchars($this->request->post('username')) : '';     // вставляем данные в формы, если они были введены
 
        //$ulogin = Ulogin::factory();
        //$data['ulogin'] = $ulogin->render();  // рисуем значки соц.сетей
        $this->template->content = View::factory('editmode/login')->bind('data', $data);
    }
 
    public function action_changepass() // экшен смены пароля
    {
        $object = Validation::factory($this->request->post());  // проверяем новый пароль на корректность заполнения
        $object
            ->rule('newpassword', 'not_empty')
            ->rule('newpassword', 'min_length', array(':value', '5'));
        if ($object->check())  // если новый пароль удовлетворяет требованиям
        {
            $realoldpass = Auth::instance()->get_user()->password; // берем хэш текущего пароль пользователя
            $oldpass = Auth::instance()->hash_password($this->request->post('oldpassword')); // сравниваем с тем, что ввел пользователь
            if ($realoldpass===$oldpass)  // если они совпадают
            {
                DB::update('users')->set(array('password' => Auth::instance()->hash_password($this->request->post('newpassword'))))->where('id', '=', Auth::instance()->get_user()->id)->execute();
                HTTP::redirect('/account/?changeok');  // меняем пароль и редиректим на страницу с поздравлением    
            } 
            else
            {
                HTTP::redirect('/account/?changefalse');  // если нет - сообщаем об ошибке
            }
        }
        else 
        {
            HTTP::redirect('/account/?changefalse'); // если нет - сообщаем об ошибке
        }
    }
 
    public function action_forgot() // сброс пароля
    {
        $data = array();
        if (HTTP_Request::POST == $this->request->method())  // если были какие-то POST данные
        {    
            $data['message'] = Kohana::message('account', 'passwordSended'); // в любом случае выводим сообщение о том, что пароль отправлен. Пусть думают что все почтовые аккаунты имеют своих владельцев
            $user = ORM::factory('User', array('email' => $this->request->post('email'))); // а теперь действительно ищем - есть ли пользователь со введенным адресом
            if ($user->loaded()) // если есть
            { 
                $session = Session::instance();
                $hash = md5(time().$this->request->post('email')); // записываем в сессию хэш, который будем проверять
                $session->set('forgotpass', $hash);
                $session->set('forgotmail', $this->request->post('email')); // и почту записываем
                $to = $this->request->post('email');
                $subject = Kohana::message('account', 'email.themes.passworReset');
                $from = Kohana::message('account', 'email.from');
                $message = 'Для сброса пароля пройдите по ссылке - <a href="http://ratefilm.ru/account/forgot?change='.$hash.'">СБРОСИТЬ</a>'; // отправляем ссылку с хэшем для сброса пароля
                Email::send($to, $from, $subject, $message, $html = true);    
            }    
        }
        $restore = Arr::get($_GET, 'change');
        if ($restore) // если человек прошел по ссылке в письме
        {
            $session = Session::instance();
            if ($session->get('forgotpass') === $restore) // проверяем его сессию - действительно ли именно он запросил сброс?
            {
                $newpass = substr(md5(time().$session->get('forgotmail')),0,8); // генерируем новый пароль
                $to = $session->get('forgotmail');
                DB::update('users')->set(array('password' => Auth::instance()->hash_password($newpass)))->where('email', '=', $session->get('forgotmail'))->execute(); // ставим новый пароль пользователю
                $session->delete('forgotpass');
                $session->delete('forgotmail'); // очищаем сессию
                $subject = Kohana::message('account', 'email.themes.newPassword');
                $from = Kohana::message('account', 'email.from');
                $message = 'Ваш новый пароль - "'.$newpass.'" без кавычек. <a href="http://ratefilm.ru/account/">Войти</a>'; // отправляем новый пароль пользователю
                Email::send($to, $from, $subject, $message, $html = true);    
                $data['message'] = Kohana::message('account', 'newPassSended'); // сообщаем об успехе процедуры
            }
        }
        $data['email'] = array_key_exists('email', $this->request->post()) ? htmlspecialchars($this->request->post('email')) : '';
        $this->template->content = View::factory('forgot',$data);
    }
 
    public function action_logout() // экшн выхода
    {
        Auth::instance()->logout(); // выходим и перекитываем на страницу с авторизацией
        HTTP::redirect('/account/login');
    }    
}
?>