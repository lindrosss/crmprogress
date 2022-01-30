<link type="text/css" rel="stylesheet" href="<?php echo URL::base(); ?>public/css/admin/articles.css">

<h1>Категории статей</h1>

<div class="admin_panel">
	<button id="btn_create_article" title="Сохранить">Создать</button> 
	<button id="btn_edit_article" title="Закрыть">Редактировать</button>
	<button id="btn_edit_article" title="Закрыть">Удалить</button>	
</div>

<table id="list_articles" class = "admin_table_data" cellspacing="0">
	<tr>
		<th>
			#
		</th>
		<th>
			Название статьи
		</th>		
		<th>
			Дата создания
		</th>
		
	</tr>
<?php
	foreach($list_articles as $list_articles_item):?>
		<tr>
			<td><?php echo $list_articles_item['id'];?></td>
			<td><a href="/editmode/articles/edit/<?php echo $list_articles_item['id'];?>"><?php echo $list_articles_item['title'];?></a></td>	
			<td>			
				<?php
					$date_article = DateTime::createFromFormat('Y-m-d H:i:s', $list_articles_item['created']);
					echo $date_article->format('d.m.Y');
				?>			
			</td>		
		</tr>
	<?php endforeach; ?>

</table>

 

