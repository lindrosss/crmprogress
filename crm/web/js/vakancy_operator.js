
//var jsPath = window.location.origin + "/fresh_hub/";
var jsPath = window.location.origin + "/fresh/";

$( document ).ready(function() {
    $.ajaxSetup ({
        // Disable caching of AJAX responses
        cache: false
    });

    //$('nav#w0, ul.breadcrumb').css('display', 'none');
    //$('div.container').css('padding-top', '0');
    //$('div.container').css('margin-left', '5px');

    getSourcesByMarketsId(4);

    $('#info_fio_candidat').change(function() {
        $('#create_candidat #fio_candidat').val($('#info_fio_candidat').val());
    });

    $('#info_phone_candidat').change(function() {
        $('#create_candidat #phone_candidat').val($('#info_phone_candidat').val());
    });

    $('#info_age_candidat').change(function() {
        $('#create_candidat #age_candidat').val($('#info_age_candidat').val());
    });

    $('#markets-id').change(function() {
        getTimetablesByMarketsId(this.value);
        //getSourcesByMarketsId(this.value);
    });


    $('.set_vacancy_to_market').click(function() {
        var id_market = $('#markets-id').val();
        var id_vacancy = $(this).attr('id_vacancy');

        $.ajax({
            url: jsPath + "vacancies/setvacancytomarket",
            type: "POST",
            data:  {id_market:id_market, id_vacancy:id_vacancy },
            success: function(data){
                //$("#timetables_market").html(data);
                //alert('error '+ data);
                $("#vacancies_list").html(data);
                /*
                $("#vacancies_list_in_market td.clickable").click(function() {
                                            clickOnVacancy($(this).attr("id_row"));
                                        });	*/
            }
        });

        //alert(id_market+' '+id_vacancy);
    });

    $('.set_source_to_market').click(function() {
        var id_market = $('#markets-id').val();
        var id_source = $(this).attr('id_source');

        $.ajax({
            url: jsPath + "vacancies/setsourcetomarket",
            type: "POST",
            data:  {id_market:id_market, id_source:id_source },
            success: function(data){
                //$("#timetables_market").html(data);
                //alert('error '+ data);
                $("#sources_market").html(data);
                /*
                $("#vacancies_list_in_market td.clickable").click(function() {
                                            clickOnVacancy($(this).attr("id_row"));
                                        });	*/
            }
        });

        //alert(id_market+' '+id_vacancy);
    });


    $('#timetable_list_in_market tr').click(function() {
        alert('asdasdasdasd');
    });

    /*Отправка SMS*/
    $('#btn_send_sms').click(function() {
        var phone = $('#create_candidat #phone_candidat').val();

        if(phone.length == 11 && phone.charAt(0) == 8){
            temp_str = phone.substr(1, 10);
            phone = '7'+temp_str;

            var fio = $('#create_candidat #fio_candidat').val();
            var address = $('span#address_timetable').text();
            var date = $('span#date_timetable').text();

            var is_zum = $('span#is_zum').text();
            if(is_zum == "1"){
                var sms_text = "Ждем Ваше резюме на адрес resume@rabota-da.com, Сеть магазинов \"ДА!\"";
            }else{
                var sms_text = fio+', Вы записаны на собеседование:'+' '+date+', по адресу:'+' '+address + '. По всем вопросам обращайтесь по номеру 8-800-500-27-55. Сеть магазинов \"ДА!\"';
            }

            //$('#sms_result').text(sms_text);

            $.ajax({
                url: "https://webkc.ad.kellykc.ru/kernel/smshistory/sendsmsprofi",
                type: "POST",
                data:  { 'phone': phone
                    ,'textsms':sms_text
                    ,'id_campaign':12
                },
                success: function(msg){
                    $('#sms_result').text(msg);
                    $('#btn_send_sms').css('display', 'none');
                }
            });
        }else{
            $('#sms_result').text('Некорректный номер телефона');
        }

    });
});

function clickOnTimeTableInMarket(id_row){
    alert('asdasdasdasd');
}

function clickOnVacancy(id_row){

    $('#vacancies_list_in_market tr').removeClass('selected');
    $('#vacancies_list_in_market tr[id_row="'+id_row+'"]').addClass('selected');
    //alert('#vacancies_list_in_market tr[id_row="'+id_row+'"]');

    $.ajax({
        url: jsPath + "vacanciesoperator/gettimetablesbyvakancysid",
        type: "POST",
        data:  {id_vacancy:id_row },
        success: function(data){
            $("#timetables_vacancy").html(data);
            /*
            $("#vacancies_list_in_market td.clickable").click(function() {
                    clickOnVacancy($(this).attr("id_row"));
            });*/
        }
    });


}

