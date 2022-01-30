<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_editmode_Articlesmod extends Model
{   
	
	protected $_tableArticles = 'Articles';	
	protected $_tableCategories = 'Categories';	
	
	/*
		Тут переделать запрос после того, как будут созданы категории статей!!!
		В запрос приджойнить таблицу категорий!!!
	*/
    public function get_list_articles($tprefix)
    {
        
		$sql = "SELECT * FROM ". $tprefix.$this->_tableArticles;
 
        return DB::query(Database::SELECT, $sql)
                   ->execute();
    }
	
	public function get_content_articles($tprefix, $id_article)
    {
        
		$sql = "SELECT * FROM ". $tprefix.$this->_tableArticles." as art".
				" WHERE art.id = ".$id_article;
 
        $result = DB::query(Database::SELECT, $sql)
                   ->execute()->as_array();
		
		return $result[0];		   
    }
}