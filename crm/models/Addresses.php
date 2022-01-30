<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "addresses".
 *
 * @property int $id
 * @property string $name
 * @property int $id_updator
 * @property int $is_public
 * @property string $date_update
 */
class Addresses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'addresses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'id_updator', 'date_update'], 'required'],
            [['id_updator', 'is_public'], 'integer'],
            [['date_update'], 'safe'],
            [['name'], 'string', 'max' => 500],
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
            'id_updator' => 'Id Updator',
            'date_update' => 'Date Update',
            'is_public' => 'Опубликован',
        ];
    }
}