function del_vakancy_from_market(Element){
    //alert(Element.attr("id_row"));


    id_row = Element.attr("id_row");
    id_market = $('#markets-id').val();
    $.ajax({
        url: jsPath + "vacancies/del_vacancy_from_market",
        type: "POST",
        data:  {id_row:id_row,  id_market:id_market},
        success: function(data){
            $("#vacancies_list").html(data);
            $("#vacancies_list_in_market td.clickable").click(function() {
                clickOnVacancy($(this).attr("id_row"));
            });
        }
    });
}

/*Затирает расписания и список вакансий при смене Региона, города, маркета*/
function clearOptions(){

    $("#vacancies_list").html('<span class="gray">Необходимо выбрать <u>Магазин</u></span>');
    $("#timetables_market").html('<span class="gray">Необходимо выбрать <u>Магазин</u></span>');
    $("#timetables_vacancy").html('<span class="gray">Необходимо выбрать <u>Вакансию</u></span>');
    $("#all_vacansieslist").css('display','none');
    $("#all_sourceslist").css('display','none');

}

function vacancy_create() {
    var vacancy_name = $('#create_vacancy #name_vacancy').val();
    var vacancy_info = $('#create_vacancy #info_vacancy').val();
    error_flag = false;

    if(vacancy_name == ''){
        $('#create_vacancy #name_vacancy').addClass('error_field');
        error_flag = true;
    }else{
        $('#create_vacancy #name_vacancy').removeClass('error_field');
    }

    if(vacancy_info == ''){
        $('#create_vacancy #info_vacancy').addClass('error_field');
        error_flag = true;
    }else{
        $('#create_vacancy #info_vacancy').removeClass('error_field');
    }

    if(!error_flag){
        $.ajax({
            url: jsPath + "vacancies/createwithoutredirect",
            type: "POST",
            data:  {vacancy_name:vacancy_name, vacancy_info:vacancy_info },
            success: function(data){
                if(data == 1){
                    $("#create_vacancy #result").html('<p>Вакансия успешно создана.</p>');
                    $('#create_vacancy #name_vacancy').val('');
                    $('#create_vacancy #info_vacancy').val('');
                    $.pjax.reload({container:'#pjax_1'});

                }else{
                    $("#create_vacancy #result").html('<p>При создании вакансии произошла ошибка.</p>');

                }
            }
        });
    }
}

function timetable_for_market_create() {
    var id_market = $('#markets-id').val();
    var date_interview = $('#create_time_table_for_market #timetable_for_market').val();
    var quota = $('#create_time_table_for_market #timetable_quota_for_market').val();
    var id_address = $('select#address').val();
    error_flag = false;



    if(date_interview == ''){
        $('#create_time_table_for_market #timetable_for_market').addClass('error_field');
        error_flag = true;
    }else{
        $('#create_time_table_for_market #timetable_for_market').removeClass('error_field');
    }

    if(quota == ''){
        $('#create_time_table_for_market #timetable_quota_for_market').addClass('error_field');
        error_flag = true;
    }else{
        $('#create_time_table_for_market #timetable_quota_for_market').removeClass('error_field');
    }

    if(id_address == ''){
        $('#create_time_table_for_market div#address_block').addClass('error_field');
        error_flag = true;
    }else{
        $('#create_time_table_for_market div#address_block').removeClass('error_field');
    }

    if(!error_flag){
        $.ajax({
            url: jsPath + "vacancies/create_time_table_for_market",
            type: "POST",
            data:  {id_market:id_market,
                date_interview:date_interview,
                id_address: id_address,
                quota:quota
            },
            success: function(id_market){
                if(id_market > 0){
                    $("#create_time_table_for_market #result").html('<p>Расписание успешно создано.</p>');
                    $('#create_time_table_for_market #timetable_for_market').val('');
                    $('#create_time_table_for_market #timetable_quota_for_market').val('');
                    //$.pjax.reload({container:'#pjax_1'});
                    getTimetablesByMarketsId(id_market)

                }else{
                    $("#create_time_table_for_market #result").html('<p>При создании расписания произошла ошибка.</p>');

                }
            }
        });
    }

    //alert(id_market + ' '+date_interview + ' ' + quota);
}

