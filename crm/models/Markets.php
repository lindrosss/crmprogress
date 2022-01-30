<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "markets".
 *
 * @property int $id
 * @property string $num_market
 * @property string $name
 * @property int $id_town
 * @property int $id_region
 * @property int $id_updator
 * @property string $date_update
 * @property string $rm
 * @property string $recruiter
 */
class Markets extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'markets';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'id_town',  'id_updator', 'date_update'], 'required'],
            [['id_town', 'id_updator', 'id_timetable'], 'integer'],
            [['date_update'], 'safe'],
            [['name'], 'string', 'max' => 150],
            [['recruiter'], 'string', 'max' => 255],
            [['num_market', 'rm'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'num_market' => 'Номер магазина',
            'name' => 'Name',
            'id_town' => 'Id Town',
            //'id_region' => 'Id Region',
            'id_updator' => 'Id Updator',
            'date_update' => 'Date Update',
            'rm' => 'Региональный менеджер',
            'recruiter' => 'Рекрутер',
        ];
    }
	
	public function getTimetables()
	{
		return $this->hasMany(Timetables::className(), ['id' => 'id_timetable']);
	}
	
	public function getTown()
	{		
		return 	$this->hasOne(Towns::className(), ['id' => 'id_town']);		
	}
	
	public function getTownName() {
		if(isset($this->town->name)){
			return $this->town->name;
		}else{
			return 'Не указан';
		}
	}
}
