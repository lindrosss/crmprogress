<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<h1>Авторизация</h1>

<div class="span4">
        <h4>Войти на сайт</h4>
        <? if (isset($message)) echo '<span class="label label-important">'.$message."</span><hr />"; ?>
        <form method="post" action="/account/login">
            <label>E-Mail адрес</label>
            <input type="email" name="email" value="<?php echo $data['email'];?>" class="span3">
            <label>Пароль</label>
            <input type="password" name="password" class="span3">
            <label class="checkbox">
              <input type="checkbox" name="rememberme" value="true"> Запомнить меня
            </label>
            <a href="/account/forgot" class="btn">Забыли пароль?</a>
            <input type="submit" value="Войти на сайт" class="btn btn-primary">
            <div class="clearfix"></div>
        </form>
</div>
	  

