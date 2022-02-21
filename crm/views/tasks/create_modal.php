<?php

use yii\helpers\Html;
use app\models\Tasks;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Tasks */

$this->title = 'Создать задачу к проекту '.$id_project;

Modal::begin([
    'header' => '<h2>'.$this->title.'</h2>',
    'toggleButton' => ['label' => $this->title, 'class'=>'btn btn-success'],
    'closeButton' => ['id' => 'close-button'],
    'options' => [
        'id' => 'create_task_'.$id_project,
        'tabindex' => false // important for Select2 to work properly
    ],
]);

    $model = new Tasks();
    $model->id_project = $id_project;

    echo \Yii::$app->view->renderFile('@app/views/tasks/_form.php', [
        'model' => $model,
        'id_company' => $model_company->id,
        'id_project' => $id_project,
        'form_begin' => ['action'=>Url::base().'/tasks/create_without_redirect'],
    ]);

Modal::end();
?>



