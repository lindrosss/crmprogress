<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_editmode_Usersmod extends Model
{
   
	
	protected $_tableUsers = 'users';
	protected $_tableRoles = 'roles';
	
    public function get_list_users($tprefix)
    {
        
		$sql = "SELECT * FROM ". $tprefix.$this->_tableUsers;
 
        return DB::query(Database::SELECT, $sql)
                   ->execute();
    }
	
	public function get_data_user($tprefix, $id_user)
    {
	
	}
	
	public function get_roles_users($tprefix)
    {
	
	}
	
}