function timetable_for_vacancy_create() {
    var id_vacancy = $('#vacancies_list_in_market tr.selected').attr("id_row");
    var date_interview = $('#create_time_table_for_vacancy #timetable_for_vacancy').val();
    var quota = $('#create_time_table_for_vacancy #timetable_quota_for_vacancy').val();
    var id_address = $('#create_time_table_for_vacancy select#address2').val();
    error_flag = false;

    if(date_interview == ''){
        $('#create_time_table_for_vacancy #timetable_for_vacancy').addClass('error_field');
        error_flag = true;
    }else{
        $('#create_time_table_for_vacancy #timetable_for_vacancy').removeClass('error_field');
    }

    if(quota == ''){
        $('#create_time_table_for_vacancy #timetable_quota_for_vacancy').addClass('error_field');
        error_flag = true;
    }else{
        $('#create_time_table_for_vacancy #timetable_quota_for_vacancy').removeClass('error_field');
    }

    if(id_address == ''){
        $('#create_time_table_for_vacancy div#address_block').addClass('error_field');
        error_flag = true;
    }else{
        $('#create_time_table_for_vacancy div#address_block').removeClass('error_field');
    }

    if(!error_flag){
        $.ajax({
            url: jsPath + "vacancies/create_time_table_for_vacancy",
            type: "POST",
            data:  {id_vacancy:id_vacancy,
                date_interview:date_interview,
                quota:quota,
                id_address: id_address,
            },
            success: function(id_vacancy){
                if(id_vacancy > 0){
                    $("#create_time_table_for_vacancy #result").html('<p>Расписание успешно создано.</p>');
                    $('#create_time_table_for_vacancy #timetable_for_vacancy').val('');
                    $('#create_time_table_for_vacancy #timetable_quota_for_vacancy').val('');
                    //$.pjax.reload({container:'#pjax_1'});
                    clickOnVacancy(id_vacancy);

                }else{
                    $("#create_time_table_for_vacancy #result").html('<p>При создании расписания произошла ошибка.</p>');

                }
            }
        });
    }

    //alert(id_market + ' '+date_interview + ' ' + quota);
}

/*Создание Источника информации*/
function source_create() {
    var source_name = $('#create_source #name_source').val();

    error_flag = false;

    if(source_name == ''){
        $('#create_source #name_source').addClass('error_field');
        error_flag = true;
    }else{
        $('#create_source #name_source').removeClass('error_field');
    }

    if(!error_flag){
        $.ajax({
            url: jsPath + "sources/createwithoutredirect",
            type: "POST",
            data:  {source_name:source_name},
            success: function(data){
                if(data == 1){
                    $("#create_source #result").html('<p>Вакансия успешно создана.</p>');
                    $('#create_source #name_source').val('');

                    $.pjax.reload({container:'#pjax_2'});
                }else{
                    $("#create_source #result").html('<p>При создании источника произошла ошибка.</p>');
                }
            }
        });
    }
}

function getTimetablesByMarketsId(id_market){
    $.ajax({
        url: jsPath + "vacanciesoperator/gettimetablesbymarketsid",
        type: "POST",
        data:  {id_market:id_market },
        success: function(data){
            $("#timetables_market").html(data);


        }
    });
}

function open_create_candidat(id_time_table, metod_for, rezerv, is_zum){

    if(metod_for == 'market'){
        var date_timetable = $('#timetable_list_in_market td[id_row="'+id_time_table+'"].date_timetable_in_market').text();
    }

    if(metod_for == 'vacancy'){
        var date_timetable = $('#timetable_list_in_vacancy td[id_row="'+id_time_table+'"].date_timetable_in_vacancy').text();
    }

    var address_timetable = $('#timetable_list_in_vacancy td[id_row="'+id_time_table+'"].address_timetable_in_vacancy').text();

    $('span#date_timetable').text(date_timetable);
    $('span#address_timetable').text(address_timetable);
    $('#create_candidat #btn_create').attr("id_timetable", id_time_table);
    $('#create_candidat #btn_create').attr("rezerv", rezerv);
    $('#create_candidat #btn_create').attr("is_zum", is_zum);
    $('#create_candidat #btn_create').attr("id_vacancy", $('#vacancies_list_in_market tr.selected').attr("id_row"));
    $('h3#vakancy_name_tittle').text($('#vacancies_list_in_market tr.selected td:first').text())

    $('#create_candidat').fadeIn();
}

