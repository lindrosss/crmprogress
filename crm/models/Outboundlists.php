<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "outbound_lists".
 *
 * @property int $id
 * @property string $name
 * @property string $dsn
 * @property string $settings
 */
class OutboundLists extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
	public $dsn_dsn; 
	public $dsn_table; 
	public $dsn_user; 
	public $dsn_password; 	
	public $delete_data_before_load;
	 
    public static function tableName()
    {
        return 'outbound_lists';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[['name', 'dsn', 'settings', 'dsn_dsn', 'dsn_user', 'dsn_password'], 'required'],
			[['name', 'dsn', 'settings'], 'required'],
            [['dsn', 'settings'], 'string'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'dsn' => 'Dsn',
            'settings' => 'Settings',
        ];
    }
}
