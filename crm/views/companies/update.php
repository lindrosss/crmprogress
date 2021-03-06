<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;

use app\models\Contacts;
use app\models\Projects;
use app\models\Tasks;

/* @var $this yii\web\View */
/* @var $model app\models\Companies */

$this->title = 'Редактировать компанию: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Компании', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="companies-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
        $model_company = $model;
        $id_company = $model->id;
    ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
	
	<br/><br/>
	<h2>Контакты</h2>
	<?php	Modal::begin([ 
				'header' => '<h2>Создать Контакт</h2>',
				'toggleButton' => ['label' => 'Создать контакт', 'class'=>'btn btn-success'],
				'closeButton' => ['id' => 'close-button'], 
				'options' => [
					'id' => 'kartik-modal',
					'tabindex' => false // important for Select2 to work properly
				],
			]); 
			
			$model = new Contacts();
			$get = Yii::$app->request->get();
			$model->id_company = $get['id'];
			echo \Yii::$app->view->renderFile('@app/views/contacts/_form.php', [
				'model' => $model,
                'form_begin' => ['action'=>Url::base().'/contacts/create_without_redirect'],

			]);
			
			Modal::end();
	?>
	
	<?= GridView::widget([
        'dataProvider' => $dataProviderContacts,
        'filterModel' => $searchModelContacts,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'fio',
            'phones',
            'emails',
            'post',
			[
                'label' => 'Действия',
                'format' => 'raw',
                'value' => function($data)  {
                    $str ='';
                    $str .= Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                        Url::to(['contacts/update', 'id'=>$data->id],[]),
                        [
                            'title' => 'Редактировать контакт',
                            'aria-label' => 'Редактировать контакт',
							'target' => 'blank',
                            'data-method' => 'post',
                        ]
                    ).'&nbsp&nbsp';
					
					return $str;
				}
			]	
            //'address:ntext',
            //'comment:ntext',
            //'date_create',

           // ['class' => 'yii\grid\ActionColumn'],
		   
        ],
    ]); ?>


    <br/><br/>
    <h2>Проекты</h2>
    <?php	Modal::begin([
        'header' => '<h2>Создать Проект</h2>',
        'toggleButton' => ['label' => 'Создать проект', 'class'=>'btn btn-success'],
        'closeButton' => ['id' => 'close-button'],
        'options' => [
            'id' => 'create_project',
            'tabindex' => false // important for Select2 to work properly
        ],
    ]);

        $model = new Projects();
        //$get = Yii::$app->request->get();
        $model->id_company = $get['id'];
        echo \Yii::$app->view->renderFile('@app/views/projects/_form.php', [
            'model' => $model,
            'form_begin' => ['action'=>Url::base().'/projects/create_without_redirect'],
        ]);

    Modal::end();
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProviderProjects,
        'filterModel' => $searchModelProjects,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'cost',
          //  'stage',

            [
                'format' => 'raw',
                'attribute' => 'stage',
                'value' => function($data)  {
                    return Projects::getStage($data->stage);
                }
            ],

            [
                'format' => 'raw',
                'attribute' => 'source',
                'value' => function($data)  {
                    return Projects::getSource($data->source);
                }
            ],

            [
                'label' => 'История',
                'attribute' => 'tasksname',
                'format' => 'raw',
            ],

            'comment:ntext',

            [
                'label' => 'Создать задачу',
                'format' => 'raw',
                'value' => function($data) use($model_company) {
                    return \Yii::$app->view->renderFile('@app/views/tasks/create_modal.php', [
                        'model_company' => $model_company,
                        //'form_begin' => ['action'=>'/softprog.ru/crm/tasks/create_without_redirect',],
                        'id_project' => $data->id
                    ]);
                }
            ],

            //'source',
            [
                'label' => 'Действия',
                'format' => 'raw',
                'value' => function($data) {
                    $str ='';
                    $str .= Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                            Url::to(['projects/update', 'id'=>$data->id],[]),
                            [
                                'title' => 'Редактировать проект',
                                'aria-label' => 'Редактировать проект',
                                'target' => 'blank',
                                'data-method' => 'post',
                            ]
                        ).'&nbsp&nbsp';

                    return $str;
                }
            ]
            //'address:ntext',

            //'date_create',

            // ['class' => 'yii\grid\ActionColumn'],

        ],
    ]); ?>
	
	
		
	
	

</div>