function create_candidat(Element){
    var fio_candidat = $('#fio_candidat').val();
    var phone_candidat = $('#phone_candidat').val();
    var age_candidat = $('#age_candidat').val();
    var nation = $('#nation_candidat').val();
    var id_source = $('#sources_list_in_market').val();
    var comment = $('#comment').val();
    var id_time_table = Element.attr("id_timetable");
    var rezerv = Element.attr("rezerv");
    var is_zum = Element.attr("is_zum");
    //var id_vacancy_in_market = $('#vacancies_list_in_market tr.selected').attr("id_row");
    var id_vacancy_in_market = Element.attr("id_vacancy");
    var id_candidat = Element.attr("id_candidat");

    if(id_time_table == ''){
        id_time_table = -1;
    }

    error_flag = false;
    var_error_msg = '';

    if(fio_candidat == ''){
        $('#create_candidat #fio_candidat').addClass('error_field');
        error_flag = true;
        var_error_msg = var_error_msg + '<p style="color: RED"> Не заполнена <b>Фамилия</b> кандидата</p>';
    }
    else{
        $('#create_candidat #fio_candidat').removeClass('error_field');
    }

    if(phone_candidat == ''){
        $('#create_candidat #phone_candidat').addClass('error_field');
        error_flag = true;
        var_error_msg = var_error_msg + '<p style="color: RED"> Не заполнен <b>Телефон</b> кандидата</p>';
    }
    else{
        $('#create_candidat #phone_candidat').removeClass('error_field');
    }

    if(age_candidat == ''){
        $('#create_candidat #age_candidat').addClass('error_field');
        error_flag = true;
        var_error_msg = var_error_msg + '<p style="color: RED"> Не заполнен <b>Возраст</b> кандидата</p>';
    }
    else{
        $('#create_candidat #age_candidat').removeClass('error_field');
    }

    if(id_source == 0){
        $('#info_candidat #sources_list_in_market').addClass('error_field');
        error_flag = true;
        var_error_msg = var_error_msg + '<p style="color: RED"> Не заполнен <b>Источник информации</b> (в самом верху анкеты)</p>';
    }
    else{
        $('#info_candidat #sources_list_in_market').removeClass('error_field');
    }

    if(!error_flag){
        $.ajax({
            url: jsPath + "vacanciesoperator/createcandidate",
            type: "POST",
            data:  { fio_candidat:fio_candidat
                ,phone_candidat:phone_candidat
                ,age_candidat:age_candidat
                ,nation: nation
                ,id_source:id_source
                ,comment:comment
                ,id_time_table:id_time_table
                ,rezerv: rezerv
                ,is_zum: is_zum
                ,id_vacancy_in_market:id_vacancy_in_market
                ,id_candidat:id_candidat

            },
            success: function(data){
                if(data == 1 || data == 2){
                    $("#create_candidat #result").html('<p style="color: Green;">Кандидат успешно записан на собеседование.</p>');
                    $("#result_text").css('display', 'block');
                    var id_vacancy = $('#vacancies_list_in_market tr.selected').attr("id_row");
                    clickOnVacancy(id_vacancy);
                    save_form();
                    rezerv = $('#btn_create').attr("rezerv");
                    if(rezerv == 0 || data == 2){
                        /*Отображение блока закрыто до подписания договора с SMS оператором*/
                        $("#send_sms_block").css('display', 'block');
                        if(data == 2){
                            $('span#is_zum').text('1');
                        }
                    }
                    //cancel_candidat(1500);
                    $('#btn_create').fadeOut(350);

                }else{
                    $("#create_candidat #result").html('<p style="color: Red;">При создании кадидата произошла ошибка. '+data+'</p>');
                }
            }
        });
    }else {
        $("#create_candidat #result").html(var_error_msg);
    }
}

function save_form(){
    var sid = $('#info_sid').val();

    if($('#fio_candidat').val() == ''){
        var fio_candidat = $('#info_fio_candidat').val();
    }else{
        var fio_candidat = $('#fio_candidat').val();
    }

    var phone_candidat = $('#info_phone_candidat').val();
    var age_candidat = $('#info_age_candidat').val();
    var nation_candidat = $('#info_nation_candidat').val();
    var city_candidat = $('#info_city_candidat').val();

    var region = $('#region option:selected').text();
    var town = $('#towns-id option:selected').text();
    var market = $('#markets-id option:selected').text();
    var name_vacancy = $('#vacancies_list_in_market tr.selected td.name_vacancy').text();
    var comment = $('#comment').val();

    var source = $('#sources_list_in_market option:selected').text();

    var failure_client = $('#failure_client').val();
    var failure_fresh = $('#failure_fresh').val();

    //var method = Element.attr("method");

    $.ajax({
        url: jsPath + "vacanciesoperator/saveform",
        type: "POST",
        data:  { sid:sid
            ,fio_candidat:fio_candidat
            ,phone_candidat:phone_candidat
            ,age_candidat:age_candidat
            ,nation_candidat:nation_candidat
            ,city_candidat: city_candidat
            ,region:region
            ,town:town
            ,market:market
            ,name_vacancy:name_vacancy
            ,comment:comment
            ,source:source
            ,failure_client: failure_client
            ,failure_fresh:failure_fresh
            //,method:method

        },
        success: function(data){
            if(data == 1){
                //$("#create_candidat #result").html('<p style="color: Green;">Кандидат успешно записан на собеседование.</p>');
                //var id_vacancy = $('#vacancies_list_in_market tr.selected').attr("id_row");
                //clickOnVacancy(id_vacancy);
                //cancel_candidat(1500);

                $("#result_form").html(data);

            }else{
                $("#result_form").html(data);
            }
        }
    });
}

