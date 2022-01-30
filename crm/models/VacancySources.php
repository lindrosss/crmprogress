<?php

/*МОДЕЛЬ СОЗДАНА НЕ ВЕРНОБ НО ОНО РАБОТАЕТ
  МОДЕЛЬ РАБОТАЕТ НЕ ДЛЯ ВАКАНСИЙ, А ДЛЯ МАГАЗИНОВ
  id_vacancy - ЭТО ID МАРКЕТА
*/

namespace app\models;

use Yii;

/**
 * This is the model class for table "vacancy_sources".
 *
 * @property int $id
 * @property int $id_vacancy
 * @property int $id_source
 */
class VacancySources extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vacancy_sources';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_vacancy', 'id_source'], 'required'],
            [['id_vacancy', 'id_source', 'id_updator'], 'integer'],
			[['date_create'], 'safe'],
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
            'id_source' => 'Id Source',
			'id_updator' => 'Id id_updator',
			'date_create' => 'Id date_create',
        ];
    }
	
	public function getSource()
	{
		return $this->hasOne(Sources::className(), ['id' => 'id_source']);
	}
	
	/* Геттер для названия источника */
	public function getSourceName() {
		if(isset($this->source->name)){
			return $this->source->name;
		}else{
			return '';
		}
	}
}
