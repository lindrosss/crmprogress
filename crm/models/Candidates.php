<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "candidates".
 *
 * @property int $id
 * @property string $fio
 * @property string $phone
 * @property int $age
 * @property int $id_timetable
 * @property int $status
 * @property string $creator
 * @property int $id_updator
 * @property string $date_create
 * @property string $date_update
 */
 
 
 /*
	status:
	1 - записан на собеседование
	2 - записан в резерв
	3 - отказался от собеседования
 */
class Candidates extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'candidates';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fio', 'phone', 'age', 'id_timetable', 'date_create'], 'required'],
            [['age', 'id_timetable', 'id_source', 'status', 'id_updator'], 'integer'],
            [['date_create', 'date_update', 'comment', 'nation'], 'safe'],
            [['fio'], 'string', 'max' => 70],
            [['phone'], 'string', 'max' => 20],
            [['creator'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'Fio',
            'phone' => 'Phone',
            'age' => 'Age',
            'nation' => 'Nation',
            'id_timetable' => 'Id Timetable',
            'status' => 'Status',
            'creator' => 'Creator',
            'id_updator' => 'Id Updator',
            'date_create' => 'Date Create',
            'date_update' => 'Date Update',
        ];
    }
	
	public function getTimetable()
	{
		return $this->hasOne(Timetables::className(), ['id' => 'id_timetable']);
	}
	
	/* Геттер для даты собеседования */
	public function getTimetableDate() {
		return $this->timetable->date_interview;
	}
	
	public function getTimetableAddress() {
		return $this->timetable->addressName;
	}
	
	public function getVacancyMarkets()
	{
		return $this->hasOne(VacancyMarket::className(), ['id' => 'id_vacancy_in_market']);
	}
	
	public function getVacancyMarketNameVacancy() {
        if(isset($this->vacancyMarkets->vacanciesname)){
            return $this->vacancyMarkets->vacanciesname;
        }else{
            return 'Не указана';
        }

	}
	
	public function getVacancyMarketNameMarket() {
        if(isset($this->vacancyMarkets->vacanciesmarket)){
            return $this->vacancyMarkets->vacanciesmarket;
        }else{
            return 'Не указан';
        }
	}
	
	public function getSource()
	{
		return $this->hasOne(VacancySources::className(), ['id' => 'id_source']);
	}
	
	public function getSourceName() {
		if(isset($this->source->sourceName)){
			return $this->source->sourceName;
		}else{
			return 'Не указан';
		}
	}
}
