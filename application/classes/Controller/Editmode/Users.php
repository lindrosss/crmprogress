<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Editmode_Users extends Controller_Commonauthorized {

	public function action_index()
		{
			$tprefix = Kohana::$config->load('database.default.table_prefix');		
		
			$content = View::factory('editmode/show_users')
				   ->bind('list_users', $list_users);	        
		
		
			$Model_Users = new Model_editmode_Usersmod();
			$list_users = $Model_Users->get_list_users($tprefix);
		
			$this->template->content = $content;
		}
	
	public function action_create()
		{
			
		}	

} 
