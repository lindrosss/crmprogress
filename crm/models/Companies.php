<?php

namespace app\models;

use Yii;
use app\models\Contacts;

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
 * @property string $contactsname
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

    public function getContacts()
    {
        return $this->hasMany(Contacts::className(), ['id_company' => 'id']);
    }

    /* Геттер для названия адреса */
    public function getContactsName() {

        $contacts = $this->contacts;
        //return var_dump($contacts);
        $contact = '';
        $eol='
        ';


        if(is_array($contacts)){
            foreach ($contacts as $item) {
                $contact .= $item->post . ' ' . $item->fio . ' ' . $item->phones . ' ' . $item->emails .$eol.$eol;
            }
        }else{
            return 'empty';
        }
        return $contact;
    }
}
