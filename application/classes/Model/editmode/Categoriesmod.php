<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_editmode_Categoriesmod extends Model
{   
	
	protected $_tableCategories = 'Categories';	
	
    public function get_list_categories($tprefix)
    {
        
		$sql = "SELECT * FROM ". $tprefix.$this->_tableCategories;
 
        return DB::query(Database::SELECT, $sql)
                   ->execute();
    }
	
	
	
}