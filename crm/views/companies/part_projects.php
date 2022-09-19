<?php
use yii\helpers\Html;
use app\models\Projects;
use app\models\Tasks;
use yii\helpers\Url;

use yii\bootstrap\Modal;

    if($projects) {?>

        <div id="" class="table">
            <?php foreach ($projects as $item) { ?>
                <div class="table-cell">
                    <div class="project_item item">
                        <div>
                            <input id_item="<?php echo $item->id;?>" field_name="name" class="name" value="<?php echo $item->name; ?>"/>
                            <div style="display: none;" id_item_name="<?php echo $item->id;?>" controller_name="projects" field_name="name" class="save_btn">ok</div>
                        </div>

                        <div>
                            <input id_item="<?php echo $item->id;?>" field_name="cost" class="cost" value="<?php echo $item->cost; ?>"/>
                            <div style="display: none;" id_item_cost="<?php echo $item->id;?>" controller_name="projects" field_name="cost" class="save_btn">ok</div>
                        </div>

                        <p class="label_project">Этап:</p>
                        <div>
                            <select onchange="updateField($(this), 'select')" field_name="stage" id_item_stage="<?php echo $item->id;?>" controller_name="projects">
                                <?php
                                    $arr = Projects::$stageCodes;
                                    foreach ($arr as $key => $value ){
                                        $selected = ($key == $item->stage) ? 'selected="selected"' : '';
                                        echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                                    }
                                ?>
                            </select>
                        </div>

                        <p class="label_project">Источник:</p>
                        <div>
                            <select onchange="updateField($(this), 'select')" field_name="source" id_item_source="<?php echo $item->id;?>" controller_name="projects">
                                <?php
                                $arr = Projects::$sourcesCodes;
                                foreach ($arr as $key => $value ){
                                    $selected = ($key == $item->source) ? 'selected="selected"' : '';
                                    echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <br/>
                    </div>
                    <?php
                        Modal::begin([
                            'header' => '<h2>Создать Комментарий</h2>',
                            'toggleButton' => ['label' => 'Комментарий +', 'class'=>'btn btn-success'],
                            'closeButton' => ['id' => 'close-button'],
                            'options' => [
                                'id' => 'task_modal_'.$item->id,
                                'class' => 'task_modal',
                                'tabindex' => false // important for Select2 to work properly
                            ],
                        ]);

                        $model_task = new Tasks();
                        //$get = Yii::$app->request->get();
                        $model_task->id_project = $item->id;
                        echo \Yii::$app->view->renderFile('@app/views/tasks/_form.php', [
                            'model' => $model_task,
                            // 'form_begin' => ['action'=>Url::base().'/contacts/create_without_redirect', 'id'=>'create_contact'],
                            'form_begin' => ['id'=>'create_task_'.$item->id, 'action'=>Url::base().'/tasks/create_without_redirect'],
                            'id_project' => $item->id

                        ]);

                        Modal::end();
                    ?>
                    <div class="id_project" id_project="<?php echo $item->id;?>" style="display: none"><?php echo $item->id;?></div>
                </div>
            <?php }?>
        </div>
    <?php }else{
        echo '<div>Проекты пока что отсутствуют</div>';
    }
?>