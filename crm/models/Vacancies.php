<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vacancies".
 *
 * @property int $id
 * @property string $name
 * @property string $info
 * @property string employment
 * @property int $id_timetable
 * @property int $id_address
 * @property int $id_updator
 * @property int is_public
 * @property string $date_update
 */
class Vacancies extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vacancies';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'info', 'id_updator', 'date_update'], 'required'],
            [['info'], 'string'],
            [['id_timetable', 'id_address', 'id_updator', 'is_public'], 'integer'],
            [['date_update'], 'safe'],
            [['employment'], 'string', 'max' => 50],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'info' => 'Информация',
            'employment' => 'Занятость',
            'is_public' => 'Опубликована',
            'id_timetable' => 'Id Timetable',
            'id_address' => 'Id Address',
            'id_updator' => 'Id Updator',
            'date_update' => 'Дата изменения',
        ];
    }
}
