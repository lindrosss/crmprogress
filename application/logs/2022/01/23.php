<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2022-01-23 23:14:11 --- EMERGENCY: ErrorException [ 2 ]: preg_match(): Compilation failed: unmatched closing parenthesis at offset 36 ~ SYSPATH/classes/Kohana/Route.php [ 423 ] in file:line
2022-01-23 23:14:11 --- DEBUG: #0 [internal function]: Kohana_Core::error_handler(2, 'preg_match(): C...', '/var/www/u07886...', 423, Array)
#1 /var/www/u0788659/data/www/softprog.ru/system/classes/Kohana/Route.php(423): preg_match('#^kontakty-ooo-...', '', NULL)
#2 /var/www/u0788659/data/www/softprog.ru/system/classes/Kohana/Request.php(466): Kohana_Route->matches(Object(Request))
#3 /var/www/u0788659/data/www/softprog.ru/system/classes/Kohana/Request.php(938): Kohana_Request::process(Object(Request), Array)
#4 /var/www/u0788659/data/www/softprog.ru/index.php(118): Kohana_Request->execute()
#5 {main} in file:line
2022-01-23 23:24:03 --- EMERGENCY: ErrorException [ 8 ]: Undefined variable: content ~ APPPATH/views/template.php [ 104 ] in /var/www/u0788659/data/www/softprog.ru/application/views/template.php:104
2022-01-23 23:24:03 --- DEBUG: #0 /var/www/u0788659/data/www/softprog.ru/application/views/template.php(104): Kohana_Core::error_handler(8, 'Undefined varia...', '/var/www/u07886...', 104, Array)
#1 /var/www/u0788659/data/www/softprog.ru/system/classes/Kohana/View.php(61): include('/var/www/u07886...')
#2 /var/www/u0788659/data/www/softprog.ru/system/classes/Kohana/View.php(348): Kohana_View::capture('/var/www/u07886...', Array)
#3 /var/www/u0788659/data/www/softprog.ru/system/classes/Kohana/Controller/Template.php(44): Kohana_View->render()
#4 /var/www/u0788659/data/www/softprog.ru/system/classes/Kohana/Controller.php(87): Kohana_Controller_Template->after()
#5 [internal function]: Kohana_Controller->execute()
#6 /var/www/u0788659/data/www/softprog.ru/system/classes/Kohana/Request/Client/Internal.php(97): ReflectionMethod->invoke(Object(Controller_Common))
#7 /var/www/u0788659/data/www/softprog.ru/system/classes/Kohana/Request/Client.php(114): Kohana_Request_Client_Internal->execute_request(Object(Request), Object(Response))
#8 /var/www/u0788659/data/www/softprog.ru/system/classes/Kohana/Request.php(986): Kohana_Request_Client->execute(Object(Request))
#9 /var/www/u0788659/data/www/softprog.ru/index.php(118): Kohana_Request->execute()
#10 {main} in /var/www/u0788659/data/www/softprog.ru/application/views/template.php:104