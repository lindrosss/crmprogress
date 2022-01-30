<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "timetables".
 *
 * @property int $id
 * @property int $id_vacancy
 * @property string $date_interview
 * @property int $quota
 * @property int $id_updator
 * @property string $date_update
 */
class Timetables extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'timetables';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_vacancy', 'id_market', 'id_address', 'date_interview', 'quota', 'id_updator', 'date_update'], 'required'],
            [['id_vacancy', 'quota', 'id_updator', 'id_market', 'is_public', 'id_address'], 'integer'],
            [['date_interview', 'date_update'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_vacancy' => 'Id Vacancy',
            'date_interview' => 'Date Interview',
            'quota' => 'Quota',
            'id_updator' => 'Id Updator',
            'date_update' => 'Date Update',
        ];
    }
	
	public function getAddress()
	{
		return $this->hasOne(Addresses::className(), ['id' => 'id_address']);
	}
	
	/* Геттер для названия адреса */
	public function getAddressName() {
		return $this->address->name;
	}
}
