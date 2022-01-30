<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vacancy_market".
 *
 * @property int $id
 * @property int $id_vacancy
 * @property int $id_market
 */
class VacancyMarket extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vacancy_market';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_vacancy', 'id_market'], 'required'],
            [['id_vacancy', 'id_market', 'id_timetable', 'id_updator'], 'integer'],
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
            'id_market' => 'Id Market',
        ];
    }
	
	public function getVacancies()
	{
		return $this->hasOne(Vacancies::className(), ['id' => 'id_vacancy']);
	}
	
	public function getVacanciesname() {
		return $this->vacancies->name;
	}
	
	public function getVacanciesiszum() {
		return $this->vacancies->is_zum;
	}
	
	
	
	public function getMarket()
	{
		return $this->hasOne(Markets::className(), ['id' => 'id_market']);
	}
	
	public function getVacanciesmarket() {
		return $this->market->name;
	}
	
	public function getTimetables()
	{
		return $this->hasOne(Timetables::className(), ['id' => 'id_timetable']);
	}	
	
	/* Геттер для названия вакансии 
	public function getVacancyName() {
		return $this->vacancy->name;
	}*/
}
