<?php
use yii\helpers\Html;
use app\models\Attaches;
use yii\bootstrap\ActiveForm;

    if($tasks) {?>

            <?php foreach ($tasks as $item) { ?>
                    <div class="tasks_item item">
                        <div>
                            <textarea contenteditable="true" id_item="<?php echo $item->id;?>" field_name="name" class="name" ><?php echo $item->name; ?></textarea>
                            <div style="display: none;" onclick="updateField($(this), 'textarea')" id_item_name="<?php echo $item->id;?>" controller_name="tasks" field_name="name" class="save_btn">ok</div>
                        </div>

                        <?php //if($item->date_task != '0000-00-00 00:00:00'){ ?>
                        <?php if($item->date_task){
                            $date_value = date('Y-m-d', strtotime($item->date_task));
                            ?>

                            <input onchange="updateField($(this), 'dateinput')" id_item_date_task="<?php echo $item->id;?>" controller_name="tasks" field_name="date_task" class="name" value="<?php echo $date_value; ?>" type="date" />
                            <div style="display: none;" id_item_name="<?php echo $item->id;?>" controller_name="tasks" field_name="date_task" class="save_btn">ok</div>

                            <?php
                            $attaches = Attaches::find()->where(['id_task'=>$item->id])->asArray()->all();
                            echo \Yii::$app->view->renderFile('@app/views/companies/part_attaches.php', [
                                 'task_id' => $item->id,
                                 'attaches' => $attaches,
                            ]);
                            ?>

                        <?php }?>
                    </div>
                    <br/>
            <?php }?>
    <?php }else{
        echo '<div>Задачи пока что отсутствуют</div>';
    }
?>