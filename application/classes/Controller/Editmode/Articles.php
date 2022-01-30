<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Editmode_Articles extends Controller_Commonauthorized {

	public function action_index()
		{
			$tprefix = Kohana::$config->load('database.default.table_prefix');		
		
			$content = View::factory('editmode/show_articles')
				   ->bind('list_articles', $list_articles);	        
		
		
			$Model_Articles = new Model_editmode_Articlesmod();
			$list_articles = $Model_Articles->get_list_articles($tprefix);
		
			$this->template->content = $content;
		}
	
	public function action_edit()
		{
			$id_article = $this->request->param('id');
			$tprefix = Kohana::$config->load('database.default.table_prefix');

			$content = View::factory('editmode/show_articles_edit')
				   ->bind('content_article', $content_article)
				   ->bind('list_categories', $list_categories);	
				   
			$Model_Articles = new Model_editmode_Articlesmod();
			$content_article = $Model_Articles->get_content_articles($tprefix, $id_article);
			
			$Model_Categories = new Model_editmode_Categoriesmod();
			$list_categories = $Model_Categories->get_list_categories($tprefix);
		
			$this->template->content = $content;	   
		}	

} 
