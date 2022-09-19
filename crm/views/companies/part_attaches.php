<?php
use yii\helpers\Html;
use app\models\Attaches;
use yii\bootstrap\ActiveForm;
use app\models\UploadForm;
use yii\web\UploadedFile;
use yii\widgets\Pjax;

    if($attaches) {?>
        <div id="attaches_task_<?=$task_id?>">
                <?php
                    echo \Yii::$app->view->renderFile('@app/views/companies/part_attaches_list_files.php', [
                        'attaches' => $attaches,
                        'task_id' => $task_id
                    ]);
                ?>
        </div>
    <?php }else{
        //echo '<div>Задачи пока что отсутствуют</div>';
    }?>

    <?php
    /*
        $script =" alert('asdsadsad');
        $('#form_'".$task_id.").submit(function(e){
            var formData = new FormData($(this)[0]);  
                  
            $.ajax({
                type: 'post',
                url:'/softprog.ru/crm/attaches/upload',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                        alert('asdsad');                     
                     render_attaches(".$task_id.");//Обновление списка файлов
                }
            })  
            e.preventDefault();
             
            return false;
        });
      ";

        $this->registerJs($script, $position = $this::POS_READY, $key = null);

*/
    ?>

    <form id="form_<?=$task_id;?>" enctype="multipart/form-data">
        <input id="task_id" type="hidden" name="task_id"  value="<?=$task_id;?>" />
        <input id="myFiles" type="file" name="UploadForm[imageFiles][]" multiple="true"/>
        <input type="submit" value="Загрузить">
    </form>

    <script>
        $('#form_<?=$task_id;?>').submit(function(e){
        var formData = new FormData($(this)[0]);
        var form = $(this)[0];

        $.ajax({
            type: 'post',
            url:'/softprog.ru/crm/attaches/upload',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                if(data == 'ok'){
                    $('#status').html('<p style="color: green";>Файл успешно загружен</p>');
                    form.reset();
                    render_attaches(<?=$task_id;?>);//Обновление списка файлов
                }else{
                    $('#status').html('<p style="color: red";>'+data+'</p>');
                }
            }
            });

        e.preventDefault();

        return false;
        });
    </script>


