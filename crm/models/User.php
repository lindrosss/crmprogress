<?php

namespace app\models;
use Yii;

class User extends \yii\base\Object implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;
	public $role;
	public $username_ru;
	
	/*
		role = 1 - oprator
		role = 2 - sv
		role = 3 - pm
		role = 4 - admin
		role = 5 - operator fresh
		role = 6 - operator fresh + доступ к списку кандидатов
	*/

    private static $users = [

		'102' => [
            'id' => '102',
            'username' => 'lind',
            'password' => 'lind',
            'authKey' => 'test102key',
            'accessToken' => '102-token',
			'role' => '2',
        ],
		
		'103' => [
            'id' => '103',
            'username' => 'ii.chernyakova',
            'password' => '12345678',
            'authKey' => 'test123key',
            'accessToken' => '123-token',
            'username_ru' => 'Чернякова Ирина',
			'role' => '2',
        ],

        '104' => [
            'id' => '104',
            'username' => 'e.kokurkina',
            'password' => 'Xu7x3Xde',
            'authKey' => 'test104key',
            'accessToken' => '104-token',
            'username_ru' => 'Кокуркина Елена',
            'role' => '2',
        ],

        '105' => [
            'id' => '105',
            'username' => 'd.kudinov',
            'password' => 'Xp8Uycsepm',
            'authKey' => 'test105key',
            'accessToken' => '105-token',
            'username_ru' => 'Кудинов Дмитрий',
            'role' => '2',
        ],

    ];


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    public static function findByUserid($userid)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['id'], $userid) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    public static function getUsersByRole($role){
        $arr = [];

        foreach (self::$users as $user) {
            if ($user['role'] == $role && $user['username'] != 'lind') {
                //$arr[] = ['id'=>$user['id'], 'name'=>$user['username_ru']];
                $arr[$user['id']] = $user['username_ru'];
            }
        }

        return $arr;
    }

    public static function getUsersArray(){

        foreach (self::$users as $user) {
            if(isset($user['username_ru'])) {
                $arr[$user['id']] = $user['username_ru'];
            }
        }

        return $arr;
    }

    public static function getUserNameById($id){
        $user = self::findByUserid($id);
        if($user){
            return $user->username_ru;
        }else{
            return 'Не найден';
        }
    }

}
