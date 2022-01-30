<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "forms".
 *
 * @property int $id
 * @property string $sid
 * @property string $fio_candidat
 * @property string $phone_candidat
 * @property int $age_candidat
 * @property string $city_candidat
 * @property string $region
 * @property string $town
 * @property string $market
 * @property string $name_vacancy
 * @property string $comment
 * @property string $source
 * @property string $date_create
 */
class Forms extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'forms';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['age_candidat'], 'integer'],
            [['date_create'], 'safe'],
            [['sid', 'fio_candidat', 'phone_candidat', 'city_candidat', 'region', 'town', 'market', 'name_vacancy', 'comment', 'source'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sid' => 'Sid',
            'fio_candidat' => 'Fio Candidat',
            'phone_candidat' => 'Phone Candidat',
            'age_candidat' => 'Age Candidat',
            'nation_candidat' => 'Nation Candidat',
            'city_candidat' => 'City Candidat',
            'region' => 'Region',
            'town' => 'Town',
            'market' => 'Market',
            'name_vacancy' => 'Name Vacancy',
            'comment' => 'Comment',
            'source' => 'Source',
            'date_create' => 'Date Create',
        ];
    }
}
