<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "companies".
 *
 * @property int $id
 * @property string $name
 * @property string $inn
 * @property string $kpp
 * @property string $address
 * @property string $comment
 * @property string $date_create
 */
class Companies extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'companies';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['address', 'comment'], 'string'],
            [['date_create'], 'safe'],
            [['name'], 'string', 'max' => 300],
            [['inn', 'kpp'], 'string', 'max' => 50],
			[['inn'], 'unique'],
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
            'inn' => 'ИНН',
            'kpp' => 'КПП',
            'address' => 'Адрес',
            'comment' => 'Комментарий',
            'date_create' => 'Date Create',
        ];
    }
}
