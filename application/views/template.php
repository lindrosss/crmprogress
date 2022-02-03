<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<link rel="shortcut icon" href="/public/images/favicon.ico">
		<link type="text/css" rel="stylesheet" href="/public/css/template.css">
		
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
		<script src="/public/js/template.js" type="text/javascript"></script>
		
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />		
		
		<?php
				switch (Request::current()->action())
				{
					case 'index':
						echo '<title>ООО "ПРОГРЕСС"  | Продажа Р7-офис</title>';
						break;
						
					case 'yslugi':
						echo '<title>Услуги по монтажу электрических сетей</title>';
						echo '<meta content="Услуги по монтажу электрических сетей" name="description">';
						break;
					
					case 'licens':
						echo '<title>Сертификаты</title>';
						echo '<meta content="Сертификаты" name="description">';
						break;
						
					case 'rekvizity':
						echo '<title>Реквизиты компании ООО "СЭМ" Строй инжиниринг</title>';
						echo '<meta content="Реквизиты компании ООО "СЭМ" Строй инжиниринг" name="description">';
						break;	
							
					case 'kontakty':
						echo '<title>Контакты ООО "Прогресс"</title>';
						echo '<meta content="Контакты ООО "Прогресс" " name="description">';
						break;		
				}
			?>
		
	</head>
 
	<body>
		<div id="header" class="table_row">
		<div id="content_header">	
			<div class="table_row">
			<div id="logo" class="table_cell">
				<img style="width: 300px;" src="public/images/logo_ok.png"/>
			</div>
			
			<!--
			<div id="slogan">
					<p>Комплексные услуги по монтажу</p>
					<p> электрических и слаботочных сетей</p>
			</div>
			-->
			
			<div id="head_contact" class="table_cell">				
				<!-- <p>Нижний Новгород, ул.Октябрьская, 35</p> -->
				<p>Email: info@softprog.ru</p>				
			</div>
			</div>
			
			<div >
		<div id="menu" class="table_cell">
				
				<ul id="ul_menu">
					<li <?php if(Request::current()->action()=='index') echo 'class="active"'?>>
						<a href="/">Главная</a>
					</li>
					
					<li <?php if(Request::current()->action()=='kontakty') echo 'class="active"'?>>
						<a href="/kontakty-ooo-progress">Контакты</a>
					</li>

                    <li <?php if(Request::current()->action()=='licens') echo 'class="active"'?>>
                        <a href="/licens-ooo-progress">Сертификаты</a>
                    </li>
					
					
				</ul>
			
			</div>
			<div class="table_cell">
			
			</div>
		</div>	
		
			
		<hr>
		</div>
		
		
			
		
		</div>
		

		<div id="left">
		
		</div>
		
		
		
		<div id="wrapper">
			<div id="content">
				<?php echo $content; ?>
			</div>
		</div>

			
		
		<div id="footer">
			ООО "Прогресс". Комплексные решения Р7-офис для госучреждений и предприятий (C) 2022г.
		</div>
	</body>
</html>