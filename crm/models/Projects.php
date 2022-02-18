<?php

namespace app\models;

use Yii;
use app\models\Tasks;
use app\models\Companies;

/**
 * This is the model class for table "projects".
 *
 * @property int $id
 * @property int $id_company
 * @property string $name
 * @property double $cost
 * @property int $source
 * @property int $stage
 * @property string $comment
 * @property string $date_crate
 */
class Projects extends \yii\db\ActiveRecord
{

    public static $stageCodes = array(
        0 => "Новый проект",
        10 => "Тестирование",
        20 => "Согласование решения",
        30 => "Ждем бюджет / план-график",
        40 => "ТЗ",
        50 => "Успешно реализован",
        60 => "Закрыто, потерян",
    );

    public static $sourcesCodes = array(
        0 => "Актив",
        10 => "Вендор",
        20 => "Сайт",
    );

    public static function getStage($id_code){
        $arr = self::$stageCodes;
        if(isset($arr[$id_code])){
            return $arr[$id_code];
        }else{
            return 'Не определен';
        }
    }

    public static function getSource($id_code){
        $arr = self::$sourcesCodes;
        if(isset($arr[$id_code])){
            return $arr[$id_code];
        }else{
            return 'Не определен';
        }
    }

    /*
    static $MES_STATUS_UNREAD  = 0;
    static $MES_STATUS_READ    = 1;
    static $MES_STATUS_STAR    = 2;
    static $MES_STATUS_ARCHIVE = 3;
    */

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'projects';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_company', 'name', 'source', 'stage'], 'required'],
            [['id_company', 'source', 'stage'], 'integer'],
            [['cost'], 'number'],
            [['comment'], 'string'],
            [['date_crate'], 'safe'],
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
            'id_company' => 'Id Company',
            'name' => 'Название',
            'cost' => 'Стоимость',
            'source' => 'Источник',
            'stage' => 'Этап',
            'comment' => 'комментарий',
            'date_crate' => 'Date Crate',
        ];
    }

    public function getTasks()
    {
        return $this->hasMany(Tasks::className(), ['id_project' => 'id']);
    }

    public function getTasksName() {
        $tasks = $this->tasks;
        $task = '';
        $eol='
        ';

        if(is_array($tasks)){
            foreach ($tasks as $item) {
                $task .= $item->name . ' ' . $item->date_task.$eol.$eol;
            }
        }else{
            return 'Не указаны';
        }

        return $task;
    }

    public function getCompany()
    {
        return $this->hasOne(Companies::className(), ['id' => 'id_company']);
    }
}
