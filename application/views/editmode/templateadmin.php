<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Админка</title>
	
	<link type="text/css" rel="stylesheet" href="<?php echo URL::base(); ?>public/css/admin/template.css">
	
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
</head>
 
<body>
<h2>Панель администратора</h2>

<div id="admin_menu">
	<ul>
		<li>
			<a href="<?php echo URL::base(); ?>editmode">В начало</a>
		</li>
		
		<li>
			<a href="<?php echo URL::base(); ?>editmode/users">Пользователи</a>
		</li>
		<li>
			<a href="<?php echo URL::base(); ?>editmode/categories">Категории статей</a>
		</li>
		<li>
			<a href="<?php echo URL::base(); ?>editmode/articles">Статьи</a>
		</li>
		
		
	</ul>
</div>
<div id="admin_content">
    <?php echo $content; ?>
</div>	
</body>
</html>