function cancel_candidat(delay){
    $('#create_candidat').delay(delay).fadeOut();
    clear_candidat();
}

function clear_candidat(){
    $('#create_candidat #fio_candidat').val('');
    $('#create_candidat #phone_candidat').val('');
    $('#create_candidat #age_candidat').val('');
    $('#create_candidat #sources_list_in_market').val('0').change();
}

function reset_candidate(id_candidate){

    $.ajax({
        url: jsPath + "vacanciesoperator/resetcandidate",
        type: "POST",
        data:  { id_candidate:id_candidate},
        success: function(data){
            if(data == 1){
                $.pjax.reload({container:'#pjax_3'});
            }else{
                alert('Ошибка. Данные не обновлены. Код ошибки: ' + data);
            }
        }
    });


}



/*Список источников*/
function getSourcesByMarketsId(id_market){
    selected_source = $('#sources_market').attr("selected_source");
    $.ajax({
        url: jsPath + "vacanciesoperator/getsourcesbymarketsid",
        type: "POST",
        data:  {id_market:id_market, selected_source:selected_source },
        success: function(data){
            $("#sources_market").html(data);
        }
    });
}

function vacancy_refresh() {
    $.pjax.reload({container:'#pjax_1'});
    $.pjax.reload({container:'#pjax_2'});
}

/*Снимает с публикации расписание для магазина*/
function unpublish_timetable_market(Element){
    var id_market = $('#markets-id').val();
    var id_row_timetable =  Element.attr("id_row");
    $.ajax({
        url: jsPath + "vacancies/unpublish_timetable_market",
        type: "POST",
        data:  {id_market:id_market, id_row_timetable },
        success: function(data){
            $("#timetables_market").html(data);
        }
    });
}

/*Снимает с публикации расписание для вакансии*/
function unpublish_timetable_vacancy(Element){
    var id_vacancy = $('#vacancies_list_in_market tr.selected').attr("id_row");
    var id_row_timetable =  Element.attr("id_row");
    $.ajax({
        url: jsPath + "vacancies/unpublish_timetable_vacancy",
        type: "POST",
        data:  {id_vacancy:id_vacancy, id_row_timetable },
        success: function(data){
            $("#timetables_vacancy").html(data);
        }
    });
}

/*Удаляет расписание Магазина*/
function delete_timetable_market(Element){
    var id_market = $('#markets-id').val();
    var id_row_timetable =  Element.attr("id_row");
    $.ajax({
        url: jsPath + "vacancies/delete_timetable_market",
        type: "POST",
        data:  {id_market:id_market, id_row_timetable },
        success: function(data){
            $("#timetables_market").html(data);
        }
    });
}

/*Удаляет расписание Вакансии*/
function delete_timetable_vacancy(Element){
    var id_vacancy = $('#vacancies_list_in_market tr.selected').attr("id_row");
    var id_row_timetable =  Element.attr("id_row");
    $.ajax({
        url: jsPath + "vacancies/delete_timetable_vacancy",
        type: "POST",
        data:  {id_vacancy:id_vacancy, id_row_timetable },
        success: function(data){
            $("#timetables_vacancy").html(data);
        }
    });
}

/*Удаляет Источник информации Магазина*/
function delete_source_from_market(Element){
    var id_market = $('#markets-id').val();
    var id_row_source =  Element.attr("id_row");
    $.ajax({
        url: jsPath + "vacancies/delete_source_market",
        type: "POST",
        data:  {id_market:id_market, id_row_source },
        success: function(data){
            $("#sources_market").html(data);
        }
    });
}