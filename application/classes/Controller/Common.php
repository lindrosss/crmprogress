<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Common extends Controller_Template {

//public $template = 'template';

	public function action_index()
	{		
		$content = View::factory('main');
		$this->template->content = $content;	
	}
	
	public function action_yslugi()
	{		
		$name_article = $this->request->param('name_article');
		
		if($name_article == null)
		{
			$content = View::factory('yslugi');
			$this->template->content = $content;
		}
		else
			{
				$content = View::factory('yslugiarticles/'.$name_article);
				$this->template->content = $content;
			}
	}
	
	public function action_licens()
	{		
		$content = View::factory('licens');
		$this->template->content = $content;	
	}
	
	public function action_rekvizity()
	{		
		$content = View::factory('rekvizity');
		$this->template->content = $content;	
	}
	
	public function action_kontakty()
	{	
		$content = View::factory('kontakty');
		$this->template->content = $content;	
	}

    public function action_communigate()
    {
        $content = View::factory('communigate');
        $this->template->content = $content;
    }

    public function action_myoffice()
    {
        $content = View::factory('myoffice');
        $this->template->content = $content;
    }

} 
