<link type="text/css" rel="stylesheet" href="<?php echo URL::base(); ?>public/css/admin/categories.css">

<h1>Категории статей</h1>

<div class="admin_panel">
	<button id="btn_create_category" title="Сохранить">Создать</button> 
	<button id="btn_edit_category" title="Закрыть">Редактировать</button>
	<button id="btn_edit_category" title="Закрыть">Удалить</button>	
</div>

<table id="list_categories" class = "admin_table_data" cellspacing="0">
	<tr>
		<th>			
		</th>
		<th>
			Название категории
		</th>
		
	</tr>
<?php
	foreach($list_categories as $list_categories_item):?>
		<tr>
			<td><?php echo $list_categories_item['id'];?></td>
			<td><?php echo $list_categories_item['name_cat'];?></td>			
		</tr>
	<?php endforeach; ?>

</table>

 

