<?php

    if($attaches) {?>
            <div class="table">
                <?php foreach ($attaches as $item) { ?>
                        <div class="attaches_item item table-row">
                            <div class="table-cell">
                                <a target="_blank" href="../attaches/downloadfile?sfile=<?php echo $item['server_file_name'];?>&file=<?php echo $item['file_name'];?>">
                                    <?php echo $item['file_name'];?>
                                </a>
                            </div>
                            <div class="table-cell">
                                <div onclick="delete_attache($(this));" title="Удалить файл" class="delete_attache" id_attache="<?=$item['id'];?>" server_file_name="<?=$item['server_file_name'];?>" task_id="<?=$task_id?>">х</div>
                            </div>
                            <div class="table-cell">
                            </div>
                        </div>
                <?php }?>
            </div>
    <?php }else{
        //echo '<div>Задачи пока что отсутствуют</div>';
    }?>




