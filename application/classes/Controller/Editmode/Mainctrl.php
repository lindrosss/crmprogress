<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Editmode_Mainctrl extends Controller_Commonauthorized {

//public $template = 'template';

	public function action_index()
	{
		
		
		$content = View::factory('editmode/main')
              ->bind('age', $age);
        $age = 'больше 18';
        
        
		$this->template->content = $content;
	}

} // End Welcome
