<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use app\models\Attaches;


class UploadForm extends Model
{
    /**
     * @var UploadedFile|Null file attribute
     */
    public $file;
    public $imageFiles;
    public $task_id;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'maxFiles' => 10], // <--- здесь!
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            foreach ($this->imageFiles as $file) {
               //if($file->saveAs('../uploads/' . $file->baseName . '.' . $file->extension)){
                $server_file_name = rand().'_'.time() . '.' . $file->extension;
                if($file->saveAs('../uploads/' . $server_file_name)){
                    $attach = new Attaches();
                    $attach->id_task = $this->task_id;
                    $attach->file_name = $file->baseName . '.' . $file->extension;
                    $attach->server_file_name = $server_file_name;
                    $attach->user_id = Yii::$app->user->identity->id;
                    if(!$attach->save()){
                        return serialize($attach->errors);
                    }

               }else{
                   return 'Ошибка при загрузке файла: '.$file->baseName . '.' . $file->extension;
               }
            }
            return true;
        } else {
            return 'Ошибка при валидации загружаемых файлов.';
        }
    }
}

?>