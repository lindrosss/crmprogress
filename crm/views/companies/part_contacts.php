<?php
use yii\helpers\Html;

    if($contacts) {
        foreach ($contacts as $item) {?>
            <div class="contact_item item">
                <div>
                    <input id_item="<?php echo $item->id;?>" field_name="fio" class="fio" value="<?php echo $item->fio; ?>"/>
                    <div style="display: none;" id_item_fio="<?php echo $item->id;?>" controller_name="contacts" field_name="fio" class="save_btn">ok</div>
                </div>

                <div>
                    <input id_item="<?php echo $item->id;?>" field_name="phones" class="phones" value="<?php echo $item->phones; ?>"/>
                    <div style="display: none;" id_item_phones="<?php echo $item->id;?>" controller_name="contacts" field_name="phones" class="save_btn">ok</div>
                </div>

                <div>
                    <input id_item="<?php echo $item->id;?>" field_name="emails" class="emails" value="<?php echo $item->emails; ?>"/>
                    <div style="display: none;" id_item_emails="<?php echo $item->id;?>" controller_name="contacts" field_name="emails" class="save_btn">ok</div>
                </div>

                <div>
                    <input id_item="<?php echo $item->id;?>" field_name="post" class="post" value="<?php echo $item->post; ?>"/>
                    <div style="display: none;" id_item_post="<?php echo $item->id;?>" controller_name="contacts" field_name="post" class="save_btn">ok</div>
                </div>

            </div>
        <?php }
    }else{
        echo '<div>Контакты пока что отсутствуют</div>';
    }
?>