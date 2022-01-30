<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "towns".
 *
 * @property int $id
 * @property string $name
 * @property int $id_region
 * @property int $id_updator
 * @property string $date_update
 */
class Towns extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'towns';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'id_region', 'id_updator', 'date_update'], 'required'],
            [['id_region', 'id_updator'], 'integer'],
            [['date_update'], 'safe'],
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
            'id_region' => 'Id Region',
            'id_updator' => 'Id Updator',
            'date_update' => 'Date Update',
        ];
    }
	
	public function getRegion()
	{		
		return 	$this->hasOne(Regions::className(), ['id' => 'id_region']);		
	}
	
	public function getRegionName() {
		if(isset($this->region->name)){
			return $this->region->name;
		}else{
			return 'не указан';
		}
	}
}
