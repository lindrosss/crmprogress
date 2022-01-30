<link type="text/css" rel="stylesheet" href="<?php echo URL::base(); ?>public/css/admin/articles.css">

<h1>Редактирование статьи # <span id= "id_article"><?php echo $content_article['id']?></span></h1>

<div class="admin_panel">
	<button id="btn_save_article" title="Сохранить">Сохранить</button> 
	<button id="btn_close_article" title="Закрыть">Закрыть</button>
	<button id="btn_del_article" title="Закрыть">Удалить</button>	
</div>

<div id="block_parameters">
	<table>
		<tr>
			<td>
				<span id="title_article" class="label">Название</span>
			</td>
			<td>
				<input type="text" id="title_article" class="txt_field" size="70" value='<?php echo $content_article['title']?>'>
			</td>	
		</tr>
		
		<tr>
			<td>
				<span id="url_article" class="label">URL статьи</span>
			</td>
			<td>
				<input type="text" id="url_article" class="txt_field" size="70" value='<?php echo $content_article['alias']?>'>
			</td>	
		</tr>
		
		<tr>
			<td><span id="cat_article" class="label">Категория</span></td>
			<td>
				<select id = "cat_article_select" class="select_article">
					<?php
						foreach($list_categories as $list_categories_item):
													
						endforeach;
					?>
				</select>
			</td>	
		</tr>
		
	</table>
</div>

 

