<?php

namespace app\models;

use Yii;
use app\models\Companies;

/**
 * This is the model class for table "contacts".
 *
 * @property int $id
 * @property int $id_company
 * @property string $fio
 * @property string $phones
 * @property string $emails
 * @property string $post
 * @property string $date_create
 */
class Contacts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contacts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_company', 'fio'], 'required'],
            [['id_company'], 'integer'],
            [['date_create'], 'safe'],
            [['fio', 'post'], 'string', 'max' => 200],
            [['phones', 'emails'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_company' => 'Id Company',
            'fio' => 'ФИО',
            'phones' => 'Телефоны',
            'emails' => 'Электронная почта',
            'post' => 'Должность',
            'date_create' => 'Date Create',
        ];
    }

    public function getCompany()
    {
        return $this->hasOne(Companies::className(), ['id' => 'id_company']);
    }

    /* Геттер для названия адреса */
    public function getCompanyName() {
        return $this->company->name;
    }
}
