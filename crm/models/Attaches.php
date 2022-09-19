<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "attaches".
 *
 * @property int $id
 * @property int $id_task
 * @property string $file_name
 * @property string $server_file_name
 * @property int $user_id
 * @property string $date_create
 */
class Attaches extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'attaches';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_task', 'file_name', 'server_file_name', 'user_id'], 'required'],
            [['id_task', 'user_id'], 'integer'],
            [['date_create'], 'safe'],
            [['file_name', 'server_file_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_task' => 'Id Task',
            'file_name' => 'File Name',
            'server_file_name' => 'server_file_name',
            'user_id' => 'User ID',
            'date_create' => 'Date Create',
        ];
    }
}
