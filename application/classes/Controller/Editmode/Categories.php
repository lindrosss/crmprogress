<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Editmode_Categories extends Controller_Commonauthorized {

	public function action_index()
		{
			$tprefix = Kohana::$config->load('database.default.table_prefix');		
		
			$content = View::factory('editmode/show_categories')
				   ->bind('list_categories', $list_categories);	        
		
		
			$Model_Categories = new Model_editmode_Categoriesmod();
			$list_categories = $Model_Categories->get_list_categories($tprefix);
		
			$this->template->content = $content;
		}
	
	public function action_create()
		{
			
		}	

} 
