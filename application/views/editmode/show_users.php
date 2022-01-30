<link type="text/css" rel="stylesheet" href="<?php echo URL::base(); ?>public/css/editmode/users.css">

<h1>Редактирование пользователей</h1>

<!--
Директория  - <?php echo Request::current()->directory(); ?><br /><br />
Контроллер - <?php //echo Request::current()->controller(); ?><br /><br />
Метод - <?php echo Request::current()->action(); ?>
-->

<table id="list_user" class = "table_users" cellspacing="0">
	<tr>
		<th>
			Имя
		</th>
		<th>
			Логин
		</th>
	</tr>
<?php
	foreach($list_users as $user):?>
		<tr>
			<td><?php echo $user['username'];?></td>
			<td><?php echo $user['email'];?></td>			
		</tr>
	<?php endforeach; ?>

</table>

 <div class="span4" id="form_usr">
        <h4 style="text-align:center; padding: 10px;">Новый пользователь</h4>
        <? if (isset($messageReg))
            { 
                echo '<span class="label label-important">'.$messageReg."</span><br />";
                if (isset($errors)) foreach ($errors as $error) echo $error."<br />";
                echo "<hr />"; 
            } ?>
        
		<form  method="post" action="/account/registration">
			<table>
				<tr>
					<td><label>Отображаемое имя</label></td>
					<td><input type="text" name="username" value="<?php //echo $data['username'];?>" class="span3"></td>
				</tr>
				<tr>
					<td><label>Login(E-Mail адрес)</label></td>
					<td><input type="email" name="email" value="<?php //echo $data['email'];?>" class="span3"></td>
				</tr>
				<tr>
					<td><label>Пароль</label></td>
					<td><input type="password" name="password" class="span3"></td>
				</tr>
				<tr>
					<td><input type="submit" value="Зарегистрировать" class="btn btn-primary"></td>
					<td></td>
				</tr>	
			</table>
            <div class="clearfix"></div>
        </form>
    </div>

